<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_SESSION['logged'], $_POST['id']) && $_SESSION['logged'] == true) {

    $id = $_POST['id'];

    $data = functions::prepareQuery($conn, "SELECT reservations.resStart, reservations.resTime, users.id AS userID, rentals.* FROM rentals INNER JOIN reservations ON rentals.id_reservation=reservations.id INNER JOIN users ON reservations.id_user=users.id WHERE rentals.id=$id");

    if (isset($_SESSION['id']) && $data[0]['userID'] == $_SESSION['id']) {
        echo json_encode(['access' => true, 'before' => false, 'data' => $data[0]]);
    } else {
        echo json_encode(['access' => false]);
    }
} else {
    echo json_encode(['access' => false]);
}
