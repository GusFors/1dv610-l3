<?php

class Database
{
    private $dbConnection;
    const MIN_USERNAME_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 6;

    public function __construct()
    {
        if (count(parse_url(getenv('CLEARDB_DATABASE_URL'))) > 1) {
            $url = parse_url(getenv('CLEARDB_DATABASE_URL'));

            $server = $url['host'];
            $dbusername = $url['user'];
            $dbpassword = $url['pass'];
            $db = substr($url['path'], 1);

            $this->dbConnection = mysqli_connect($server, $dbusername, $dbpassword, $db);
        }
    }

    public function isDbConnected()
    {

        if ($this->dbConnection) {

            return true;
        }
        return false;
    }

    public function matchLoginUser($username, $password)
    {
        $sql = "SELECT id FROM users WHERE BINARY username = '$username' AND BINARY password = '$password'"; // början av strängen upprepas?

        $result = mysqli_query($this->dbConnection, $sql);

        $count = mysqli_num_rows($result);


        if ($count == 1) {
            return true;
        } else {
            throw new Exception('Wrong name or password');
            return false;
        }
    }

    public function validateUserRegistration($username, $password, $passwordRepeat)
    {
        $errorMessage = '';
        $isError = false;

        if (strlen($username) < self::MIN_USERNAME_LENGTH) { 
            $errorMessage .= 'Username has too few characters, at least 3 characters.';
            $isError = true;
        }

        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'Password has too few characters, at least 6 characters.';
            $isError = true;
        } else {
            if ($password !== $passwordRepeat) {
                $errorMessage .= 'Passwords do not match.';
                $isError = true;
            }
        }

        if ($username != strip_tags($username)) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'Username contains invalid characters.';
            $isError = true;
        }

        if ($this->isUserTaken($username)) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'User exists, pick another username.';
            $isError = true;
        }

        if ($isError) {
            throw new Exception($errorMessage);
        }
    }

    public function isUserTaken($username)
    {


        $sql = "SELECT id FROM users WHERE BINARY username = '$username' ";

        $result = mysqli_query($this->dbConnection, $sql);

        $count = mysqli_num_rows($result);



        if ($count == 1) {

            return true;
        } else if ($count == 0) {
            return false;
        }
    }
    
}
