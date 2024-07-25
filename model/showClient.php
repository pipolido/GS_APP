<?php
include 'data.php';

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
