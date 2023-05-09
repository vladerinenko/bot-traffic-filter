<?php
$env = parse_ini_file('.env');

$db_host = $env["DB_HOST"];
$username = $env["DB_USERNAME"];
$password = $env["DB_PASSWORD"];
$dbname = $env["DB_NAME"];

$db = new mysqli($db_host, $username, $password, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
