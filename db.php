<?php 

$host = "localhost";
$username = "root";
$password = "";
$database = "easybank_db";

$conn = new mysqli($host, $username, $password, $database);

if($conn->connect_error){
    die("Coonection failed: " . $conn->connect_error);
}
