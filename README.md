# Login_1DV610
Repository for 1DV610 l3

This login module provides extra admin functionality for handling registred users.


# UC1 Authenticate user(added alternate scenarios)

<hr>

## Main scenario

1. Starts when a user wants to authenticate.
2. System asks for username, password, and if system should save the user credentials
3. User provides username and password
4. System authenticates the user and presents that authentication succeeded


# Alternate scenarios
* 3b. User provides admin credentials.
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. The system authenticates the user and presents extra admin options.
    <br>
* 3c. User provides moderator credentials.
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. The system authenticates the user and presents extra moderator options
    <br>
* 4b. User provides banned user credentials.
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. The system presents a ban error message

#UC5 Delete a registered user
<hr>

## Precondition
UC1. 3b/c User provides authenticated admin/moderator credentials.

## Main scenario
1. User wants to delete a registred user.
2. System asks for user id.
3. User enters id and enters delete action.
4. System deletes the given user and presents feedback.

#UC6 Change a registred users ban status
<hr>

## Precondition
UC1. 3b/c User provides authenticated admin/moderator credentials.

## Main scenario
1. User wants to ban a registred user.
2. System asks for user id.
3. User enters id and enters ban action.
4. System bans the given user and presents feedback.

## Alternate scenario
* 1b. User wants to unban a banned user.
* 2b. System asks for user id.
* 3b. User enters a banned id and enters unban action.
* 4b. System unbans the given user and presents feedback

#UC7 Change a registred users moderator status
<hr>

## Precondition
UC1. 3b User provides authenticated admin credentials. 

## Main scenario
1. User wants to promote a user to moderator.
2. System asks for user id. 
3. User enters promote action.
4. System changes the users status to moderator.

## Alternate scenario
* 1b. User wants to demote a moderator.
* 2b. System asks for user id.
* 3b. User enters a moderator id and enters demote action.
* 4b. System demotes the given user and presents feedback

<hr>

# Test cases

### Test case 1.7.1 Successful login with admin credentials

#### Input
 * Enter username "Admin" and password "Password"
 * Press login

 #### Output
 * A table containing registred users should be displayed with a header containing the text "Admin options"
 along with an inputfield with ban/delete/promote/demote options.

<br>

 ### Test case 1.7.2 Successful login with moderator credentials

#### Input
 * Enter username "fakeadmin" and password "password"
 * Press login

 #### Output
 * A table containing registred users should be displayed with a header containing the text "Moderator options"
 along with an inputfield with ban/unban and delete options.

<br>

### Test case 5.1 delete a registered user 

#### Input
 * Test case 1.7.1
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

