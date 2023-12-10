<?php
$host = '//';
$username = '//_username';
$password = '//_password';
$database = '//name';

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
