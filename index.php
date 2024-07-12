<!DOCTYPE html>
<?php
session_start();
include("api/000c000o000nn000ec00to000r.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getHWID() {
    return isset($_SESSION['user_hwid']) ? $_SESSION['user_hwid'] : uniqid();
}

function isBlacklisted($hwid, $conn) {
    $hwid = mysqli_real_escape_string($conn, $hwid);

    $blacklist_sql = "SELECT * FROM hwid_blacklist WHERE hwid = '$hwid'";
    $blacklist_result = mysqli_query($conn, $blacklist_sql);

    return mysqli_num_rows($blacklist_result) > 0;
}

$user_hwid = getHWID();
$_SESSION['user_hwid'] = $user_hwid;

if (isBlacklisted($user_hwid, $conn)) {
    echo "HWID BANNED LOLOL, TRY TO APPEAL YOU'LL GET INSTA BANNED LOLOL SHAME ON YOU BRO";
    exit;
}


// Fetch the user's IP address from the external API (ipify)
$ipify_api_url = 'https://api.ipify.org?format=json';
$response = file_get_contents($ipify_api_url);

if ($response !== false) {
    $ip_data = json_decode($response, true);

    // Log the user's IP address
    $user_ip = $ip_data['ip'];
    $log_sql = "INSERT INTO ip_logs (ip_address) VALUES ('$user_ip')";
    mysqli_query($conn, $log_sql);

    // Check if the user's IP is blacklisted
    $blacklist_sql = "SELECT * FROM blacklist WHERE ip_address = '$user_ip'";
    $blacklist_result = mysqli_query($conn, $blacklist_sql);

    if (mysqli_num_rows($blacklist_result) > 0) {
        // IP is blacklisted, you can take appropriate actions here
        echo "Access denied. Your IP has been blacklisted.";
        exit;
    }
} else {
    // Unable to fetch IP from the API, handle error as needed
    echo "Error fetching IP from the API.";
    exit;
}

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = htmlspecialchars($_SESSION['username']);
} else {
    $username = ''; // Set to an empty string if the user is not logged in
}

mysqli_close($conn);
?>


<html><head>
    <title>XSPY|OFFLINE</title>
    <link rel="stylesheet" href="http://web.archive.org/web/20160929023839cs_/https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/css/materialize.min.css">
    <link href="http://web.archive.org/web/20160929023839cs_/https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>html,body{background:#F0F0F0;height:100%;width:100%;}</style>
    </head>
    <body>
    
    <div class="container center-align" style="position:relative;top:40%;transform:translateY(-40%);">
    <img src="http://i.imgur.com/VRiFLca.png" class="responsive-img">
    <div style="font-size:45px;font-weight:300;">the site is currently offline</div>
    <div style="font-size:20px;">we're updating and making the site better! Try again later!</div>
    </div>
        <script src="https://publisher.linkvertise.com/cdn/linkvertise.js"></script><script>linkvertise(909592, {whitelist: ["xspy.lol"], blacklist: []});</script>
    <div class="hiddendiv common"></div></body></html>
    