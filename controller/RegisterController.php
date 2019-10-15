<?php

class RegisterController
{
    private $registerView;
    private $layoutView;
    private $userSession;
    private $statusMessage = '';
    private $dateTimeView;
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
        $username = $this->registerView->getRequestUsername();
        if ($this->registerView->checkRegisterRequest()) {

            $password = $this->registerView->getRequestPassword();
            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {
                $this->database->validateUserRegistration($username, $password, $passwordRepeat);
                $this->userSession->tryRegister($username, $password, $passwordRepeat);
            } catch (Exception $ex) {
                $this->userSession->setStatusMessage($ex->getMessage());
            }
        }
        $this->userSession->setStoredUsername($username);
        $this->layoutView->render(false, $this->registerView, true, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
    }
}
