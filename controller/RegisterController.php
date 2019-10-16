<?php

class RegisterController
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
        $redirect = false;
        $username = $this->registerView->getRequestUsername();
        $password = $this->registerView->getRequestPassword();
        if ($this->registerView->checkRegisterRequest()) {


            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {
                $this->database->validateUserRegistration($username, $password, $passwordRepeat);
                if ($this->database->registerUser($username, $password)) {
                    $redirect = true;

                    //$this->userSession->isRedirect();


                }
                $this->userSession->tryRegister($username, $password, $passwordRepeat);
            } catch (Exception $ex) {
                $this->userSession->setStatusMessage($ex->getMessage());
            }
        }
        $this->userSession->setStoredUsername($username);
        if ($redirect) {
            $this->userSession->setRegisterMessage();
            //$this->userSession->setStoredUsername($username);
            //header('Location: ./index.php');
            $this->userSession->setRedirect(true);
            header('Location: ' . $_SERVER['PHP_SELF']);
            //$this->userSession->setStoredUsername($username);
            //header('Location:https://gusfors-l3.herokuapp.com/index.php');

            //$this->layoutView->render(false, $this->loginView, false, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());

            //$_SESSION['redir'] = 'yes';
            //header('Location:http://localhost/1dv610-l3/index.php?');
        } else {
            $this->layoutView->render($this->registerView, true, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
        }
    }
}
