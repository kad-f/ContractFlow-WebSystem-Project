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
    <h1>All Renewals</h1>
    <table>
        <thead>
            <tr>
                <th>S No.</th>
                <th>Contract No.</th>
                <th>Renewal Provision</th>
                <th>Initial Term</th>
                <th>Renewal Periods</th>
                <th>Notice Day</th>
                <th>Renewal Date</th>
                <th>Renewal Conditions</th>
                <th>Edit</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have the user's information in the session
            $user_id = $_SESSION['id'];
            $user_role_id = $_SESSION['role_id'];

            // Initialize $get_renewal
            $get_renewal = '';

            if ($user_role_id == 1) {
                // Admin can see all renewals
                $get_renewal = "SELECT * FROM renewal_provision";
            } else {
                // Vendor can only see renewals associated with their contracts
                $get_renewal = "SELECT * FROM renewal_provision
                                WHERE contract_no IN (SELECT contract_no FROM contract WHERE vendor_id = '$user_id')";
            }

            $result_renewal = mysqli_query($conn, $get_renewal);
            $i = 0;

            if (!$result_renewal) {
                die("Query failed: " . mysqli_error($conn) . " - SQL: " . $get_renewal);
            }

            if (mysqli_num_rows($result_renewal) == 0) {
                echo "<tr><td colspan='10'>No Renewals found.</td></tr>";
            } else {
                while ($row_renewal = mysqli_fetch_array($result_renewal)) {
                    $contract_num = $row_renewal['contract_no'];
                    $renewal_provision = $row_renewal['renewal_provision'];
                    $initial_term = $row_renewal['initial_term'];
                    $renewal_periods = $row_renewal['renewal_periods'];
                    $notice_day = $row_renewal['notice_day'];
                    $renewal_date = $row_renewal['renewal_date'];
                    $renewal_conditions = $row_renewal['renewal_conditions'];
                    $i++;
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $contract_num; ?></td>
                        <td><?php echo $renewal_provision; ?></td>
                        <td><?php echo $initial_term; ?></td>
                        <td><?php echo $renewal_periods; ?></td>
                        <td><?php echo $notice_day; ?></td>
                        <td><?php echo $renewal_date; ?></td>
                        <td><?php echo $renewal_conditions; ?></td>
                        <td><a href="edit_renewal.php?edit_renewal=<?php echo $contract_num; ?>">Edit</a></td>
                        <td><a href="delete_renewal.php?delete_renewal=<?php echo $contract_num; ?>">Delete</a></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>