<?php
// session_start();
// include 'data.php';
include 'Functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if (!empty($_POST['ProductName']) && !empty($_POST['Price']) && !empty($_POST['Quantity'])) {
            $sql = "INSERT INTO product (name, Price, Quantity) VALUES (?, ?, ?)";

            if ($req = $conn->prepare($sql)) {
                $req->bind_param("sdi", $_POST['ProductName'], $_POST['Price'], $_POST['Quantity']);

                if ($req->execute()) {
                    $_SESSION['message'] = ['text' => 'Product added successfully', 'type' => 'success'];
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

    
}
?>
