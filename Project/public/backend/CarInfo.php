<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $rows = functions::prepareQuery($conn, "SELECT offers.*, cars.model, cars.brand, COUNT(case reservations.status when 'waiting' then 1 else null end) AS resNum FROM offers INNER JOIN cars on offers.id_car=cars.id INNER JOIN reservations ON reservations.id_offer=offers.id WHERE offers.id=$id ");

    $data = functions::prepareQuery($conn, "SELECT * FROM reservations WHERE id_offer=$id");
    $status = 'clear';
    $myStatus = 'clear';
    $available = true;
    $uInQueue = false;

    isset($_SESSION['logged']) && $_SESSION['logged'] == true ? $logged = true : $logged = false;

    foreach ($data as $row) {
        if ($row['status'] == "waiting") {
            if ($status == 'clear') {
                $status = 'waiting';
            }
            if ($myStatus != 'accepted' && isset($_SESSION['id']) && intval($row['id_user']) == intval($_SESSION['id'])) {
                $myStatus = 'waiting';
            }
        }
        if ($row['status'] == "accepted") {
            $status = 'accepted';
            if (isset($_SESSION['id']) && intval($row['id_user']) == intval($_SESSION['id'])) {
                $myStatus = 'accepted';
            }
        }
        if ($row['status'] == "declined") {
            if ($status != 'accepted') {
                $status = 'declined';
            }
            if ($myStatus == 'clear' && isset($_SESSION['id']) && intval($row['id_user']) == intval($_SESSION['id'])) {
                $myStatus = 'declined';
            }
        }
        if (isset($_SESSION['id'])) {
            if ($row['id_user'] == $_SESSION['id']) {
                $uInQueue = true;
            }
        }
    }



    if (($uInQueue == false && $status == 'accepted') || ($status == 'accepted' && $uInQueue == true && $myStatus == 'declined')) {
        $available = false;
    }

    echo json_encode(['data' => $rows[0], 'status' => $status, 'logged' => $logged, 'inQueue' => $uInQueue, 'available' => $available, 'myStatus' => $myStatus]);
} else {
    echo json_encode(['status' => false]);
}
