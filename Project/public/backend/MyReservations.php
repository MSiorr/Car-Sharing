<?php

session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "cancelReserv": {
                if (isset($_POST['id'])) {
                    $id = intval($_POST['id']);

                    functions::prepareStmt($conn, "DELETE FROM reservations WHERE id=?", "i", $id);

                    echo json_encode(['action' => true, 'info' => "Reservation canceled"]);
                } else {
                    echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
                }
                break;
            }
        case "returnCar": {
                if (isset($_POST['id'], $_POST['rentID'])) {
                    $id = intval($_POST['id']);
                    $rentID = $_POST['rentID'] == "null" ? "null" : intval($_POST['rentID']);

                    if ($rentID != "null") {
                        functions::removeRental($conn, $rentID);
                    }

                    functions::prepareStmt($conn, "DELETE FROM reservations WHERE id=?", "i", $id);

                    echo json_encode(['action' => true, 'info' => "Car returned"]);
                } else {
                    echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
                }
                break;
            }
        default: {
                echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
            }
    }
} else {

    if (isset($_SESSION['id'])) {
        $userID = intval($_SESSION['id']);
        $rows = getReservations($userID);
        $waitingTab = $acceptedTab = $declinedTab = [];
        foreach ($rows as $row) {
            if ($row['status'] == 'waiting') {
                array_push($waitingTab, $row);
            } else if ($row['status'] == 'accepted') {
                array_push($acceptedTab, $row);
            } else {
                array_push($declinedTab, $row);
            }
        }

        echo json_encode(['action' => false, 'status' => true, 'accepted' => $acceptedTab, 'declined' => $declinedTab, 'waiting' => $waitingTab]);
    } else {
        echo json_encode(['action' => false, 'status' => false]);
    }
}

function getReservations($id = null)
{
    global $conn;

    if ($id == null) {
        $rows = functions::prepareQuery($conn, "SELECT reservations.*, cars.model, cars.brand, users.login FROM reservations INNER JOIN offers ON reservations.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id");
    } else {
        $rows = functions::prepareQuery($conn, "SELECT reservations.*, cars.model, offers.id AS offerID, cars.brand, rentals.id AS rentID FROM reservations INNER JOIN offers ON reservations.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id LEFT JOIN rentals ON reservations.id=rentals.id_reservation WHERE id_user=$id");
    }
    return $rows;
}
