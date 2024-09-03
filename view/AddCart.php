<?php
include '../model/Functions.php'; // Include functions to interact with the database

$product = [];
if (!empty($_GET['id'])) {
    $product = ShowCart($_GET['id']); // Retrieve cart details for modification
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($_GET['id']) ? 'Modify Command' : 'Add Command'; ?></title>
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 15px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Table Styling */
        .protab {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
        }

        .protab th,
        .protab td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }

        .protab th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .protab tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .protab tr:hover {
            background-color: #f1f1f1;
        }

        .protab td {
            color: #333;
        }

        /* Form Styling */
        form {
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 4px;
            color: #333;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Error/success messages */
        .alert {
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 5px;
            color: #fff;
        }

        .alert.success {
            background-color: #4CAF50;
        }

        .alert.danger {
            background-color: #f44336;
        }

        /* Adjustments for smaller screens */
        @media (max-width: 768px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="post" action="<?= !empty($_GET['id']) ? "../model/modifyCart.php" : "../model/addCart.php" ?>">
            <div class="form-group">
                <label for="Proname">Product Name</label>
                <select name="Proname" id="Proname" onchange="SetPrice()">
                    <?php
                    $products = ShowProduct();
                    if (!empty($products) && is_array($products)) {
                        foreach ($products as $value) {
                            ?>
                            <option data-price="<?= htmlspecialchars($value['Price']); ?>" value="<?= htmlspecialchars($value['ID_Product']); ?>" <?= !empty($product['ID_Product']) && $product['ID_Product'] == $value['ID_Product'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($value['name'] . " - " . $value['Quantity'] . " available"); ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ClientName">Client</label>
                <select name="ClientName" id="ClientName">
                    <?php
                    $clients = ShowClient();
                    if (!empty($clients) && is_array($clients)) {
                        foreach ($clients as $value) {
                            ?>
                            <option value="<?= htmlspecialchars($value['ID_Client']); ?>" <?= !empty($product['ID_Client']) && $product['ID_Client'] == $value['ID_Client'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($value['name']); ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="QT">Quantity</label>
                <input type="number" name="Quantity" id="QT"
                    value="<?= !empty($product['Quantity']) ? htmlspecialchars($product['Quantity']) : ''; ?>"
                    placeholder="Quantity" min="1" onchange="SetPrice()">
            </div>

            <div class="form-group">
                <label for="Price">Total Price</label>
                <input value="<?= !empty($product['Price']) ? htmlspecialchars($product['Price']) : ''; ?>" 
                       type="number" name="Price" id="Price" placeholder="Price" readonly>
            </div>

            <!-- Hidden input to store the command ID if it's an update -->
            <?php if (!empty($_GET['id'])): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']); ?>">
                <input type="submit" name="update" value="UPDATE">
            <?php else: ?>
                <input type="submit" name="add" value="Purchase">
            <?php endif; ?>

            <!-- Display any messages from the session -->
            <?php
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
                echo '<div class="alert ' . htmlspecialchars($message['type']) . '">' . htmlspecialchars($message['text']) . '</div>';
                unset($_SESSION['message']); // Clear the message after displaying
            }
            ?>
        </form>

        <!-- Display cart details in a table -->
        <div class="container">
            <table class="protab">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Product ID</th>
                        <th>Client ID</th>
                        <th>Quantity</th>
                        <th>Date</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = ShowCart();
                    if (!empty($orders) && is_array($orders)) {
                        foreach ($orders as $order) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($order['Num_Comande']); ?></td>
                                <td><?= htmlspecialchars($order['ID_Product']); ?></td>
                                <td><?= htmlspecialchars($order['ID_Client']); ?></td>
                                <td><?= htmlspecialchars($order['Quantity']); ?></td>
                                <td><?= htmlspecialchars($order['Date']); ?></td>
                                <td><?= htmlspecialchars($order['TotalPrice']); ?></td>
                                <td><a href="?id=<?= htmlspecialchars($order['Num_Comande']); ?>"><i class='bx bxs-edit-alt'></i></a></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="7">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function SetPrice() {
            var product = document.getElementById('Proname');
            var priceField = document.getElementById('Price');
            var quantityField = document.getElementById('QT');
            var selectedOption = product.options[product.selectedIndex];
            var productPrice = selectedOption.getAttribute('data-price');
            
            // Calculate total price
            var totalPrice = Number(quantityField.value) * Number(productPrice);
            
            // Set the total price in the price field
            priceField.value = totalPrice;
        }
    </script>
</body>

</html>
