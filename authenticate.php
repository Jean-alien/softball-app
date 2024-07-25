<?php
// include validate page and start session here...
include 'validate.php';
if (!isset($_SESSION)) {
    session_start();
}
// login to the softball database

$user = test_input($_POST['user']);
$pwd = test_input($_POST['pwd']);

// Create connection to MariaDB
$conn = new mysqli("localhost", "root", "", "softball");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $db_pwd = $row['password'];
    // otherwise, password_verify(password from form, password from db)
    if (password_verify($pwd, $db_pwd)) {
        $_SESSION['username'] =$user;
        header("Location: games.php");
        exit;
    // if good, put username in session, otherwise send back to login
    } else { 
        header("location: index.php");
        exit;
    }
    // if no rows, then username is not valid (but don't tell Mallory) just send
    // her back to the login
} else {
    echo "Invalid username.";
    header("location: index.php");
    exit;
}
$conn->close();
?>
