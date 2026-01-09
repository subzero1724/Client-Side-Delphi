<?php
$conn = new mysqli("localhost", "root", "", "akademik");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
