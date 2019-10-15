<?php

class User
{
    private $username;
    private $password;
    const MIN_USERNAME_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 6;

    public function __construct($username, $password)
    {
        $this->setLoginUsername($username);
        $this->setLoginPassword($password);
     
    }

    private function setLoginUsername($username)
    {
        if (strlen($username) < 1) {
            throw new Exception('Username is missing'); //TODO make own exception classes
        }
        if ($username != strip_tags($username)) {
            throw new Exception('Username contains invalid characters.');
        }
        $this->username = $username;
    }

    private function setLoginPassword($password)
    {
        if (strlen($password) < 1) {
            throw new Exception('Password is missing');
        }
        $this->password = $password;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

   

}
