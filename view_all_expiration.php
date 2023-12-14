<style>
    th {
        background-color: yellow;
        color: #000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>

<div id="page-wrap">
    <h1>All Expirations</h1>
    <table>
        <thead>
            <tr>
                <th>S No.</th>
                <th>Contract No.</th>
                <th>Date</th>
                <th>Renewal Provision</th>
                <th>Status Days</th>
                <th>Termination Rights</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have the user's information in the session
            $user_id = $_SESSION['id'];
            $user_role_id = $_SESSION['role_id'];

            // Initialize $get_expiration
            $get_expiration = '';

            if ($user_role_id == 1) {
                // Admin can see all expirations
                $get_expiration = "SELECT expiration.*, renewal_provision.renewal_provision
                                   FROM expiration
                                   JOIN renewal_provision ON expiration.renewal_provision_id = renewal_provision.renewal_provision_id";
            } else {
                // Vendor can only see their own expirations
                $get_expiration = "SELECT expiration.*, renewal_provision.renewal_provision
                                   FROM expiration
                                   JOIN contract ON expiration.contract_no = contract.contract_no
                                   JOIN renewal_provision ON expiration.renewal_provision_id = renewal_provision.renewal_provision_id
                                   WHERE contract.vendor_id = '$user_id'";
            }

            $result_expiration = mysqli_query($conn, $get_expiration);
            $i = 0;

            if (!$result_expiration) {
                die("Query failed: " . mysqli_error($conn) . " - SQL: " . $get_expiration);
            }

            if (mysqli_num_rows($result_expiration) == 0) {
                echo "<tr><td colspan='8'>No Expirations found.</td></tr>";
            } else {
                while ($row_expiration = mysqli_fetch_array($result_expiration)) {
                    $contract_num = $row_expiration['contract_no'];
                    $date = $row_expiration['date'];
                    $renewal_provision = $row_expiration['renewal_provision'];
                    $status_days = $row_expiration['status_days'];
                    $termination_rights = $row_expiration['termination_rights'];
                    $i++;
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $contract_num; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $renewal_provision; ?></td>
                        <td><?php echo $status_days; ?></td>
                        <td><?php echo $termination_rights; ?></td>
                        <td><a href="index.php?edit_expiration=<?php echo $contract_num; ?>">Edit</a></td>
                        <td><a href="delete_expiration.php?delete_expiration=<?php echo $contract_num; ?>">Delete</a></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>