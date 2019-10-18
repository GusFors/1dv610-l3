<?php
require_once('controller/MainController.php');
require_once('controller/LoginController.php');
require_once('controller/RegisterController.php');
require_once('view/AdminView.php');
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/RegisterView.php');
require_once('view/LayoutView.php');
require_once('model/UserSession.php');
require_once('model/UserDatabase.php');

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
    private $database;
    private $adminView;
    const REGISTER_PAGE = 'register';
    const INDEX_PAGE = 'index';

    public function __construct()
    {
        $this->userSession = new UserSession();
        $this->database = new UserDatabase();
        $this->adminView = new AdminView($this->userSession, $this->database);
        $this->loginView = new LoginView($this->userSession, $this->adminView);
        $this->dateTimeView = new DateTimeView();
        $this->registerView = new RegisterView($this->userSession);
        $this->layoutView = new Layoutview($this->dateTimeView, $this->userSession);

        $this->loginController = new LoginController($this->loginView, $this->userSession, $this->layoutView, $this->database, $this->adminView); // TODO; Not so many arguments
        $this->registerController = new RegisterController($this->registerView, $this->userSession, $this->layoutView, $this->database, $this->loginView);
        $this->mainController = new MainController($this->loginController, $this->registerController, $this->userSession, $this->layoutView);
    }

    public function run()
    {
        session_start();
        $this->mainController->viewRenderOptions();
    }
}
