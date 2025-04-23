<?php
$host = 'localhost';
$dbname = 'dbyr8rdomnxjqp';
$username = 'u8gr0sjr9p4p4';
$password = '9yxuqyo3mt85';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
