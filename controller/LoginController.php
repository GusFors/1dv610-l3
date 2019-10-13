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
            $this->statusMessage = $ex->getMessage();
        }
    }

    public function doLoginView()
    {
        if ($this->loginView->isLoginSet()) {
            $username = $this->loginView->getRequestUsername();
            $password = $this->loginView->getRequestUserPassword();
            if ($this->userSession->isNewLogin()) {
                $this->statusMessage = 'Welcome';
            }
            $this->loginUser($username, $password);
        } else if ($this->isLogOut()) {
            $this->userSession->logoutUser();
        }

        $isLoggedIn = $this->userSession->isLoggedIn();

        if ($isLoggedIn == false) { }

        $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView, false, $this->statusMessage);
    }

    public function logoutUser()
    {
        $this->userSession->logoutUser();
    }
}
