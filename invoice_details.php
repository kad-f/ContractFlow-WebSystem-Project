<?php
include('./database/config.php');

// Assuming you have the user's information in the session
$user_id = $_SESSION['id'];
$user_role_id = $_SESSION['role_id'];

?>

<style>
    th {
        background-color: yellow;
        color: #000;
    }
</style>

<div id="page-wrap">
    <h1>All Invoices</h1>
    <table>
        <thead>
            <tr>
                <th>S No.</th>
                <th>Contract No.</th>
                <th>Date</th>
                <th>Description</th>
                <th>File</th>
                <th>Download</th>
                <?php if ($user_role_id == 1) { ?>
                    <th>Edit</th>
                    <th>Remove</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($user_role_id == 1) {
                $get_invoice = "SELECT invoice.*, contract.vendor_id
                                FROM invoice
                                JOIN contract ON invoice.contract_no = contract.contract_no";
            } else {
                // Assuming vendor_id is in the vendors table
                $get_invoice = "SELECT invoice.*
                                FROM invoice
                                JOIN contract ON invoice.contract_no = contract.contract_no
                                WHERE contract.vendor_id = '$user_id'";
            }

            $result_invoice = mysqli_query($conn, $get_invoice);
            $i = 0;

            if (!$result_invoice) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result_invoice) == 0) {
                echo "<td>No invoices found.</td>";
            } else {
                while ($row_invoice = mysqli_fetch_array($result_invoice)) {
                    $contract_num = $row_invoice['contract_no'];
                    $date = $row_invoice['date'];
                    $description = $row_invoice['description'];
                    $file = $row_invoice['file'];
                    $i++;
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $contract_num; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><?php echo $file; ?></td>
                        <td><a href="download.php?file=<?php echo $file; ?>">Download</a></td>
                        <?php if ($user_role_id == 1) { ?>
                            <td><a href="edit_invoice.php?edit_invoice=<?php echo $contract_num; ?>">Edit</a></td>
                            <td><a href="delete_invoice.php?delete_invoice=<?php echo $contract_num; ?>">Delete</a></td>
                        <?php } ?>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>