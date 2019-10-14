<?php

class MainController
{
    private $loginView;
    private $dateTimeView;
    private $registerView;
    private $layoutView;
    private $userSession;
    private $loginController;
    private $registerController;



    public function __construct($loginView, $dateTimeView, $registerView, $layoutView, $userSession, $loginController, $registerController)
    {
        $this->loginController = $loginController;
        $this->registerController = $registerController;
        $this->loginView = $loginView;
        $this->dateTimeView = $dateTimeView;
        $this->registerView = $registerView;
        $this->layoutView = $layoutView;
        $this->userSession = $userSession;
    }

    public function viewRenderOptions()
    {
        $statusMessage = '';
        $isRegister = $this->registerController->isRegister();

        


        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isRegister) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
            //$this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $isRegister, $statusMessage);
        }
    }
}
