<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form action="new_user.php" method="POST">
            Username: <input type="text" name="user">
            * between 5-15 characters<br>
            Password: <input type="password" name="pwd"> 
            * include a minimum of 8 characters and
            at least 1 number and special character
            (@#$%^&*()-_+={}[]|\;:"<>,./?)<br>
            Repeat: <input type="password" name="repeat"><br>
            <input type="submit">
        </form>
    </body>
</html>
