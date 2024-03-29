<?php

require_once('Controller.php');

class LoginController extends Controller
{
    private $loginView;
    private $layoutView;
    private $adminView;
    private $userSession;
    private $database;

    public function __construct(LoginView $lv, UserSession $us, LayoutView $laV, UserDatabase $db, AdminView $av)
    {
        $this->loginView = $lv;
        $this->userSession = $us;
        $this->layoutView = $laV;
        $this->database = $db;
        $this->adminView = $av;
    }

    public function doLoginView()
    {
        $this->userSession->setCurrentPage(Controller::INDEX_PAGE);

        if ($this->loginView->isLoginPost()) {
            $this->loginHandler();
        } else if ($this->loginView->isLogoutPost()) {
            $this->logoutHandler();
        } else {
            $this->adminOptions();
        }
        $this->ifBeenRedirected();

        $this->layoutView->render($this->loginView, $this->userSession->grabTemporaryMessage());
    }

    private function adminOptions()
    {
        try {
            //TODO: Add feedback/status message on actions and avoid too many else if to read clearly
            if ($this->adminView->isDeletePost()) {
                $this->database->deleteUser($this->adminView->getUserId());
            } else if ($this->adminView->isPromotePost()) {
                $this->database->promoteUser($this->adminView->getUserId());
            } else if ($this->adminView->isDemotePost()) {
                $this->database->demoteUser($this->adminView->getUserId());
            } else if ($this->adminView->isBanPost()) {
                $this->database->banUser($this->adminView->getUserId());
            } else if ($this->adminView->isUnbanPost()) {
                $this->database->unbanUser($this->adminView->getUserId());
            }
        } catch (Exception $ex) {
            $this->userSession->setTemporaryMessage($ex->getMessage());
        }
    }

    private function loginUser($username, $password)
    {
        try {
            $this->database->isDbConnected();
            $userPermission = $this->database->getUserRole($username);
            $tryUser = new LoginUser($username, $password, $userPermission);

            $this->database->matchLoginUser($username, $password);
            $tryUser->setPermission($this->database->getUserRole($username));

            $this->userSession->sessionLogin($tryUser);
        } catch (Exception $ex) {
            $this->userSession->setTemporaryMessage($ex->getMessage());
        }
    }

    private function loginMsgHandler()
    {
        if ($this->userSession->isNewLogin()) {
            if ($this->loginView->isRemember()) {
                $this->userSession->setRememberMessage();
            } else {
                $this->userSession->setWelcomeMessage();
            }
        }
    }

    private function loginHandler()
    {
        $username = $this->loginView->getRequestUsername();
        $password = $this->loginView->getRequestUserPassword();
        $this->loginMsgHandler();
        $this->loginUser($username, $password);
    }

    private function logoutHandler()
    {
        $wasLoggedIn = $this->userSession->isLoggedIn();
        $this->userSession->logoutUser();
        if ($wasLoggedIn) {
            $this->userSession->setByeMessage();
        }
    }

    // Makes sure that saved username from registerpage is not cleared after registration
    private function ifBeenRedirected()
    {
        if ($this->userSession->isRedirect() == false) {
            $this->userSession->setStoredUsername($this->loginView->getRequestUsername());
        } else {
            $this->userSession->setRedirect(false);
        }
    }
}
