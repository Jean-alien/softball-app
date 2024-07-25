<?php
// include validate page and start session here...
include 'validate.php';
if (!isset($_SESSION)) {
    session_start();
}
// Make user type password twice (username, password, repeat)
// use validate function (include)
//get all 3 strings from the form (and scrub w/ validation function)
$user = test_input($_POST['user']);
$pwd = test_input($_POST['pwd']);
$pwd_ver = test_input($_POST['repeat']);

if (  
        (strlen($user) < 5) ||
        (strlen($pwd) < 8) ||
        (!preg_match('/[a-z]/', $pwd) || !preg_match('/[A-Z]/', $pwd) || !preg_match('/[^\w]/', $pwd) || !preg_match('/[0-9]/', $pwd)) ||
        ($pwd !== $pwd_ver) // make sure that the two password values match!
) {
    echo '<script>alert("Username and password are not valid. Please check your input.")</script>';
    header("refresh: 3; url=register.php");
} else {
    //echo "Username and password are good to go!" . "<br>";

// Create connection to mariaDB
    $conn = new mysqli("localhost", "root", "", "softball");
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

// if username and pw not exist in DB, insert new username and pw
    if ($result->num_rows > 0) { 
        // output data of each row
        echo "Username or password already exists.";
        header("refresh: 2; url=register.php");
    } else {
        $hpwd = password_hash($pwd, PASSWORD_DEFAULT); //creat the password hash using the PASSWORD_DEFAULT argument
        $sql = "INSERT INTO users (username, password) VALUES('$user', '$hpwd')";
        $_SESSION['username'] = $user; //put the username in the session
    
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Thank you for joining us! You are successfully registered as a new member!")</script>';
            header("refresh: 2; url=index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}
?>
