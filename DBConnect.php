<?php
// port number can be changed according to different server machine
$server = 'localhost:3306';
$user = 'root';
$pass = '';
$DB = 'hotel';

$conn = mysqli_connect($server, $user, $pass, $DB);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
