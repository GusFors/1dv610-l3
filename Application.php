<?php
require_once('controller/MainController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');
require_once('model/UserSession.php');

class Application
{
    private $mainController;
    private $loginController;
    private $loginView;
    private $dateTimeView;
    private $layoutView;
    private $registerView;
    private $userSession;
    private $registerController;

    public function __construct()
    {
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new Layoutview($this->dateTimeView);
        $this->userSession = new UserSession();
        $this->loginController = new LoginController($this->loginView, $this->userSession, $this->layoutView, $this->dateTimeView); // TODO; Not so many arguments
        $this->registerController = new RegisterController($this->registerView, $this->userSession, $this->layoutView, $this->dateTimeView);
        $this->mainController = new MainController($this->loginView, $this->dateTimeView, $this->registerView, $this->layoutView, $this->userSession, $this->loginController, $this->registerController);
    }

    public function run()
    {
        session_start();
        $this->mainController->viewRenderOptions();
    }
}
