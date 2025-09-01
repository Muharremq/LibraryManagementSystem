<?php

$server = "localhost";
$username = "root";
$password = "";
$dbnmae = "librarydb";


$conn = new mysqli($server, $username, $password, $dbnmae);

if(!$conn){
    echo "Database is not connected: {$conn -> connect_error}";
}