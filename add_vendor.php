<?php
include('config.php');
if (isset($_SESSION['logged']) != true) {
    echo "Not logged in";
    header("Location: login.php");
    die();
}
?>

<h1 style="text-align: left; padding-left: 5%;">Add Vendor</h1>
<div class="form-container">
    <form method="post" action="index.php?add_vendor" enctype="multipart/form-data" id="form">
        <fieldset>
            <legend>Vendor Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="vendor_name">Name:</label>
                    <input type="text" id="vendor_name" name="vendor_name" placeholder="Enter Vendor Name" required>
                </li>
                <li>
                    <label for="vendor_email">Email:</label>
                    <input type="email" id="vendor_email" name="vendor_email" placeholder="Enter Vendor Email" required>
                </li>
                <li>
                    <label for="vendor_contact">Contact No.:</label>
                    <input type="tel" id="vendor_contact" name="vendor_contact"
                        placeholder="Enter Vendor Contact number" required>
                </li>
                <li>
                    <button type="submit" name="add_vendor">Add Vendor</button>
                </li>
            </ul>
        </fieldset>
    </form>
</div>
<?php

if (isset($_POST['add_vendor'])) {
    $vendor_name = mysqli_real_escape_string($conn, $_POST['vendor_name']);
    $vendor_email = mysqli_real_escape_string($conn, $_POST['vendor_email']);
    $vendor_contact = mysqli_real_escape_string($conn, $_POST['vendor_contact']);

    // Use prepared statements to prevent SQL injection
    $insert_vendor = "INSERT INTO vendor (contact_name, email, phone_no) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_vendor);
    mysqli_stmt_bind_param($stmt, "sss", $vendor_name, $vendor_email, $vendor_contact);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('New Vendor added successfully!')</script>";
        echo"<script>window.open('index.php?add_vendor','_self')</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

?>