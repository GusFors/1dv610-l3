<?php

class MainController
{

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

        $isRegister = $this->registerController->isRegister();

        if ($isRegister) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
        }
    }
}
