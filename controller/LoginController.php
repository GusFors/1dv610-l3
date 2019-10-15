<?php

class LoginController
{
    private $loginView;
    private $layoutView;
    private $userSession;
    private $statusMessage = '';
    private $dateTimeView;
    private $database;

    public function __construct(LoginView $lv, UserSession $us, LayoutView $laV, Database $db)
    {
        $this->loginView = $lv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
    }

    public function isLogin()
    {
        return $this->loginView->isLoginSet();
    }

    public function isLogOut()
    {
        return $this->loginView->getLogoutPost();
    }

    public function loginUser($username, $password)
    {

        try {
            $this->database->isDbConnected();
            $tryUser = new User($username, $password);
            $this->database->matchLoginUser($username, $password);
            $this->userSession->sessionLogin($tryUser);
        } catch (Exception $ex) {
            $this->userSession->setStatusMessage($ex->getMessage());
        }
    }

    public function doLoginView()
    {
        $username = $this->loginView->getRequestUsername();
        $password = $this->loginView->getRequestUserPassword();
        if ($this->loginView->isLoginSet()) {

            if ($this->userSession->isNewLogin()) {
                $this->userSession->setWelcomeMessage();
            }
            $this->loginUser($username, $password);
        } else if ($this->isLogOut()) {
            $wasLoggedIn = $this->userSession->isLoggedIn();
            $this->userSession->logoutUser();
            if ($wasLoggedIn) {
                $this->userSession->setByeMessage();
            }
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isLoggedIn == false) {
            $this->userSession->setStoredUsername($username);
        }

        $this->layoutView->render($isLoggedIn, $this->loginView, false, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
    }

    public function logoutUser()
    {
        $this->userSession->logoutUser();
    }
}
