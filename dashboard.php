<?php
include('./database/config.php');
include('update_notifications.php');

if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}

$roleID = $_SESSION['role_id'];

// Fetch and display contracts with type names
$query = "SELECT contract.*, type.type, category.category
          FROM contract
          LEFT JOIN type ON contract.type_id = type.type_id
          LEFT JOIN category ON contract.category_id = category.category_id";

$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Fetch data
$contracts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ContractFlow Dashboard</title>
</head>

<body>
    <div id="page-wrap">
        <h1>ContractFlow Dashboard</h1>

        <table>
            <thead>
                <tr>
                    <th>Reference No.</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Description</th>
                    <!-- Add more columns as needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Display contracts
                foreach ($contracts as $contract) {
                    echo "<tr>";
                    echo "<td>" . ($contract['contract_no'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($contract['type'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($contract['category'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($contract['description'] ?? 'N/A') . "</td>";
                    // Add more columns as needed
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>