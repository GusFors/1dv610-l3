
<?php

class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    public function response($message = '', $isLoggedIn = false, $storedName)
    {


        $response = $this->generateRegisterFormHTML($message, $storedName);
        return $response;
    }

    private function generateRegisterFormHTML($message, $storedName)
    {
        
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

    public function checkRegisterStatus()
    {
        if (isset($_GET['register'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getRequestUsername()
    {

        if ($this->checkRequestUserName()) {
            return $_POST[self::$name];
        }
        return null;
    }

    private function checkRequestUserName()
    {
        return isset($_POST[self::$name]);
    }

    private function checkRequestPassword()
    {
        return isset($_POST[self::$password]);
    }

    public function getRequestPassword()
    {
        if ($this->checkRequestPassword()) {
            return $_POST[self::$password];
        }
        return null;
    }

    public function getRequestPasswordRepeat()
    {
        if (isset($_POST[self::$passwordRepeat])) {
            return $_POST[self::$passwordRepeat];
        }
        return null;
    }

    public function checkRegisterRequest()
    {
        return isset($_POST[self::$register]);
    }
}
