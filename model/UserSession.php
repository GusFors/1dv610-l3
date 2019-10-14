<?php
require_once('User.php');

class UserSession
{
    private $isLoggedIn = false;
    private $user;
    private $statusMessage = '';
    private $currentUser;
    private $storedName;
    const LOGIN_NAME = 'loginName';
    const STORED_MESSAGE = 'storedMessage';

    public function __construct()
    {
        //$this->user = $user;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION[self::LOGIN_NAME]);
    }

    public function sessionLogin($username, $password)
    {

        $this->currentUser = new User();
        $this->currentUser->authorizeUser($username, $password);

        $_SESSION[self::LOGIN_NAME] = $this->currentUser->getUsername();
    }

    public function loginUser()
    {
        $_SESSION[self::LOGIN_NAME] = 'Admin';
    }

    public function logoutUser()
    {
        $_SESSION = [];
    }

    public function isNewLogin()
    {
        if (isset($_SESSION[self::LOGIN_NAME])) {
            return false;
        }
        return true;
    }

    public function tryRegister($username, $password, $passwordRepeat)
    {
        $this->currentUser = new User();
        $this->currentUser->registerUser($username, $password, $passwordRepeat);
    }

    public function setStoredUsername($name)
    {
        $_SESSION['storedname'] = $name;
    }

    public function getStoredUsername()
    {
        if (isset($_SESSION['storedname'])) {
            //return strip_tags($_SESSION['storedname']);
            return $_SESSION['storedname'];
        }
        return '';
    }

    public function setStatusMessage($message)
    {
        if (isset($_SESSION[self::STORED_MESSAGE]) == false) {
            $_SESSION[self::STORED_MESSAGE] = '';
        }
        $_SESSION[self::STORED_MESSAGE] = $message;
    }

    public function getStatusMessage()
    {
        if (isset($_SESSION[self::STORED_MESSAGE])) {
            $msg = $_SESSION[self::STORED_MESSAGE];
            $_SESSION[self::STORED_MESSAGE] = '';
            return $msg;
        }
        return '';
    }
}
