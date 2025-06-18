<?php
include './database.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['userpassword'];

    // Sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Check if user already exists using prepared statement
    $stmt = $connection->prepare("SELECT * FROM Users WHERE user_name = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $resultUsers = $stmt->get_result();

    if ($resultUsers->num_rows > 0) {
        echo "<script>alert('Username or email already exists. Try logging in!');</script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user using prepared statement
        $stmtInsert = $connection->prepare("INSERT INTO `Users` (user_name, pswd, email) VALUES (?, ?, ?)");
        $stmtInsert->bind_param("sss", $username, $hashedPassword, $email);


        if ($stmtInsert->execute()) {
            $_SESSION['loggedin'] = true;
            header('Location: index.php');
            $_SESSION['username'] = $_POST['username'];
            echo "<script>alert('Signup successful! You can now log in.');</script>";
        } else {
            echo "<script>alert('Signup failed. Please try again later.');</script>";
        }

        $stmtInsert->close();
    }

    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="formContainer">

        <h2>Sign Up</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="User Name">
            <input type="password" name="userpassword" placeholder="Password">
            <input type="email" name="email" placeholder="Email">
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <p>Already have an account ? <a href="login.php">Log In</a></p>

    </div>

</body>

</html>