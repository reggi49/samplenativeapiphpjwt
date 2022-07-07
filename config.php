<?php
$url = 'https://www.mbtech.info/e-catalog/';
$urlm = 'https://www.mbtech.info/e-catalog/msite/';
$title = 'MBtech Color Sample Giorgio';
$description = 'Create your personal experience colour with e-catalog giorgio application';

// koneksi mysql ke php
$servername = "localhost";
$username = "username";
$password = "password";
$database = "dynamo";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>