<?php

class AdminView
{
    private $userSession;
    private $database;

    public function __construct(UserSession $us, Database $db)
    {
        $this->userSession = $us;
        $this->database = $db;
    }

    public function generateAdminView()
    {

        $view = '';
        //TODO add name static and post statics for delete etc
        if ($this->userSession->getSessionUsername() == 'Admin') {
            $view = '<h1>ADMIN HERE</h1>
            <p>' . $this->renderUsers() . '</p>
            <form action="" method="post">
                <p id="   ">  </p>
                <input type"number" name="userid" value="" >
                <input type="submit" name="promote" value="promote"/>
                <input type="submit" name="delete" value="delete"/>
               
			</form>';
        } else {
            $view = '<h1>Not admin</h1>';
        }

        //$response .= $this->generateLogoutButtonHTML($message);
        return $view;
    }

    public function isDeletePost()
    {
        return isset($_POST['delete']);
    }

    public function isPromotePost()
    {
        return isset($_POST['promote']);
    }

    public function getPromoteId() {
        return $_POST['userid'];
    }

    public function isDeleteUser()
    {
        return isset($_POST['deleteuser']);
    }

    private function renderUsers()
    {
        $users = '';
        $userResult = $this->database->getUsers();
        while ($row = $userResult->fetch_assoc()) {
            $userId = $row["id"];
            $users .= "
            <tr>
                <td> " . $row["username"] . " </td>
                <td> " . $userId . " </td>
                <td> " . $row["role"] . "</td>
                
               </tr> 
            </tr>";
        }

        $table = '<form action="" method="post">
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Id</th>
                            <th>Role</th>
                        </tr>
                       <tr>
                            ' . $users . '
                       </tr>
                    </table>
                </form> ';

        return $table;
    }

    public function getDeleteUserID()
    {
        return $_POST['usertodelete'];
    }

    public function getUserId()
    {
        return $_POST['userid'];
    }
}

/*
private function renderUsers()
    {
        $users = '';
        $userResult = $this->database->getUsers();
        while ($row = $userResult->fetch_assoc()) {
            $userId = $row["id"];
            $users .= "
            <tr>
                <td> " . $row["username"] . " </td>
                <td><input type='hidden' name='usertodelete' value='$userId'> " . $userId . " </td>
                <td> " . $row["role"] . "</td>
                <td><input type='submit' name='deleteuser' value='delete'>
               </tr> 
            </tr>";
        }

        $table =  '<form action="" method="post">
        <table>
  <tr>
    <th>Username</th>
    <th>Id</th>
    <th>Role</th>
    <th>Action</th>
  </tr>
  <tr>
    ' . $users . '
  </tr>
  
</table>

</form> 
    ';

        return $table;
    }*/
