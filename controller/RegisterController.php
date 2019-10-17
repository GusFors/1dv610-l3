<?php

require_once('Controller.php'); //TODO Namespace

class RegisterController extends Controller
{
    private $registerView;
    private $layoutView;
    private $userSession;
    private $database;
    private $loginView;

    public function __construct(RegisterView $rv, UserSession $us, LayoutView $laV, Database $db, LoginView $lv)
    {
        $this->registerView = $rv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
        $this->loginView = $lv;
    }

    public function isRegister()
    {
        return $this->registerView->checkRegisterStatus();
    }

    public function doRegisterView()
    {
        $this->userSession->setRegisterPage();
        $this->userSession->setCurrentPage(Application::REGISTER_PAGE);
        $redirect = false;
        $username = $this->registerView->getRequestUsername();
        $password = $this->registerView->getRequestPassword();
        if ($this->registerView->checkRegisterRequest()) {


            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {

                if ($this->database->registerUser($username, $password, $passwordRepeat)) {
                    $redirect = true;
                }
                $this->userSession->tryRegister($username, $password, $passwordRepeat);
            } catch (Exception $ex) {
                $this->userSession->setStatusMessage($ex->getMessage());
            }
        }
        $this->userSession->setStoredUsername($username);
        if ($redirect) {
            $this->userSession->setRegisterMessage();

            $this->userSession->setRedirect(true);
            $this->goToIndex();

            //header('Location:http://localhost/1dv610-l3/index.php?');
        } else {
            $this->layoutView->render($this->registerView, '', $this->userSession->getStoredUsername());
        }
    }
}
