<?php

class AdminView // göra moderatorview som adminview extendar med en egen view där promote finns?
{
    private $userSession;
    private $database;
    private static $delete = 'AdminView::delete';
    private static $demote = 'AdminView::demote';
    private static $promote = 'AdminView::promote';
    private static $ban = 'AdminView::ban';
    private static $unban = 'Adminview::unban';
    private static $userId = 'AdminView::userId';


    public function __construct(UserSession $us, UserDatabase $db)
    {
        $this->userSession = $us;
        $this->database = $db;
    }

    public function generateAdminView()
    {
        $view = '<h2>' . $this->userSession->getUserPermissions() . ' options' . '</h2>
            ' . $this->generateAdminTable() . '
            <form action="" method="post">
            <br>
            <legend>Enter user id to edit</legend>
                <p id="   ">  </p>
               ' . $this->generateModOrAdminOptions() . '
            </form>';

        //$response .= $this->generateLogoutButtonHTML($message);
        return $view;
    }

    private function generateModOrAdminOptions(): string
    {
        $ret = '<input type"number" name="' . self::$userId . '" value="" >
        <input type="submit" name="' . self::$ban . '" value="ban"/>
        <input type="submit" name="' . self::$unban . '" value="unban"/>
        <input type="submit" name="' . self::$delete . '" value="delete"/>';
        
        if ($this->userSession->getUserPermissions() == LoginUser::ADMIN_PERMISSION) {
            $ret .= '<input type="submit" name="' . self::$promote . '" value="promote"/>
                    <input type="submit" name="' . self::$demote . '" value="demote"/>';
        }
        return $ret;
    }

    public function isDeletePost()
    {
        return isset($_POST[self::$delete]);
    }

    public function isPromotePost()
    {
        return isset($_POST[self::$promote]);
    }

    public function isDemotePost()
    {
        return isset($_POST[self::$demote]);
    }

    public function isBanPost()
    {
        return isset($_POST[self::$ban]);
    }

    public function isUnbanPost()
    {
        return isset($_POST[self::$unban]);
    }

    public function getPromoteId()
    {
        return $_POST[self::$userId];
    }

    private function generaterUserTable(): string
    {
        $usersTable = '';
        $userResult = $this->database->getUsers();
        while ($row = $userResult->fetch_assoc()) {
            if ($row["role"] !== LoginUser::ADMIN_PERMISSION) {
                $userId = $row["id"];
                $usersTable .= "
                <tr>
                    <td> " . $row["username"] . " </td>
                    <td> " . $userId . " </td>
                    <td> " . $row["role"] . "</td> 
                </tr>";
            }
        }
        return $usersTable;
    }

    private function generateAdminTable(): string
    {
        $table = '<table>
                    <tr>
                        <th>Username</th>
                        <th>Id</th>
                        <th>Role</th>
                    </tr>
                    <tr>
                        ' . $this->generaterUserTable() . '
                    </tr>
                </table>
                 ';

        return $table;
    }

    public function getUserId(): string
    {
        return $_POST[self::$userId];
    }
}
