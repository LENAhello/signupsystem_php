<?php

use Dom\Text;
include './database.php';
session_start();

// Handle logout before anything else
if (isset($_POST["logout"])) {
    $_SESSION['loggedin'] = false;
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

// Redirect to login page if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up system</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Welcome, <?= $_SESSION['username'] ?> </h1>
    <h2>Today's Quote</h2>
    <?php
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://zenquotes.io/api/random");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if ($data) {
        echo "<p><em>{$data[0]['q']}</em></p>";
    } else {
        echo "<p>Could not fetch Kanye quote.</p>";
    }
    ?>

    <form method="POST">
        <input type="submit" class="logoutBtn" name="logout" value="Log Out">
    </form>
</body>

</html>