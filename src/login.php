<?php
require './database.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

if (isset($_POST["login"])) {

    // Prepare a SQL statement to securely query the database for the user details
    if ($stmt = $connection->prepare('SELECT pswd, user_name FROM Users WHERE user_name = ?')) {

        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        // Check if a user with the given username exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($pswd, $username);
            $stmt->fetch();

            // Compare plain-text password directly (INSECURE)
            $isValid = password_verify($_POST['userpassword'], $pswd);
            if (!$isValid) {
                echo "<script>alert('Invalid username or password, please try again!');</script>";
            } else {
                // Start session if not already started
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $_POST['username'];

                header('location: index.php');
                exit;
            }
        } else {
            echo "<script>alert('Invalid username or password, please try again!');</script>";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>

    <div class="formContainer">

        <h2>Log In</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="User Name">
            <input type="password" name="userpassword" placeholder="Password" id="password">
            <div>
                <input type="checkbox" id="togglePassword">
                <p>Show Password</p>
            </div>
            <button type="submit" name="login">Log In</button>
        </form>
        <p>Don't have an account yet ? <a href="signup.php">Sign Up</a></p>

    </div>


    <script src="script.js"></script>
</body>

</html>