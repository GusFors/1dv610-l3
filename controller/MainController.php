<?php

class MainController
{
    private $loginView;
    private $dateTimeView;
    private $registerView;
    private $layoutView;
    private $userSession;
    private $loginController;



    public function __construct($loginView, $dateTimeView, $registerView, $layoutView, $userSession, $loginController)
    {
        $this->loginController = $loginController;
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

        

        if ($this->registerView->checkRegisterRequest()) {
            $username = $this->registerView->getRequestUsername();
            $password = $this->registerView->getRequestPassword();
            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {
                $this->userSession->tryRegister($username, $password, $passwordRepeat);
            } catch (Exception $ex) {
                $statusMessage = $ex->getMessage();
            }
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isRegister) {
            $this->layoutView->render($isLoggedIn, $this->registerView, $this->dateTimeView, $isRegister, $statusMessage);
        } else {
            $this->loginController->doLoginView();
            //$this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $isRegister, $statusMessage);
        }
    }
}
