<?php

require_once('exceptions/MissingNameException.php');
require_once('exceptions/InvalidNameException.php');
require_once('exceptions/MissingPasswordException.php');
require_once('exceptions/PermissionException.php');

class LoginUser
{
    private $username;
    private $password;
    private static $MIN_INPUT_VALUE = 1;
    private $permissionStatus;
    const ADMIN_PERMISSION = 'Admin';
    const MOD_PERMISSION = 'Moderator';
    const USER_PERMISSION = 'User';
    const BAN_PERMISSION = 'Ban';

    public function __construct($username, $password, $userPermission)
    {
        $this->setLoginUsername($username);
        $this->setLoginPassword($password);
        $this->setPermission($userPermission);
    }

    private function setLoginUsername($username)
    {
        if (strlen($username) < self::$MIN_INPUT_VALUE) {
            throw new MissingNameException('Username is missing'); //TODO make own exception classes
        }
        if ($username != strip_tags($username)) {
            throw new InvalidNameException('Username contains invalid characters.');
        }
        $this->username = $username;
    }

    private function setLoginPassword($password)
    {
        if (strlen($password) < self::$MIN_INPUT_VALUE) {
            throw new MissingPasswordException('Password is missing');
        }
        $this->password = $password;
    }

    public function setPermission($permission)
    {
        if ($permission == self::BAN_PERMISSION) {
            throw new PermissionException('You are currently banned.');
        }
        $this->permissionStatus = $permission;
    }

    public function getPermission(): string
    {
        return $this->permissionStatus;
    }


    public function getUsername(): string
    {
        return $this->username;
    }
}
