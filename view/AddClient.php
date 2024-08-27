<?php 
include '../model/Functions.php';

$Client = [];
if (!empty($_GET['id'])) {
    $Client = ShowClient($_GET['id']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Modify Client</title>
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
    <form method="post" action="<?= !empty($_GET['id']) && is_array($Client) ? "../model/modifyClient.php" : "../model/addClient.php" ?>">
        <div class="overview_Boxe">
            <div class="boxe">
                <label for="ClientName">Client Name</label>
                <input value="<?= !empty($_GET['id']) && is_array($Client) ? htmlspecialchars($Client['name']) : "" ?>" type="text" name="ClientName" id="ClientName" placeholder="Name">
                
                <label for="tele">Phone</label>
                <input value="<?= !empty($_GET['id']) && is_array($Client) ? htmlspecialchars($Client['Telephone']) : "" ?>" type="text" name="tele" id="tele" placeholder="N° Téléphone">
                
                <label for="Adr">Adresse</label>
                <input value="<?= !empty($_GET['id']) && is_array($Client) ? htmlspecialchars($Client['Adresse']) : "" ?>" type="text" name="Adr" id="Adr" placeholder="Adresse">
                
                <label for="Adrmail">Adresse mail</label>
                <input value="<?= !empty($_GET['id']) && is_array($Client) ? htmlspecialchars($Client['Adressemail']) : "" ?>" type="email" name="Adremail" id="Adrmail" placeholder="Adresse mail">

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
                        <th>Id_Client</th>
                        <th>Client name</th>
                        <th>Phone</th>
                        <th>Adresse</th>
                        <th>Adresse mail</th>
                        <th>Action</th>
                    </tr>
                    
                    <?php 
                        $Clients = ShowClient();
                        if (!empty($Clients) && is_array($Clients)) {
                            foreach ($Clients as $Client) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($Client['ID_Client']) ?></td>
                                <td><?= htmlspecialchars($Client['name']) ?></td>
                                <td><?= htmlspecialchars($Client['Telephone']) ?></td>
                                <td><?= htmlspecialchars($Client['Adresse']) ?></td>
                                <td><?= htmlspecialchars($Client['Adressemail']) ?></td>
                                <td><a href="?id=<?= htmlspecialchars($Client['ID_Client']) ?>"><i class='bx bxs-edit-alt'></i></a></td>
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
