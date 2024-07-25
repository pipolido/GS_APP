<?php 
// include '../model/addproduct.php';
// include '../model/modifyproduct.php';
include '../model/showProduct.php';

$product = [];
if (!empty($_GET['id'])) {
    $product = ShowProduct($_GET['id']);
    // Debugging: Output the product data
    // echo '<pre>';
    // print_r($product);
    // echo '</pre>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Modify Product</title>
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
        }
        .alert.success {
            background-color: #4CAF50;
        }
        .alert.error {
            background-color: #f44336;
        }
    </style>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .protab {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        .protab th, .protab td {
            padding: 12px 15px;
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
            font-family: Arial, sans-serif;
            color: #333;
        }
    </style>

</head>

<body>
    <form method="post" action="<?= !empty($_GET['id']) && is_array($product) ? "../model/modifyProduct.php" : "../model/addproduct.php" ?>">
        <div class="overview_Boxe">
            <div class="boxe">
                <label for="Proname">Product Name</label>
                <input value="<?= !empty($_GET['id']) && is_array($product) ? htmlspecialchars($product['name']) : "" ?>" type="text" name="ProductName" id="Proname" placeholder="Name">
                
                <label for="Price">Price</label>
                <input value="<?= !empty($_GET['id']) && is_array($product) ? htmlspecialchars($product['Price']) : "" ?>" type="number" name="Price" id="Price" placeholder="Price">
                
                <label for="QT">Quantity</label>
                <input value="<?= !empty($_GET['id']) && is_array($product) ? htmlspecialchars($product['Quantity']) : "" ?>" type="number" name="Quantity" id="QT" placeholder="Quantity">
                
                <?php if (!empty($_GET['id'])): ?>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
                    <input type="submit" name="update" id="update" value="UPDATE">
                <?php else: ?>
                    <input type="submit" name="add" id="add" value="ADD">
                <?php endif; ?>

                <?php 
                    $message = isset($_SESSION['message']) ? $_SESSION['message'] : ['text' => '', 'type' => ''];
                    unset($_SESSION['message']);
                ?>

                <?php if (!empty($message['text'])): ?>
                    <div class="alert <?= htmlspecialchars($message['type']) ?>">
                        <?= htmlspecialchars($message['text']) ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="container">
                <table class="protab">
                    <tr>
                        <th>Id_Product</th>
                        <th>Product name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    
                    <?php 
                        $products = ShowProduct();
                        if (!empty($products) && is_array($products)) {
                            foreach ($products as $product) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($product['ID_Product']) ?></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['Price']) ?></td>
                                <td><?= htmlspecialchars($product['Quantity']) ?></td>
                                <td><a href="?id=<?= htmlspecialchars($product['ID_Product']) ?>"><i class='bx bxs-edit-alt'></i></a></td>
                            </tr>
                    <?php 
                            }
                        }
                    ?>
                </table>
            </div>

        </div>
    </form>
</body>

</html>
