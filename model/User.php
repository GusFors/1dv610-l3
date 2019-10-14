<?php

class User
{
    private $username;
    private $password;
    const MIN_USERNAME_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 6;

    public function __construct()
    { }

    private function setLoginUsername($username)
    {
        if (strlen($username) < 1) {
            throw new Exception('Username is missing', 1);
        }
        if ($username != strip_tags($username)) {
            throw new Exception('Username contains invalid characters.', 1);
        }
        $this->username = $username;
    }

    private function setLoginPassword($password)
    {
        if (strlen($password) < 1) {
            throw new Exception('Password is missing', 1);
        }
        $this->password = $password;
    }

    private function checkUserMatch()
    {
        if ($this->username == 'Admin' && $this->password == 'Password') {
            //
        } else {
            throw new Exception('Wrong name or password', 1);
        }
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function authorizeUser($username, $password)
    {
        $this->setLoginUsername($username);
        $this->setLoginPassword($password);
        $this->checkUserMatch();
    }

    public function registerUser($username, $password, $passwordRepeat)
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
        
        if($isError) {
            throw new Exception($errorMessage, 1);
            
        }
    }
}
