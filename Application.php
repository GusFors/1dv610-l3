<?php
require_once('controller/MainController.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');
require_once('model/UserSession.php');

class Application
{
    private $mainController;
    private $loginView;
    private $dateTimeView;
    private $layoutView;
    private $registerView;
    private $userSession;

    public function __construct()
    {
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView();
        $this->layoutView = new Layoutview();
        $this->userSession = new UserSession();
        $this->mainController = new MainController($this->loginView, $this->dateTimeView, $this->registerView, $this->layoutView, $this->userSession);
    }

    public function run()
    {
        $this->mainController->viewRenderOptions();
    }
}
