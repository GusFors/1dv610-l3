# Login_1DV610
Repository for 1DV610 l3


This login module provides extra admin functionality for handling registered users.


### Testing
It currently fulfills 81% of the requirements from: [Test cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md).
The not implemented requirements are the ones related to cookie/hijacking, Test cases 3.3 - 3.8.
The app does not currently give text feedback when modifying/deleting users as admin/moderator.

To test the applications functionality, see the test cases below in this readme and go to the apps [url](https://gusfors-l3.herokuapp.com/index.php?).

If you would rather test it locally follow these steps:

#### Installation
* Install XAMPP on your computer.
* Clone the project in your ```"xampp/htdocs"``` folder.
* Start "Apache" and "MySQL" from the XAMPP control panel.
* Open "phpmyadmin" from the XAMPP control panel and create a table called "siteusers".
* Enter the following SQL query: ```INSERT INTO siteusers (username, password, role) VALUES ('Admin', 'Password', 'Admin')```
(Feel free to replace the username and password).
* Open the file called ```"UserDatabase.php"```.
* Replace the content of the  ```"connectToDb()"``` function with:
  
```

$server = "YOUR_SERVER_HOSTURL_HERE";
$dbusername = YOUR_DB_USERNAME_HERE;
$dbpassword = YOUR_DB_PASSWORD_HERE;
$db = YOUR_DB_NAME_HERE;

$this->dbConnection = mysqli_connect($server, $dbusername, $dbpassword, $db);
```
(It is recommended to load these variables from either a gitignored class file or your local environment variables).
* Go to localhost/YOUR_FOLDER_IN_HTDOCS.php

<br>

## UC1 Authenticate user (added alternate scenarios)

<hr>

### Main scenario

1. Starts when a user wants to authenticate.
2. System asks for username, password, and if system should save the user credentials
3. User provides username and password
4. System authenticates the user and presents that authentication succeeded


### Alternate scenarios
* 3b. User provides admin credentials.
  * 1. The system authenticates the user and presents extra admin options
* 3c. User provides moderator credentials.
  * 1. The system authenticates the user and presents extra moderator options
* 4b. User provides banned user credentials.
  * 1. The system presents a ban error message

<br>

## UC5 Delete a registered user
<hr>

### Precondition
UC1. 3b/c User provides authenticated admin/moderator credentials.

### Main scenario
1. User wants to delete a registered user.
2. System asks for user id.
3. User enters id and enters delete action.
4. System deletes the given user and presents feedback.

## UC6 Change a registered user's ban status
<hr>

### Precondition
UC1. 3b/c User provides authenticated admin/moderator credentials.

### Main scenario
1. User wants to ban a registered user.
2. System asks for user id.
3. User enters id and enters ban action.
4. System bans the given user and presents feedback.

### Alternate scenario
* 1b. User wants to unban a banned user.
* 2b. System asks for user id.
* 3b. User enters a banned id and enters unban action.
* 4b. System unbans the given user and presents feedback

## UC7 Change a registered user's moderator status
<hr>

### Precondition
UC1. 3b User provides authenticated admin credentials. 

### Main scenario
1. User wants to promote a user to moderator.
2. System asks for user id. 
3. User enters promote action.
4. System changes the user's status to moderator.

### Alternate scenario
* 1b. User wants to demote a moderator.
* 2b. System asks for user id.
* 3b. User enters a moderator id and enters demote action.
* 4b. System demotes the given user and presents feedback

<hr>

## Test cases

### Test case 1.7.1 Successful login with admin credentials

#### Input
 * Enter username "Admin" and password "Password"
 * Press login

 #### Output
 * A table containing registred users should be displayed with a header containing the text "Admin options"
 along with an inputfield with ban/unban/delete/promote/demote options.

<br>

 ### Test case 1.7.2 Successful login with moderator credentials

#### Input
 * Enter username "fakeadmin" and password "password"
 * Press login

 #### Output
 * A table containing registered users should be displayed with a header containing the text "Moderator options"
 along with an inputfield with ban/unban and delete options.

<br>

### Test case 5.1 delete a registered user 

#### Input
 * Test case 1.7.1 / 1.7.2
 * Enter an id from the user table in the input field
 * Press the delete button  

 #### Output
 * An updated table displaying registered users should be presented with the given user deleted.

<br>

### Test case 6.1 ban a registered user 

#### Input
 * Test case 1.7.1 / 1.7.2
 * Enter an id from the user table in the input field
 * Press the ban button  

 #### Output
 * An updated table displaying registered users should be presented with the given user having his role set to "Ban".

 <br>

### Test case 6.1.1 unban a banned user 

#### Input
 * Test case 1.7.1 / 1.7.2
 * Enter an id from the user table in the input field
 * Press the unban button  

 #### Output
 * An updated table displaying registered users should be presented with the given user having his role set to "User".

<br>

### Test case 7.1 promote a user 

#### Input
 * Test case 1.7.1
 * Enter an id from the user table in the input field
 * Press the promote button  

 #### Output
 * An updated table displaying registered users should be presented with the given user having his role set to "Moderator".

 <br>

### Test case 7.1.1 demote a moderator 

#### Input
 * Test case 1.7.1
 * Enter an id from the user table in the input field
 * Press the demote button  

 #### Output
 * An updated table displaying registered users should be presented with the given user having his role set to "User".    

