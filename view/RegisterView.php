
<?php

class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';
    private $userSession;

    public function __construct(UserSession $userSession)
    {
        $this->userSession = $userSession;
    }

    public function response($message = '')
    {


        $response = $this->generateRegisterFormHTML($message);
        return $response;
    }

    private function generateRegisterFormHTML($message)
    {
        $storedName = $this->userSession->getStoredUsername();
        return '<form action="?register" method="post">
        <fieldset>
        <legend>Register a new user - Write username and password</legend>
            <p id="' . self::$messageId . '">' . $message . '</p>

            <label for="' . self::$name . '">Username :</label>
            <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . $storedName . '">
            <br>
            <label for="' . self::$password . '">Password  :</label>
            <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="">
            <br>
            <label for="' . self::$passwordRepeat . '">Repeat password  :</label>
            <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="">
            <br>
            <input id="submit" type="submit" name="' . self::$register . '" value="Register">
            <br>
        </fieldset>
       </form>';
    }

    public function isRegisterGet(): bool // isregister
    {
        return isset($_GET[Application::REGISTER_PAGE]);
    }

    public function getRequestUsername(): string
    {
        if (isset($_POST[self::$name])) {
            return $_POST[self::$name];
        }
        return '';
    }

    public function getRequestPassword(): string
    {
        if (isset($_POST[self::$password])) {
            return $_POST[self::$password];
        }
        return '';
    }

    public function getRequestPasswordRepeat(): string
    {
        if (isset($_POST[self::$passwordRepeat])) {
            return $_POST[self::$passwordRepeat];
        };
        return '';
    }

    public function isRegisterPost()
    {
        return isset($_POST[self::$register]);
    }
}
