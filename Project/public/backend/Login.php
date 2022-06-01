<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();


if (isset($_POST['login'], $_POST['password'])) {
    $login = $_POST['login'];
    $pass = md5($_POST['password']);

    $rows = functions::prepareProtectedQuery($conn, "SELECT * FROM users WHERE login=?", "s", $login);

    if (count($rows) > 0) {
        if ($rows[0]['password'] == $pass) {
            if ($rows[0]['active'] == false) {
                echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Your account is inactive ']);
            } else {
                $_SESSION['logged'] = true;
                $_SESSION['login'] = $rows[0]['login'];
                $_SESSION['id'] = $rows[0]['id'];
                $_SESSION['permiss'] = $rows[0]['permiss'];

                echo json_encode(['locReload' => false, 'opperation' => true, 'info' => 'Succesfully Logged']);
            }
        } else {
            echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Wrong password or login']);
        }
    } else {
        echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Wrong password or login']);
    }
} else {
    echo json_encode(['locReload' => false, 'opperation' => false, 'info' => 'Wrong data']);
}
