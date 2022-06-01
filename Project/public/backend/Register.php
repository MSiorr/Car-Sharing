<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();


if (isset($_POST['login'], $_POST['password'], $_POST['email'])) {
    $login = $_POST['login'];
    $pass = md5($_POST['password']);
    $email = $_POST['email'];

    $rows = functions::prepareProtectedQuery($conn, "SELECT * FROM users WHERE login=? OR email=? ", "ss", $login, $email);

    if (count($rows) > 0) {
        echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Login or email are busy']);
    } else {

        functions::prepareStmt($conn, "INSERT INTO users(login, password, email) VALUES (?,?,?)", "sss", $login, $pass, $email);

        echo json_encode(['status' => true, 'opperation' => true, 'info' => 'Successfully registered']);
    }
} else {
    echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Wrong data']);
}
