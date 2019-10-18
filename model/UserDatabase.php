<?php

class UserDatabase
{
    private $dbConnection;
    const MIN_USERNAME_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 6;
    private static $DB_URL = 'CLEARDB_DATABASE_URL';
    private static $HOST_URL = 'host';
    private static $USER_URL = 'user';
    private static $PASSWORD_URL = 'pass';
    private static $PATH_URL = 'path';


    public function __construct()
    {
        if (count(parse_url(getenv(self::$DB_URL))) > 1) {
            $url = parse_url(getenv(self::$DB_URL));

            $server = $url[self::$HOST_URL];
            $dbusername = $url[self::$USER_URL];
            $dbpassword = $url[self::$PASSWORD_URL];
            $db = substr($url[self::$PATH_URL], 1);

            $this->dbConnection = mysqli_connect($server, $dbusername, $dbpassword, $db);
            //$this->deleteTable();
            $this->createUserTable();
        } 
    }

    public function isDbConnected()
    {

        if ($this->dbConnection) {

            return true;
        } else {
            throw new Exception('Could not connect to the database.');
        }
    }

    public function matchLoginUser($username, $password)
    {
        $sql = "SELECT id FROM siteusers WHERE BINARY username = '$username' AND BINARY password = '$password'"; // början av strängen upprepas?

        $result = mysqli_query($this->dbConnection, $sql);

        $count = mysqli_num_rows($result);


        if ($count == 1) {
            return true;
        } else {
            throw new Exception('Wrong name or password');
            return false;
        }
    }

    public function getUserRole($username)
    {
        $sql = "SELECT `role` FROM siteusers WHERE BINARY username = '$username'"; // början av strängen upprepas?

        $result = mysqli_query($this->dbConnection, $sql);
        $row = $result->fetch_assoc();
        return ($row["role"]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM `siteusers` WHERE `siteusers`.`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function promoteUser($id)
    {
        $sql = "UPDATE `siteusers` SET `role` = 'Moderator' WHERE `siteusers`.`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function demoteUser($id)
    {
        $sql = "UPDATE `siteusers` SET `role` = 'User' WHERE `siteusers`.`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function banUser($id)
    {
        $sql = "UPDATE `siteusers` SET `role` = 'Ban' WHERE `siteusers`.`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function unbanUser($id)
    {
        $sql = "UPDATE `siteusers` SET `role` = 'User' WHERE `siteusers`.`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function getUsers()
    {
        $sql = "SELECT * FROM `siteusers` ";
        $result = mysqli_query($this->dbConnection, $sql);
        return $result;
    }

    private function createUserTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS siteusers (
            id int(10) AUTO_INCREMENT,
            username varchar(20) NOT NULL,
            password varchar(20) NOT NULL,
            role varchar(20) NOT NULL,
            PRIMARY KEY  (id)
            )";
        $result = mysqli_query($this->dbConnection, $sql);
        $sql = "INSERT INTO siteusers (username, password, role) VALUES ('Admin', 'Password', 'Admin')";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    private function validateUserRegistration($username, $password, $passwordRepeat)
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
                if ($errorMessage !== '') {
                    $errorMessage .= '<br>';
                }
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


        $sql = "SELECT id FROM siteusers WHERE BINARY username = '$username' ";

        $result = mysqli_query($this->dbConnection, $sql);

        $count = mysqli_num_rows($result);



        if ($count == 1) {

            return true;
        } else if ($count == 0) {
            return false;
        }
    }

    public function registerUser($username, $password, $passwordRepeat)
    {
        $this->validateUserRegistration($username, $password, $passwordRepeat);
        $sql = "INSERT INTO siteusers (username, password, role) VALUES ('$username', '$password', 'User')";
        $result = mysqli_query($this->dbConnection, $sql);
        //$count = mysqli_num_rows($result);

        //echo ("Error description: " . mysqli_error($this->dbConnection));


        return $result;
    }

    private function deleteTable() {
        $sql = "DROP TABLE siteusers";

        $result = mysqli_query($this->dbConnection, $sql);
    }
}
