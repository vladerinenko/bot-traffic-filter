<?php
$servername = "127.0.0.1:3306";
$username = "root";
$password = "root";
$dbname = "traffic";

$db = new mysqli($servername, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
