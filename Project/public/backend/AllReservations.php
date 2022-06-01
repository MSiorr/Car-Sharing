<?php

session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case "changeStatus": {
                if (isset($_POST['id'], $_POST['status'])) {
                    $id = intval($_POST['id']);
                    $status = $_POST['status'] == 'yes' ? 'accepted' : 'declined';

                    if ($status == 'accepted') {
                        functions::createRental($conn, $id);
                        declineSameOffers($id);
                    }

                    functions::prepareStmt($conn, "UPDATE reservations SET status=? WHERE id=?", "si", $status, $id);

                    echo json_encode(['action' => true, 'info' => "Reservation $status"]);
                } else {
                    echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
                }
                break;
            }
        case "deleteReserv": {
                if (isset($_POST['id'], $_POST['rentID'])) {
                    $id = intval($_POST['id']);
                    $rentID = $_POST['rentID'] == "null" ? "null" : intval($_POST['rentID']);

                    if ($rentID != "null") {
                        functions::removeRental($conn, $rentID);
                    }

                    functions::prepareStmt($conn, "DELETE FROM reservations WHERE id=?", "i", $id);

                    echo json_encode(['action' => true, 'info' => "Reservation deleted"]);
                } else {
                    echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
                }
                break;
            }
        case "updateReserv": {
                if (isset($_POST['id'], $_POST['resStart'], $_POST['resTime'])) {
                    $id = intval($_POST['id']);
                    $resStart = $_POST['resStart'];
                    $resTime = intval($_POST['resTime']);

                    $res = getReservations($id);
                    if (count($res) > 0) {
                        $newPrice = max(0, $resTime * intval($res[0]['price']));

                        functions::updateRental($conn, intval($res[0]['rentID']), $resTime, intval($res[0]['resTime']));

                        functions::prepareStmt($conn, "UPDATE reservations SET resStart=?, resTime=?, endPrice=? WHERE id=?", "siii", $resStart, $resTime, $newPrice, $id);

                        echo json_encode(['action' => true, 'info' => "Reservation updated"]);
                    } else {
                        echo json_encode(['action' => false, 'info' => 'Some data is wrong']);
                    }
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

    $rows = getReservations();
    $arch = getArchivalReservations();
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

    echo json_encode(['action' => false, 'accepted' => $acceptedTab, 'declined' => $declinedTab, 'waiting' => $waitingTab, 'archival' => $arch]);
}


function getReservations($id = null)
{
    global $conn;

    if ($id == null) {
        $rows = functions::prepareQuery($conn, "SELECT reservations.*, users.login, offers.id AS offerID, CONCAT(cars.model, ' ', cars.brand) AS carName, rentals.id AS rentID FROM reservations INNER JOIN offers ON reservations.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id INNER JOIN users ON reservations.id_user=users.id LEFT JOIN rentals ON reservations.id=rentals.id_reservation");
    } else {
        $rows = functions::prepareQuery($conn, "SELECT reservations.*, offers.price, offers.id AS offerID, rentals.id AS rentID, rentals.daysLeft FROM reservations INNER JOIN offers ON reservations.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id LEFT JOIN rentals ON reservations.id=rentals.id_reservation WHERE reservations.id=$id");
    }
    return $rows;
}

function getArchivalReservations()
{
    global $conn;

    $rows = functions::prepareQuery($conn, "SELECT reservations_arch.*, users.login, CONCAT(cars.model, ' ', cars.brand) AS carName FROM reservations_arch LEFT JOIN offers ON reservations_arch.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id LEFT JOIN users ON reservations_arch.id_user=users.id");
    return $rows;
}

function declineSameOffers($resID)
{
    global $conn;

    functions::prepareStmt($conn, "UPDATE reservations SET status='declined' WHERE id_offer=(SELECT id_offer FROM reservations WHERE id=?) AND status='waiting'", "i", $resID);
}
