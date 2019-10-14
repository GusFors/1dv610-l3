<?php

class LoginController
{
    private $loginView;
    private $layoutView;
    private $userSession;
    private $statusMessage = '';
    private $dateTimeView;

    public function __construct(LoginView $lv, UserSession $us, LayoutView $laV, DateTimeView $dv)
    {
        $this->loginView = $lv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->dateTimeView = $dv;
    }

    public function isLogin()
    {
        return $this->loginView->isLoginSet();
    }

    public function isLogOut()
    {
        return $this->loginView->getLogoutPost();
    }

    public function loginUser($username, $password)
    {
        try {
            $this->userSession->sessionLogin($username, $password);
        } catch (Exception $ex) {
            $this->userSession->setStatusMessage($ex->getMessage());
        }
    }

    public function doLoginView()
    {
        if ($this->loginView->isLoginSet()) {
            $username = $this->loginView->getRequestUsername();
            $password = $this->loginView->getRequestUserPassword();
            if ($this->userSession->isNewLogin()) {
                //$this->statusMessage = 'Welcome';
                $this->userSession->setStatusMessage('Welcome');
            }
            $this->loginUser($username, $password);
        } else if ($this->isLogOut()) {
            $this->userSession->logoutUser();
            $this->userSession->setStatusMessage('Bye bye!');
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isLoggedIn == false) {
            $this->userSession->setStoredUsername($this->loginView->getRequestUsername());
        }

        $this->layoutView->render($isLoggedIn, $this->loginView, false, $this->userSession->getStatusMessage(), $this->userSession->getStoredUsername());
    }

    public function logoutUser()
    {
        $this->userSession->logoutUser();
    }
}
