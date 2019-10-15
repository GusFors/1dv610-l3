<?php

class MainController
{

    private $loginController;
    private $registerController;
    private $userSession;



    public function __construct(LoginController $loginController, RegisterController $registerController, UserSession $us)
    {
        $this->loginController = $loginController;
        $this->registerController = $registerController;
        $this->userSession = $us;
        // $this->dateTimeView = $dateTimeView;


    }

    public function viewRenderOptions()
    {

        $isRegister = $this->registerController->isRegister();
        //if ($this->userSession->isRedirect()) {
          //  $this->loginController->doLoginView();
        //} else 
        if ($isRegister) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
        }
    }
}
