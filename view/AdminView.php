<?php

class AdminView
{
    private $userSession;
    private $database;
    private static $delete = 'AdminView::delete';
    private static $demote = 'AdminView::demote';
    private static $promote = 'AdminView::promote';
    private static $ban = 'AdminView::ban';
    private static $unban = 'Adminview::unban';
    private static $userId = 'AdminView::userId';
    private static $userRole = 'role';


    public function __construct(UserSession $us, UserDatabase $db)
    {
        $this->userSession = $us;
        $this->database = $db;
    }

    public function generateAdminView()
    {
        $view = '<h2>' . $this->userSession->getUserPermissions() . ' options' . '</h2>
            ' . $this->generateAdminTable() . '
            <form method="post">
            <br>
               ' . $this->generateModOrAdminOptions() . '
            </form>';
        return $view;
    }

    private function generateModOrAdminOptions(): string
    {
        $ret = '<input type="text" name="' . self::$userId . '" placeholder="Enter user id to edit" >
        <input type="submit" name="' . self::$ban . '" value="ban"/>
        <input type="submit" name="' . self::$unban . '" value="unban"/>
        <input type="submit" name="' . self::$delete . '" value="delete"/>';

        if ($this->userSession->getUserPermissions() == LoginUser::ADMIN_PERMISSION) {
            $ret .= '<input type="submit" name="' . self::$promote . '" value="promote"/>
                    <input type="submit" name="' . self::$demote . '" value="demote"/>';
        }
        return $ret;
    }

    public function isDeletePost(): bool
    {
        return isset($_POST[self::$delete]);
    }

    public function isPromotePost(): bool
    {
        return isset($_POST[self::$promote]);
    }

    public function isDemotePost(): bool
    {
        return isset($_POST[self::$demote]);
    }

    public function isBanPost(): bool
    {
        return isset($_POST[self::$ban]);
    }

    public function isUnbanPost(): bool
    {
        return isset($_POST[self::$unban]);
    }

    public function getUserId(): string
    {
        return $_POST[self::$userId];
    }

    private function generateAdminTable(): string
    {
        $table = '<table>
                    <tr>
                        <th>Username</th>
                        <th>Id</th>
                        <th>Role</th>
                    </tr>
                        ' . $this->generaterUserTable() . '
                </table>
                 ';

        return $table;
    }

    private function generaterUserTable(): string
    {
        $usersTable = '';
        $userResult = $this->database->getUsers();
        
        while ($row = $userResult->fetch_assoc()) {
            if ($row[self::$userRole] !== LoginUser::ADMIN_PERMISSION) {
                $userId = $row["id"];
                $usersTable .= "
                <tr>
                    <td> " . $row["username"] . " </td>
                    <td> " . $userId . " </td>
                    <td> " . $row[self::$userRole] . "</td> 
                </tr>";
            }
        }
        return $usersTable;
    }
}
