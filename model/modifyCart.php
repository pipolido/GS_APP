<?php

include 'data.php';
include 'Functions.php';

// Ensure database connection
$conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (
        !empty($_POST['Proname']) &&
        !empty($_POST['ClientName']) &&
        !empty($_POST['Quantity']) &&
        !empty($_POST['id'])
    ) {
        $orderId = $_POST['id'];
        $productId = $_POST['Proname'];
        $clientId = $_POST['ClientName'];
        $newQuantity = (int)$_POST['Quantity'];

        // Fetch the current order details
        $sql = "SELECT Quantity FROM commande WHERE Num_Comande = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentOrder = $result->fetch_assoc();
        $currentQuantity = $currentOrder['Quantity'];

        // Fetch the product details
        $sql = "SELECT Quantity, Price FROM product WHERE ID_Product = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $currentStock = $product['Quantity'];
        $productPrice = $product['Price'];

        // Calculate the new stock quantity and total price
        $stockAfterUpdate = $currentStock + $currentQuantity - $newQuantity;
        $totalPrice = $newQuantity * $productPrice;

        if ($stockAfterUpdate < 0) {
            $_SESSION['message'] = ['text' => 'The requested quantity exceeds the available stock.', 'type' => 'danger'];
        } else {
            // Update the order
            $sql = "UPDATE commande SET ID_Product = ?, ID_Client = ?, Quantity = ?, TotalPrice = ? WHERE Num_Comande = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iiiid', $productId, $clientId, $newQuantity, $totalPrice, $orderId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Update the product stock
                $sql = "UPDATE product SET Quantity = ? WHERE ID_Product = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $stockAfterUpdate, $productId);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $_SESSION['message'] = ['text' => 'Order updated successfully.', 'type' => 'success'];
                } else {
                    $_SESSION['message'] = ['text' => 'Failed to update product stock.', 'type' => 'danger'];
                }
            } else {
                $_SESSION['message'] = ['text' => 'Failed to update the order.', 'type' => 'danger'];
            }
        }
    } else {
        $_SESSION['message'] = ['text' => 'Information missing.', 'type' => 'danger'];
    }

    header('Location: ../view/AddCart.php');
    exit();
}
