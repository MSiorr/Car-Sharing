<?php
session_start();
include_once("./config/DB.php");
$conn = connectToDB();

if (isset($_SESSION['logged']) == false || $_SESSION['logged'] == false) {
    echo json_encode(["logged" => false]);
} else {
    echo json_encode(["logged" => true, "permiss" => $_SESSION['permiss'], 'login' => $_SESSION['login']]);
}
