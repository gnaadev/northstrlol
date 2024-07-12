<?php
session_start();

// Set the maximum number of attempts and the time window (in seconds)
$maxAttempts = 3;
$timeWindow = 60;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user has exceeded the maximum number of attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 1;
    } else {
        $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] > $maxAttempts) {
            $remainingTime = $timeWindow - (time() - $_SESSION['login_time']);

            if ($remainingTime > 0) {
                echo "Too many login attempts. Please try again after $remainingTime seconds.";
                exit;
            } else {
                // Reset the attempt count if the time window has passed
                $_SESSION['login_attempts'] = 1;
            }
        }
    }

    // Include database connection
    include("../api/000c000o000nn000ec00to000r.php");
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = md5($password);
    $sql = "SELECT * FROM user_info WHERE username='$username' AND password='$hashed_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Store the username in the session
        $_SESSION['username'] = $username;

        // Reset the attempt count on successful login
        $_SESSION['login_attempts'] = 1;
    } else {
        echo "Login failed. Invalid username or password.";
        $_SESSION['login_time'] = time();
    }

    mysqli_close($conn);
}

// Redirect to the main site if the user is logged in
if (isset($_SESSION['username'])) {
    header("Location: https://www.xspy.lol/?user=" . urlencode($_SESSION['username']));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="index.php" method="post">
        <label for="username">Your username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
