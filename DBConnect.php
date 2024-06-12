<?php
$server = 'localhost:3308';
$user = 'root';
$pass = '';
$DB = 'hotel';

$conn = mysqli_connect($server, $user, $pass, $DB);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
