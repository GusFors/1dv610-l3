<?php

require_once('Controller.php'); //TODO Namespace

class RegisterController extends Controller
{
    private $registerView;
    private $layoutView;
    private $userSession;
    private $database;
    private $loginView;

    public function __construct(RegisterView $rv, UserSession $us, LayoutView $laV, UserDatabase $db, LoginView $lv)
    {
        $this->registerView = $rv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
        $this->loginView = $lv;
    }

    public function isRegisterPage()
    {
        return $this->registerView->isRegisterGet();
    }

    public function doRegisterView()
    {
        $this->userSession->setRegisterPage();
        $this->userSession->setCurrentPage(Controller::REGISTER_PAGE);
        $successRedirect = false;

        $username = $this->registerView->getRequestUsername();
        $password = $this->registerView->getRequestPassword();
        $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

        if ($this->registerView->isRegisterPost()) {
            try {
                if ($this->database->registerUser($username, $password, $passwordRepeat)) {
                    $successRedirect = true;
                }
            } catch (Exception $ex) {
                $this->userSession->setStatusMessage($ex->getMessage());
            }
        }

        $this->userSession->setStoredUsername($username);

        if ($successRedirect) {
            $this->registrationRedirect();
         } else {
            $this->layoutView->render($this->registerView, $this->userSession->grabTemporaryMessage());
        }
    }

    private function registrationRedirect()
    {
        $this->userSession->setRegisterMessage();
        $this->userSession->setRedirect(true);
        $this->goToIndex();
    }
}
