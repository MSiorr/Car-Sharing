<?php
session_start();
include_once("./config/DB.php");
include_once("./config/functions.php");
$conn = connectToDB();

$rows = functions::prepareQuery($conn, "SELECT offers.id AS offerID, cars.model, cars.brand, offers.year, offers.price, offers.img FROM offers INNER JOIN cars ON offers.id_car=cars.id");

echo json_encode(["cars" => $rows]);
