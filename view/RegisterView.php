
<?php

class RegisterView
{
    private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $password = 'RegisterView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $messageId = 'RegisterView::Message';

    public function response($message = '')
    {
       

        $response = $this->generateRegisterFormHTML($message);
        return $response;
    }

    private function generateRegisterFormHTML($message)
    {

        return '<form action="?register" method="post" enctype="multipart/form-data">
        <fieldset>
        <legend>Register a new user - Write username and password</legend>
            <p id="' . self::$messageId . '">' . $message . '</p>

            <label for="' . self::$name . '">Username :</label>
            <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="">
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

    public function checkRegisterStatus() {
        if (isset($_GET['register'])) {
            return true;
        } else {
            return false;
        }
    }
}
