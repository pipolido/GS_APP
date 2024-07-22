<?php
// session_start();
include 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    if (
        !empty($_POST['ProductName']) &&
        !empty($_POST['Price']) &&
        !empty($_POST['Quantity'])
    ) {
        $sql = "INSERT INTO product (name, Price, Quantity) VALUES (?, ?, ?)";

        if ($req = $conn->prepare($sql)) {
            $req->bind_param("sdi", $_POST['ProductName'], $_POST['Price'], $_POST['Quantity']);

            if ($req->execute()) {
                if ($req->affected_rows > 0) {
                    $_SESSION['message'] = ['text' => 'Product added successfully', 'type' => 'success'];
                } else {
                    $_SESSION['message'] = ['text' => 'Unexpected error: No rows affected.', 'type' => 'error'];
                }
            } else {
                $_SESSION['message'] = ['text' => 'Database error: ' . $req->error, 'type' => 'error'];
            }

            $req->close();
        } else {
            $_SESSION['message'] = ['text' => 'Database error: ' . $conn->error, 'type' => 'error'];
        }
    } else {
        $_SESSION['message'] = ['text' => 'Information missing', 'type' => 'error'];
    }

    
    header('Location: ../view/AddProduct.php');
    exit;
}


function ShowArtical()
{
    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM product";
    $req = $conn->prepare($sql);
    $req->execute();
    $result = $req->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
    return $rows;
}



?>