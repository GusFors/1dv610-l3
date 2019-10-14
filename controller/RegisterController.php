<?php

class RegisterController
{
    private $registerView;
    private $layoutView;
    private $userSession;
    private $statusMessage = '';
    private $dateTimeView;

    public function __construct(RegisterView $rv, UserSession $us, LayoutView $laV, DateTimeView $dv)
    {
        $this->registerView = $rv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->dateTimeView = $dv;
    }

    public function isRegister()
    {
        return $this->registerView->checkRegisterStatus();
    }

    public function doRegisterView()
    {
        if ($this->registerView->checkRegisterRequest()) {
            $username = $this->registerView->getRequestUsername();
            $password = $this->registerView->getRequestPassword();
            $passwordRepeat = $this->registerView->getRequestPasswordRepeat();

            try {
                $this->userSession->tryRegister($username, $password, $passwordRepeat);
            } catch (Exception $ex) {
                $this->userSession->setStatusMessage($ex->getMessage());
                $this->userSession->setStoredUsername($username);
            }
        }

        $this->layoutView->render(false, $this->registerView, true, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
    }
}
