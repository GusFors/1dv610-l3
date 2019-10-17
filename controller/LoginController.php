<?php

class LoginController
{
    private $loginView;
    private $layoutView;
    private $adminView;
    private $userSession;
    private $statusMessage = '';
    private $dateTimeView;
    private $database;

    public function __construct(LoginView $lv, UserSession $us, LayoutView $laV, Database $db, AdminView $av)
    {
        $this->loginView = $lv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
        $this->adminView = $av;
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
        $this->userSession->setCurrentPage(Application::INDEX_PAGE);
        if ($this->userSession->isRedirect()) { }
        $username = $this->loginView->getRequestUsername();
        $password = $this->loginView->getRequestUserPassword();
        if ($this->loginView->isLoginSet()) {

            if ($this->userSession->isNewLogin()) {
                if ($this->loginView->isRemember()) {
                    $this->userSession->setRememberMessage();
                } else {
                    $this->userSession->setWelcomeMessage();
                }
            }
            $this->loginUser($username, $password);
        } else if ($this->isLogOut()) {
            $wasLoggedIn = $this->userSession->isLoggedIn();
            $this->userSession->logoutUser();
            if ($wasLoggedIn) {
                $this->userSession->setByeMessage();
            }
        } else if ($this->adminView->isDeletePost()) {
            $deleteId = $this->adminView->getUserId();
            $this->database->deleteUser($deleteId);
        } else if($this->adminView->isDeleteUser()) {
            $deleteId = $this->adminView->getUserID();
            echo $deleteId;
            //$this->database->deleteUser($deleteId);
        } else if ($this->adminView->isPromotePost()) {
            $deleteId = $this->adminView->getUserID();
            $this->database->promoteUser($deleteId);
            echo 'oipndrxspienin';
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isLoggedIn == false) {
            if ($this->userSession->isRedirect() == false) {
                $this->userSession->setStoredUsername($username);
            } else {
                $this->userSession->setRedirect(false);
            }
        }

        $this->layoutView->render($this->loginView, '', $this->userSession->getStoredUsername());
    }

    public function logoutUser()
    {
        $this->userSession->logoutUser();
    }
}
