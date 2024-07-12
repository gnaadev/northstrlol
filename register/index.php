<?php
session_start();

// Rate limit settings
$maxAttempts = 5;
$timeWindow = 600; // in seconds

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user has exceeded the maximum number of registration attempts
    if (!isset($_SESSION['registration_attempts'])) {
        $_SESSION['registration_attempts'] = 1;
    } else {
        $_SESSION['registration_attempts']++;

        if ($_SESSION['registration_attempts'] > $maxAttempts) {
            $remainingTime = $timeWindow - (time() - $_SESSION['registration_time']);

            if ($remainingTime > 0) {
                echo "Too many registration attempts. Please try again after $remainingTime seconds.";
                exit;
            } else {
                // Reset the attempt count if the time window has passed
                $_SESSION['registration_attempts'] = 1;
            }
        }
    }

    include("../api/000c000o000nn000ec00to000r.php");
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = md5($password);

    $sql = "INSERT INTO user_info (username, password) VALUES ('$username', '$hashed_password')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "Registration successful. <a href='login.php'>Login here</a>";
        // Reset the attempt count on successful registration
        $_SESSION['registration_attempts'] = 1;
    } else {
        echo "Error: " . mysqli_error($conn);
        // Store the current time for rate limiting
        $_SESSION['registration_time'] = time();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="index.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Sign Up">
    </form>
</body>
</html>
