<?php
require_once('LoginUser.php');

class UserSession
{

    private $currentUser;
    private static $LOGIN_NAME = 'loginName'; //TODO ändra till privata variabler
    private static $STORED_MESSAGE = 'storedMessage';
    private static $STORED_NAME = 'storedName';
    private static $REGISTER_PAGE = 'registerPage';
    private static $SESSION_REDIRECT_STATUS = 'redirect';
    private static $USER_PERMISSIONS = 'permission';
    private $currentPage;

    public function __construct()
    {
        //$this->user = $user;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION[self::$LOGIN_NAME]);
    }

    public function getSessionUsername(): string
    {
        return $_SESSION[self::$LOGIN_NAME];
    }

    public function sessionLogin(LoginUser $sessionUser)
    {

        //$this->currentUser->authorizeUser($username, $password);
        $_SESSION[self::$LOGIN_NAME] = $sessionUser->getUsername();
        $_SESSION[self::$USER_PERMISSIONS] = $sessionUser->getPermission();
    }

    public function loginUser()
    {
        $_SESSION[self::$LOGIN_NAME] = $this->currentUser->getUsername();
    }

    public function logoutUser()
    {
        $_SESSION = [];
    }

    public function getUserPermissions(): string
    {
        return $_SESSION[self::$USER_PERMISSIONS];
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

    public function getCurrentpage(): string
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

    public function setStoredUsername($name)
    {
        $_SESSION[self::$STORED_NAME] = strip_tags($name);
    }

    public function getStoredUsername(): string
    {
        if (isset($_SESSION[self::$STORED_NAME])) {
            return $_SESSION[self::$STORED_NAME];
        }
        return '';
    }

    public function setTemporaryMessage($message)
    {
        if (isset($_SESSION[self::$STORED_MESSAGE]) == false) {
            $_SESSION[self::$STORED_MESSAGE] = '';
        }
        $_SESSION[self::$STORED_MESSAGE] = $message;
    }

    public function setWelcomeMessage()
    {
        $this->setTemporaryMessage('Welcome');
    }

    public function setRememberMessage()
    {
        $this->setTemporaryMessage('Welcome and you will be remembered');
    }

    public function setByeMessage()
    {
        $this->setTemporaryMessage('Bye bye!');
    }

    public function setRegisterMessage()
    {
        $this->setTemporaryMessage('Registered new user.');
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

    public function isRedirect(): bool
    {
        if (isset($_SESSION[self::$SESSION_REDIRECT_STATUS])) {
            return  $_SESSION[self::$SESSION_REDIRECT_STATUS];
        }
        return false;
    }
}
