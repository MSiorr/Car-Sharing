<?php

session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'changeSchedulder': {
                $newStatus = functions::prepareQuery($conn, "SHOW GLOBAL VARIABLES LIKE 'event_scheduler'")[0]['Value'] == 'OFF' ? 'ON' : 'OFF';

                mysqli_query($conn, "SET GLOBAL event_scheduler='$newStatus'");

                echo json_encode(['action' => true]);
                break;
            }
        default: {
                echo json_encode(['action' => false]);
            }
    }
} else {
    $status = functions::prepareQuery($conn, "SHOW GLOBAL VARIABLES LIKE 'event_scheduler'");
    echo json_encode(['status' => $status[0]['Value']]);
}
