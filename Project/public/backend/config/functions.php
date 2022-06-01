<?php
class functions
{
    public static function prepareQuery($conn, $query)
    {
        $res = null;
        $rows = null;

        $res = mysqli_query($conn, $query);
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

        return $rows;
    }

    public static function prepareProtectedQuery($conn, $query, $dataType, ...$args)
    {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, $dataType, ...$args);
        mysqli_stmt_execute($stmt);

        $res = $stmt->get_result();
        $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

        return $rows;
    }

    public static function prepareStmt($conn, $query, $dataType, ...$args)
    {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, $dataType, ...$args);
        mysqli_stmt_execute($stmt);
    }

    public static function createRental($conn, $id)
    {
        $resData = functions::prepareQuery($conn, "SELECT reservations.resTime, cars.model, cars.brand FROM reservations INNER JOIN offers ON reservations.id_offer=offers.id INNER JOIN cars ON offers.id_car=cars.id WHERE reservations.id=$id");
        $carModel = $resData[0]['model'];
        $carBrand = $resData[0]['brand'];
        $resTime = $resData[0]['resTime'];
        $qrTarget = "https://www.google.pl/search?q=$carModel+$carBrand";

        functions::prepareStmt($conn, "INSERT INTO rentals(id_reservation, qrCode, daysLeft) VALUES (?,?,?)", "isi", $id, $qrTarget, $resTime);
    }

    public static function updateRental($conn, $id, $newResTime, $oldResTime)
    {
        $diff = $newResTime - $oldResTime;
        functions::prepareStmt($conn, "UPDATE rentals SET daysLeft=daysLeft + ? WHERE id=?", "ii", $diff, $id);
    }

    public static function removeRental($conn, $id)
    {
        functions::prepareStmt($conn, "DELETE FROM rentals WHERE id=?", "i", $id);
    }
}
