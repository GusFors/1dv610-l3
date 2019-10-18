<?php

require_once('exceptions/DbConnectionException.php');
require_once('exceptions/InvalidMatchException.php');

//TODO: wrap database to make storing users "interface" less dependent on a sql database, add more statics for sql statements, and add exceptions to some functions
class UserDatabase
{
    private $dbConnection;
    const MIN_USERNAME_LENGTH = 3;
    const MIN_PASSWORD_LENGTH = 6;
    private static $DB_URL = 'CLEARDB_DATABASE_URL';
    private static $HOST_URL = 'host';
    private static $USER_URL = 'user';
    private static $PASSWORD_URL = 'pass';
    private static $PATH_URL = 'path';
    private static $USER_TABLE = 'siteusers';
    private static $USER_ROLE = 'role';

    public function __construct() {
        if (count(parse_url(getenv(self::$DB_URL))) > 1) {
            $url = parse_url(getenv(self::$DB_URL));

            $server = $url[self::$HOST_URL];
            $dbusername = $url[self::$USER_URL];
            $dbpassword = $url[self::$PASSWORD_URL];
            $db = substr($url[self::$PATH_URL], 1);

            $this->dbConnection = mysqli_connect($server, $dbusername, $dbpassword, $db);
        }
    }

    public function isDbConnected(): bool {
        if ($this->dbConnection) {
            return true;
        } else {
            throw new DbConnectionException('Could not connect to the database.');
        }
    }

    public function matchLoginUser($username, $password): bool {
        $sql = "SELECT id FROM " . self::$USER_TABLE . " WHERE BINARY username = '$username' AND BINARY password = '$password'";

        $result = mysqli_query($this->dbConnection, $sql);

        $match = mysqli_num_rows($result);

        if ($match == 1) {
            return true;
        } else {
            throw new InvalidMatchException('Wrong name or password');
        }
    }

    //TODO: add exceptions for non successful attempts/results
    public function deleteUser($id) {
        $sql = "DELETE FROM  " . self::$USER_TABLE . "  WHERE  " . self::$USER_TABLE . " .`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function promoteUser($id) {
        $sql = "UPDATE  " . self::$USER_TABLE . "  SET  " . self::$USER_ROLE . "  = 'Moderator' WHERE  " . self::$USER_TABLE . " .`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function demoteUser($id) {
        $sql = "UPDATE  " . self::$USER_TABLE . "  SET " . self::$USER_ROLE . " = 'User' WHERE  " . self::$USER_TABLE . " .`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function banUser($id) {
        $sql = "UPDATE  " . self::$USER_TABLE . "  SET " . self::$USER_ROLE . " = 'Ban' WHERE  " . self::$USER_TABLE . " .`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function unbanUser($id) {
        $sql = "UPDATE  " . self::$USER_TABLE . "  SET " . self::$USER_ROLE . " = 'User' WHERE  " . self::$USER_TABLE . " .`id` = $id";
        $result = mysqli_query($this->dbConnection, $sql);
    }

    public function getUsers() {
        $sql = "SELECT * FROM  " . self::$USER_TABLE . "  ";
        $result = mysqli_query($this->dbConnection, $sql);
        return $result;
    }

    public function getUserRole($username) {
        $sql = "SELECT " . self::$USER_ROLE . " FROM  " . self::$USER_TABLE . "  WHERE BINARY username = '$username'";
        $result = mysqli_query($this->dbConnection, $sql);
        $row = $result->fetch_assoc();
        return ($row[self::$USER_ROLE]);
    }

    private function createUserTable() {
        $sql = "CREATE TABLE IF NOT EXISTS  " . self::$USER_TABLE . "  (
            id int(10) AUTO_INCREMENT,
            username varchar(20) NOT NULL,
            password varchar(20) NOT NULL,
            role varchar(20) NOT NULL,
            PRIMARY KEY  (id)
            )";
        $result = mysqli_query($this->dbConnection, $sql);
        $sql = "INSERT INTO  " . self::$USER_TABLE . "  (username, password, role) VALUES ('Admin', 'Password', 'Admin')";
        $result = mysqli_query($this->dbConnection, $sql);
    }


    //TODO: make function smaller and avoid the ifs, especially for adding <br>
    private function validateUserRegistration($username, $password, $passwordRepeat) {
        $errorMessage = '';
        $isError = false;

        if (strlen($username) < self::MIN_USERNAME_LENGTH) {
            $errorMessage .= 'Username has too few characters, at least 3 characters.';
            $isError = true;
        }

        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'Password has too few characters, at least 6 characters.';
            $isError = true;
        } else {
            if ($password !== $passwordRepeat) {
                if ($errorMessage !== '') {
                    $errorMessage .= '<br>';
                }
                $errorMessage .= 'Passwords do not match.';
                $isError = true;
            }
        }

        if ($username != strip_tags($username)) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'Username contains invalid characters.';
            $isError = true;
        }

        if ($this->isUserTaken($username)) {
            if ($errorMessage !== '') {
                $errorMessage .= '<br>';
            }
            $errorMessage .= 'User exists, pick another username.';
            $isError = true;
        }

        if ($isError) {
            throw new Exception($errorMessage);
        }
    }

    public function isUserTaken($username) : bool {
        $sql = "SELECT id FROM  " . self::$USER_TABLE . "  WHERE BINARY username = '$username' ";

        $result = mysqli_query($this->dbConnection, $sql);

        $match = mysqli_num_rows($result);

        if ($match == 1) {
            return true;
        } else if ($match == 0) {
            return false;
        }
    }

    public function registerUser($username, $password, $passwordRepeat) {
        $this->isDbConnected();
        $this->validateUserRegistration($username, $password, $passwordRepeat);
        $sql = "INSERT INTO  " . self::$USER_TABLE . "  (username, password, " . self::$USER_ROLE . ") VALUES ('$username', '$password', 'User')";
        $result = mysqli_query($this->dbConnection, $sql);
        return $result;
    }

    private function deleteTable() {
        $sql = "DROP TABLE  " . self::$USER_TABLE . " ";
        $result = mysqli_query($this->dbConnection, $sql);
    }
}
