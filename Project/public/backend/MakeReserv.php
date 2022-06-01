<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();
if (isset($_SESSION['logged']) == false) {
    echo json_encode(['status' => false, 'info' => 'Yo must be logged in']);
} else {
    if (isset($_POST['offerID'], $_POST['endPrice'], $_POST['resStart'], $_POST['resTime'], $_SESSION['id'])) {
        $offerID = intval($_POST['offerID']);
        $endPrice = intval($_POST['endPrice']);
        $resStart = $_POST['resStart'];
        $resTime = intval($_POST['resTime']);
        $userID = intval($_SESSION['id']);

        $userData = functions::prepareQuery($conn, "SELECT users.banned FROM users WHERE id=$userID");
        if ($userData[0]['banned'] == 0) {
            $stmt = mysqli_prepare($conn, "INSERT INTO reservations(id_user, id_offer, endPrice, resStart, resTime) VALUES (?,?,?,?,?)");
            mysqli_stmt_bind_param($stmt, "iiisi", $userID, $offerID, $endPrice, $resStart, $resTime);
            mysqli_stmt_execute($stmt);

            echo json_encode(['status' => true, 'info' => 'Added to queue']);
        } else {
            echo json_encode(['status' => false, 'info' => 'You are banned']);
        }
    } else {
        echo json_encode(['status' => false, 'info' => 'Some data is wrong']);
    }
}
