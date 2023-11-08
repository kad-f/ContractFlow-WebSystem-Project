<?php
include('config.php');
if (isset($_SESSION['logged']) != true) {
    echo "Not logged in";
    header("Location: login.php");
    die();
}

function getVendorData($vendor_id, $conn)
{
    // Query the database to get vendor data
    $query = "SELECT * FROM vendor WHERE vendor_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vendor_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $vendor_data = mysqli_fetch_assoc($result);

    return $vendor_data;
}


if (isset($_GET['edit_vendor'])) {
    $vendor_id = $_GET['edit_vendor'];
    $vendor_data = getVendorData($vendor_id, $conn);
} else {
    echo "Invalid request";
    die();
}
?>

<h1>Edit Vendor</h1>
<div class="form-container">
    <form method="post" action="update_vendor.php" enctype="multipart/form-data" id="form">
        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
        <fieldset>
            <legend>Vendor Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="vendor_name">Name:</label>
                    <input type="text" id="vendor_name" name="vendor_name" placeholder="Enter Vendor Name" required
                        value="<?php echo $vendor_data['contact_name']; ?>">
                </li>
                <li>
                    <label for="vendor_email">Email:</label>
                    <input type="email" id="vendor_email" name="vendor_email" placeholder="Enter Vendor Email" required
                        value="<?php echo $vendor_data['email']; ?>">
                </li>
                <li>
                    <label for="vendor_contact">Contact No.:</label>
                    <input type="tel" id="vendor_contact" name="vendor_contact"
                        placeholder="Enter Vendor Contact number" required
                        value="<?php echo $vendor_data['phone_no']; ?>">
                </li>
                <li>
                    <button type="submit" name="update_vendor">Update Vendor</button>
                </li>
            </ul>
        </fieldset>
    </form>
</div>