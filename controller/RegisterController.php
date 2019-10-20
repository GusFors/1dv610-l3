<?php

require_once('Controller.php');

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

    public function doRegisterView()
    {
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
                $this->userSession->setTemporaryMessage($ex->getMessage());
            }
        }

        $this->userSession->setStoredUsername($username);

        if ($successRedirect) {
            $this->registrationRedirect();
        } else {
            $this->layoutView->render($this->registerView, $this->userSession->grabTemporaryMessage());
        }
    }

    public function isRegisterPage()
    {
        return $this->registerView->isRegisterGet();
    }

    private function registrationRedirect()
    {
        $this->userSession->setRegisterMessage();
        $this->userSession->setRedirect(true);
        $this->goToIndex();
    }
}
