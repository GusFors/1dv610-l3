<?php

require_once('LoginUser.php');

class UserSession
{
    private static $LOGIN_NAME = 'loginName';
    private static $STORED_MESSAGE = 'storedMessage';
    private static $STORED_NAME = 'storedName';
    private static $REGISTER_PAGE = 'registerPage';
    private static $SESSION_REDIRECT_STATUS = 'redirect';
    private static $USER_PERMISSIONS = 'permission';

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
        $_SESSION[self::$LOGIN_NAME] = $sessionUser->getUsername();
        $_SESSION[self::$USER_PERMISSIONS] = $sessionUser->getPermission();
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

     // A set message is only displayed once
    public function setTemporaryMessage($message)
    {
        if (isset($_SESSION[self::$STORED_MESSAGE]) == false) {
            $_SESSION[self::$STORED_MESSAGE] = '';
        }
        $_SESSION[self::$STORED_MESSAGE] = $message;
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

    public function setCurrentPage($page)
    {
        $this->currentPage = $page;
    }

    public function getCurrentpage(): string
    {
        return $this->currentPage;
    }

}
