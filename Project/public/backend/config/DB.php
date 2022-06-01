<?php
$servename = "localhost";
$username = "root";
$password = "";
$db = "wypozyczalnia";

function connectToDB()
{
    global $servename;
    global $username;
    global $password;
    global $db;

    $conn = mysqli_connect($servename, $username, $password, $db);
    mysqli_set_charset($conn, 'utf8');

    return $conn;
}
