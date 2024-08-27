<?php
include 'data.php';

function ShowProduct($id = null)
{
    $conn = $GLOBALS['conn'];
    if (!empty($id)) {
        $sql = "SELECT * FROM `product` WHERE `ID_Product` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Fetch associative array
    } else {
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch associative array
    }
}
function ShowClient($id = null)
{
    $conn = $GLOBALS['conn'];
    if (!empty($id)) {
        $sql = "SELECT * FROM `Client` WHERE `ID_Client` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Fetch associative array
    } else {
        $sql = "SELECT * FROM Client";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch associative array
    }
}
?>
