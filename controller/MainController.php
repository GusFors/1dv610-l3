<?php

class MainController
{

    private $loginController;
    private $registerController;
    private $userSession;
    private $layoutView;



    public function __construct(LoginController $loginController, RegisterController $registerController, UserSession $us, LayoutView $lv)
    {
        $this->loginController = $loginController;
        $this->registerController = $registerController;
        $this->userSession = $us;
        $this->layoutView = $lv;
        // $this->dateTimeView = $dateTimeView;


    }

    public function viewRenderOptions()
    {
        //if ($this->userSession->isRedirect()) {
        //  $this->loginController->doLoginView();
        //} else 
        if ($this->registerController->isRegister()) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
        }
    }
}
