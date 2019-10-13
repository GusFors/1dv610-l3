<?php

class MainController
{
    private $loginView;
    private $dateTimeView;
    private $registerView;
    private $layoutView;
    private $userSession;
    


    public function __construct($loginView, $dateTimeView, $registerView, $layoutView, $userSession)
    {
        $this->loginView = $loginView;
        $this->dateTimeView = $dateTimeView;
        $this->registerView = $registerView;
        $this->layoutView = $layoutView;
        $this->userSession = $userSession;
    }

    public function viewRenderOptions()
    {
        $statusMessage = '';
        $isRegister = $this->registerView->checkRegisterStatus();

        if ($this->loginView->getLoginPost()) {
            $username = $this->loginView->getRequestUserName();
            $password = $this->loginView->getRequestUserPassword();

            try {
                $this->userSession->tryLogin($username, $password);
            } catch (Exception $ex) {
                $statusMessage = $ex->getMessage();
            }
        }
        if ($this->loginView->getLogoutPost()) {
            $_SESSION = [];
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isLoggedIn) {
            $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $isRegister, $statusMessage);
        } else if ($isRegister) {
            $this->layoutView->render($isLoggedIn, $this->registerView, $this->dateTimeView, $isRegister, $statusMessage);
        } else {
            $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $isRegister, $statusMessage);
        }
    }
}
