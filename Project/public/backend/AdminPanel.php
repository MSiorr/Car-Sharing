<?php

session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {

        case 'modChange': {
                if (isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $rows = functions::prepareQuery($conn, "SELECT * FROM users WHERE id=$id");
                    // $rows = getUsers($conn, $id);

                    if (count($rows) > 0) {
                        $newMod = $rows[0]['permiss'] == 'mod' ? 'client' : 'mod';

                        $up = functions::prepareStmt($conn, "UPDATE users SET permiss=? WHERE id=? AND permiss!='admin'", "si", $newMod, $id);
                        // $up = prepareUpdate("UPDATE users SET permiss=? WHERE id=?", "si", $newMod, $id);

                        echo json_encode(['action' => $up]);
                    } else {
                        echo json_encode(['action' => false]);
                    }
                } else {

                    echo json_encode(['action' => false]);
                }
                break;
            }

        case 'activeChange': {
                if (isset($_POST['id'])) {

                    $id = $_POST['id'];
                    $rows = functions::prepareQuery($conn, "SELECT * FROM users WHERE id=$id");
                    // $rows = getUsers($conn, $id);
                    if (count($rows) > 0) {
                        $newActive = $rows[0]['active'] == 0 ? 1 : 0;

                        $up = functions::prepareStmt($conn, "UPDATE users SET active=? WHERE id=? AND permiss!='admin'", "ii", $newActive, $id);
                        // $up = prepareUpdate("UPDATE users SET active=? WHERE id=?", "ii", $newActive, $id);

                        echo json_encode(['action' => $up]);
                    } else {
                        echo json_encode(['action' => false]);
                    }
                } else {

                    echo json_encode(['action' => false]);
                }
                break;
            }

        case 'banChange': {
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $rows = functions::prepareQuery($conn, "SELECT * FROM users WHERE id=$id");
                    if (count($rows) > 0) {
                        $newBanStatus = $rows[0]['banned'] == 0 ? 1 : 0;

                        $up = functions::prepareStmt($conn, "UPDATE users SET banned=? WHERE id=? AND permiss!='admin'", "ii", $newBanStatus, $id);

                        echo json_encode(['action' => $up]);
                    } else {
                        echo json_encode(['action' => false]);
                    }
                } else {
                    echo json_encode(['action' => false]);
                }
                break;
            }

        default: {
                echo json_encode(['action' => false]);
            }
    }
} else {

    $rows = functions::prepareQuery($conn, "SELECT id, login, email, permiss, active, createTime, banned FROM users");

    echo json_encode(['action' => false, 'users' => $rows]);
}
