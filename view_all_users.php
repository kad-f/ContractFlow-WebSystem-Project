<?php
include('./database/config.php');

$query = "
SELECT
    u.name AS user_name, u.email AS user_email, r.name AS user_role,
    vr.contact_name AS vendor_name, vr.email AS vendor_email, vr.phone_no AS vendor_phone, vr.role_id AS vendor_role,
    sdm.name AS sdm_name, sdm.email AS sdm_email, sdm.phone_no AS sdm_phone, sdm.role_id AS sdm_role
FROM
    users u
JOIN
    user_role r ON u.role_id = r.role_id
LEFT JOIN
    vendor vr ON u.role_id = 2 AND u.id = vr.vendor_id
LEFT JOIN
    service_delivery_manager sdm ON u.role_id = 3 AND u.id = sdm.sdm_id
";

$result = mysqli_query($conn, $query);

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
                    <th>Role</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['user_name']}</td>";
                    echo "<td>{$row['user_email']}</td>";
                    echo "<td>{$row['user_role']}</td>";
                    echo "<td><a href='edit_user.php?id={$row['id']}'>Edit</a></td>";
                    echo "<td><a href='delete_user.php?id={$row['id']}'>Delete</a></td>";
                    echo "</tr>";

                    if ($row['vendor_name'] !== null) {
                        echo "<tr>";
                        echo "<td>{$row['vendor_name']}</td>";
                        echo "<td>{$row['vendor_email']}</td>";
                        echo "<td>{$row['vendor_role']}</td>";
                        echo "<td><a href='edit_user.php?id={$row['vendor_id']}'>Edit</a></td>";
                        echo "<td><a href='delete_user.php?id={$row['vendor_id']}'>Delete</a></td>";
                        echo "</tr>";
                    }

                    if ($row['sdm_name'] !== null) {
                        echo "<tr>";
                        echo "<td>{$row['sdm_name']}</td>";
                        echo "<td>{$row['sdm_email']}</td>";
                        echo "<td>{$row['sdm_role']}</td>";
                        echo "<td><a href='edit_user.php?id={$row['sdm_id']}'>Edit</a></td>";
                        echo "<td><a href='delete_user.php?id={$row['sdm_id']}'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>