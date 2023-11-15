<?php
include('./database/config.php');

// Query to get data from view_all_users table
$query = "SELECT * FROM view_all_users";
$result = mysqli_query($conn, $query);

// Output SQL query
echo "SQL Query: $query<br>";

// Check if the query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Fetch data
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
</head>

<body>
    <div id="page-wrap">
        <h1>All Users</h1>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Phone</th>
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display users
                foreach ($users as $row) {
                    echo "<tr>";
                    echo "<td>" . ($row['name'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['email'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['contact_phone'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['type'] ?? 'N/A') . "</td>";
                   if ($_SESSION['role_id'] != 2) { // Assuming 2 is the role_id for Vendor
                        echo "<td><a href='edit_user.php?type=" . ($row['UserType'] ?? '') . "&id=" . ($row['ID'] ?? '') . "'>Edit</a></td>";
                        echo "<td><a href='delete_user.php?type=" . ($row['UserType'] ?? '') . "&id=" . ($row['ID'] ?? '') . "'>Delete</a></td>";
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>