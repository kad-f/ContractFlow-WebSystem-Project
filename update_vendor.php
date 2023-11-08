<?php
include('config.php'); // Include your database connection configuration

if (isset($_POST['update_vendor'])) {
    $vendor_id = $_POST['vendor_id'];
    $vendor_name = mysqli_real_escape_string($conn, $_POST['vendor_name']);
    $vendor_email = mysqli_real_escape_string($conn, $_POST['vendor_email']);
    $vendor_contact = mysqli_real_escape_string($conn, $_POST['vendor_contact']);

    // Use prepared statements to update the vendor data
    $update_vendor = "UPDATE vendor SET contact_name = ?, email = ?, phone_no = ? WHERE vendor_id = ?";
    $stmt = mysqli_prepare($conn, $update_vendor);
    mysqli_stmt_bind_param($stmt, "sssi", $vendor_name, $vendor_email, $vendor_contact, $vendor_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Vendor information updated successfully!')</script>";
        echo "<script>window.open('index.php?view_all_vendor', '_self')</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

?>