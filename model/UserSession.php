<?php
require_once('User.php');

class UserSession
{
    private $isLoggedIn = false;
    private $user;
    private $statusMessage = '';
    private $currentUser;

    public function __construct()
    {
        //$this->user = $user;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['username']);
    }

    public function sessionLogin($username, $password)
    {

        $this->currentUser = new User();
        $this->currentUser->loginUser($username, $password);

        $_SESSION['username'] = $this->currentUser->getUsername();
    }

    public function loginUser()
    {
        $_SESSION['username'] = 'Admin';
    }

    public function logoutUser()
    {
        $_SESSION = [];
    }

    public function isNewLogin()
    {
        if (isset($_SESSION['username'])) {
            return false;
        }
        return true;
    }

    public function tryRegister($username, $password, $passwordRepeat)
    {
        $this->currentUser = new User();
        $this->currentUser->registerUser($username, $password, $passwordRepeat);
    }
}
