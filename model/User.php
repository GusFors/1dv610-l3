<?php

class User
{
    private $username;
    private $password;

    public function __construct($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->checkUserMatch();
    }

    private function setUsername($username)
    {
        if (strlen($username) < 1) {
            throw new Exception('Username is missing', 1);
        }
        $this->username = $username;
    }

    private function setPassword($password)
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
}
