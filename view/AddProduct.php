<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
</head>

<body>
    <form method="post" action="../model/addproduct.php">
        <div class="overview_Boxe">
            <div class="boxe">
                <label for="Proname">Product Name</label>
                <input type="text" name="ProductName" id="Proname" placeholder="Name" >
                
                <label for="Price">Price</label>
                <input type="number" name="Price" id="Price" placeholder="Price" >
                
                <label for="QT">Quantity</label>
                <input type="number" name="Quantity" id="QT" placeholder="Quantity" >
                
                <input type="submit" name="add" id="add" value="ADD">

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
        </div>
    </form>
</body>

</html>
