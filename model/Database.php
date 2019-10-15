<?php

class Database
{
    private $dbConnection;

    public function __construct()
    {
        if (count(parse_url(getenv('CLEARDB_DATABASE_URL'))) > 1) {
            $url = parse_url(getenv('CLEARDB_DATABASE_URL'));

            $server = $url['host'];
            $dbusername = $url['user'];
            $dbpassword = $url['pass'];
            $db = substr($url['path'], 1);

            $this->dbConnection = mysqli_connect($server, $dbusername, $dbpassword, $db);
        }
    }

    public function isDbConnected()
    {

        if ($this->dbConnection) {
            echo ('uwu');
            return true;
        }
        return false;
    }

    public function matchLoginUser($username, $password)
    {
        $sql = "SELECT id FROM users WHERE BINARY username = '$username' AND BINARY password = '$password'";

        $result = mysqli_query($this->dbConnection, $sql);
        if (empty($result)) {
            $this->createUserTable();
        }


        $count = mysqli_num_rows($result);


        if ($count == 1) {
            return true;
        } else {
            throw new Exception('Wrong name or password', 1);
            return false;
        }
    }

    private function createUserTable()
    {
        $sql = "CREATE TABLE users (
            id int(10) AUTO_INCREMENT,
            username varchar(20) NOT NULL,
            password varchar(20) NOT NULL,
            PRIMARY KEY  (id)
            )";
        $result = mysqli_query($this->dbConnection, $sql);
        $sql = "INSERT INTO users (username, password) VALUES ('Admin', 'Password')";
        $result = mysqli_query($this->dbConnection, $sql);
    }
}
