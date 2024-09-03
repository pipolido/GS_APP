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
        return $result->fetch_assoc(); 
    } else {
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); 
    }
}
function ShowClient($id = null)
{
    $conn = $GLOBALS['conn'];
    if (!empty($id)) {
        $sql = "SELECT * FROM `client` WHERE `ID_Client` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    } else {
        $sql = "SELECT * FROM client";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); 
    }
}
function ShowCart($id = null)
{
    $conn = $GLOBALS['conn'];

    if (!empty($id)) {
        // Fetch a specific order based on Num_Commande
        $sql = "SELECT * FROM `commande` WHERE `Num_Comande` = ?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);  // Assuming Num_Commande is an integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Fetch single result as associative array
    } else {
        // Fetch all orders
        $sql = "SELECT * FROM `commande`";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch all results as an associative array
    }
}

?>
