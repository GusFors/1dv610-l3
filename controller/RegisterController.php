<?php

class RegisterController
{
    private $registerView;
    private $layoutView;
    private $userSession;
    private $database;
    
    public function __construct(RegisterView $rv, UserSession $us, LayoutView $laV, Database $db)
    {
        $this->registerView = $rv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
       
    }

    public function isRegister()
    {
        return $this->registerView->checkRegisterStatus();
    }

    public function doRegisterView()
    {
        $redirect = false;
        $username = $this->registerView->getRequestUsername();
        if ($this->registerView->checkRegisterRequest()) {

            $password = $this->registerView->getRequestPassword();
            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {
                $this->database->validateUserRegistration($username, $password, $passwordRepeat);
                if ($this->database->registerUser($username, $password)) {
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
            //header('Location:http://localhost/1dv610-l3/index.php?');
            header('Location:https://gusfors-l3.herokuapp.com/index.php');
            
            //$this->layoutView->render(false, $this->loginView, false, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername(), '?');
            //header('Location:http://localhost/1dv610-l3/index.php?');
        } else {
            $this->layoutView->render(false, $this->registerView, true, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
        }
    }
}
