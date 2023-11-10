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
        <br>
        <?php
        $sql = "SELECT * FROM contract 
        LEFT JOIN type ON contract.type_id = type.type_id
        LEFT JOIN category ON contract.category_id = category.category_id
        LEFT JOIN vendor ON contract.vendor_id = vendor.vendor_id
        LEFT JOIN service_delivery_manager ON contract.sdm_id = service_delivery_manager.sdm_id
        LEFT JOIN expiration ON contract.expiration_id = expiration.expiration_id
        WHERE contract.category_id = '$category_id'";


        $result = $conn->query($sql);

        if ($result === false) {
            die("Error in SQL query: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="contract-field">
                    <strong>Contract No:</strong>
                    <?php echo $row['contract_no']; ?>
                </div>
                <div class="contract-field">
                    <strong>Type:</strong>
                    <?php echo $row['type']; ?>
                </div>
                <div class="contract-field">
                    <strong>Category:</strong>
                    <?php echo $row['category']; ?>
                </div>
                <div class="contract-field">
                    <strong>Description:</strong>
                    <?php echo $row['description']; ?>
                </div>
                <div class="contract-field">
                    <strong>Date of Agreement:</strong>
                    <?php echo $row['date_of_agreement']; ?>
                </div>
                <div class="contract-field">
                    <strong>Supplier Name:</strong>
                    <?php echo $row['contact_name']; ?>
                </div>
                <div class="contract-field">
                    <strong>Life of Contract:</strong>
                    <?php echo $row['life_of_contract']; ?>
                </div>
                <div class="contract-field">
                    <strong>SDM:</strong>
                    <?php echo $row['name']; ?>
                </div>
                <div class="contract-field">
                    <strong>SDM Remarks:</strong>
                    <?php echo $row['sdm_remarks']; ?>
                </div>
                <div class="contract-field">
                    <strong>Annual Spend:</strong>
                    <?php echo $row['annual_spend']; ?>
                </div>
                <div class="contract-field">
                    <strong>Payment Type:</strong>
                    <?php echo $row['payment_type']; ?>
                </div>
                <div class="contract-field">
                    <strong>Payment Terms:</strong>
                    <?php echo $row['payment_terms']; ?>
                </div>
                <div class="contract-field">
                    <strong>Status:</strong>
                    <?php echo $row['status']; ?>
                </div>
                <div class="contract-field">
                    <strong>Expiration Date:</strong>
                    <?php echo $row['date']; ?>
                </div>
                <!-- Add other contract fields here as needed -->

                <?php
            }
        } else {
            echo "<div class='no-contract-message'>No contracts available in this category.</div>";
        }
        ?>
    </div>
</body>

</html>