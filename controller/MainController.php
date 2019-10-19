<?php

require_once('Controller.php');

//TODO Namespaces

class MainController extends Controller
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
        if ($this->registerController->isRegisterPage()) {
            $this->registerController->doRegisterView();
        } else {
            $this->loginController->doLoginView();
        }
    }
}
