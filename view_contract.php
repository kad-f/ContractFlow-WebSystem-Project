<?php
include('./database/config.php');
session_start();
if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}

include('update_notifications.php');

// Get the category ID from the query parameter in the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if (!$category_id) {
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }

        .contract-card {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .contract-field {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .no-contract-message {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }

        .contract-field strong {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="contract-card">
        <h2>Contract Details</h2>
        <?php
        $sql = "SELECT * FROM contract WHERE category_id = '$category_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="contract-field">
                    <strong>Contract No:</strong>
                    <?php echo $row['contract_no']; ?>
                </div>
                <div class="contract-field">
                    <strong>Type ID:</strong>
                    <?php echo $row['type_id']; ?>
                </div>
                <div class="contract-field">
                    <strong>Type ID:</strong>
                    <?php echo $row['type_id']; ?>
                </div>
                <!-- Repeat the structure for other contract fields -->

                <?php
            }
        } else {
            echo "<div class='no-contract-message'>No contracts available in this category.</div>";
        }
        ?>
    </div>
</body>

</html>