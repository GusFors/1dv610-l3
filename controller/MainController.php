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



    public function __construct(LoginController $loginController, RegisterController $registerController)
    {
        $this->loginController = $loginController;
        $this->registerController = $registerController;

        // $this->dateTimeView = $dateTimeView;


    }

    public function viewRenderOptions()
    {
        $statusMessage = '';
        $isRegister = $this->registerController->isRegister();






        if ($isRegister) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
            //$this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, $isRegister, $statusMessage);
        }
    }
}
