<?php
require_once('User.php');

class UserSession
{

    private $currentUser;
    private static $LOGIN_NAME = 'loginName'; //TODO ändra till privata variabler
    private static $STORED_MESSAGE = 'storedMessage';
    private static $STORED_NAME = 'storedname';
    private static $REGISTER_PAGE = 'registerpage';
    private static $SESSION_REDIRECT_STATUS = 'redirect';
    private $currentPage;

    public function __construct()
    {
        //$this->user = $user;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION[self::$LOGIN_NAME]);
    }

    public function sessionLogin(User $sessionUser)
    {

        $this->currentUser = $sessionUser;
        //$this->currentUser->authorizeUser($username, $password);

        $_SESSION[self::$LOGIN_NAME] = $this->currentUser->getUsername();
    }

    public function loginUser()
    {
        $_SESSION[self::$LOGIN_NAME] = $this->currentUser->getUsername();
    }

    public function logoutUser()
    {
        $_SESSION = [];
    }

    public function isNewLogin()
    {
        if (isset($_SESSION[self::$LOGIN_NAME])) {
            return false;
        }
        return true;
    }

    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
    }

    public function getCurrentpage()
    {
        return $this->currentPage;
    }

    public function setRegisterPage()
    {
        $_SESSION[self::$REGISTER_PAGE] = true;
    }

    public function isRegister(): bool
    {
        if (isset($_SESSION[self::$REGISTER_PAGE])) {
            return $_SESSION[self::$REGISTER_PAGE];
        } else {
            return false;
        }
    }

    public function tryRegister($username, $password, $passwordRepeat) // onödig?
    {
        //$this->currentUser = new User($username, $password); // flytta?
        //$this->currentUser->registerUser($username, $password, $passwordRepeat);
    }

    public function setStoredUsername($name)
    {
        $_SESSION[self::$STORED_NAME] = strip_tags($name);
    }

    public function getStoredUsername()
    {
        if (isset($_SESSION[self::$STORED_NAME])) {
            //return strip_tags($_SESSION['storedname']);
            return $_SESSION[self::$STORED_NAME];
        }
        return '';
    }

    public function setStatusMessage($message)
    {
        if (isset($_SESSION[self::$STORED_MESSAGE]) == false) {
            $_SESSION[self::$STORED_MESSAGE] = '';
        }
        $_SESSION[self::$STORED_MESSAGE] = $message;
    }

    public function setWelcomeMessage()
    {
        $this->setStatusMessage('Welcome');
    }

    public function setRememberMessage()
    {
        $this->setStatusMessage('Welcome and you will be remembered');
    }

    public function setByeMessage()
    {
        $this->setStatusMessage('Bye bye!');
    }

    public function setRegisterMessage()
    {
        $this->setStatusMessage('Registered new user.');
    }

    public function grabTemporaryMessage(): string
    {
        if (isset($_SESSION[self::$STORED_MESSAGE])) {
            $msg = $_SESSION[self::$STORED_MESSAGE];
            $_SESSION[self::$STORED_MESSAGE] = '';
            return $msg;
        }
        return '';
    }

    public function setRedirect(bool $isRedir)
    {
        $_SESSION[self::$SESSION_REDIRECT_STATUS] = $isRedir;
    }

    public function isRedirect()
    {
        if (isset($_SESSION[self::$SESSION_REDIRECT_STATUS])) {
            return  $_SESSION[self::$SESSION_REDIRECT_STATUS];
        }
        return false;
    }
}
