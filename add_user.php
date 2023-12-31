<h1 style="text-align: left; padding-left: 5%;">Add User</h1>
<div class="form-container" style="background-color: yellow; color: #000;">
    <form method="post" action="index.php?add_user" enctype="multipart/form-data" id="form">
        <fieldset>
            <legend>User Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="user_name">Name:</label>
                    <input type="text" id="user_name" name="user_name" placeholder="Enter User Name" required>
                </li>
                <li>
                    <label for="user_email">Email:</label>
                    <input type="email" id="user_email" name="user_email" placeholder="Enter User Email" required>
                </li>
                <li>
                    <label for="role_id">Role:</label>
                    <select id="role_id" name="role_id" required>
                        <option value="">Select Role</option>
                        <option value="1">Admin</option>
                        <option value="2">Client</option>
                    </select>
                </li>
                <li>
                    <label for="contact">Contact No.:</label>
                    <input type="tel" id="contact" name="contact" placeholder="Enter Contact number" required>
                </li>
                <li>
                    <button type="submit" name="add_user">Add User</button>
                </li>
            </ul>
        </fieldset>
    </form>
</div>
<?php
include('./database/config.php');

if (isset($_SESSION['logged']) != true) {
    echo "Not logged in";
    header("Location: login.php");
    die();
}

if (isset($_POST['add_user'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $role_id = $_POST['role_id'];

    // Set default password based on role
    $default_password = $role_id == 2 ? "vendor123" : "admin123";

    $insert_user = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)";
    $stmt_user = mysqli_prepare($conn, $insert_user);
    // Use $default_password directly instead of $hashed_password
    mysqli_stmt_bind_param($stmt_user, "sssi", $user_name, $user_email, $default_password, $role_id);


    if (mysqli_stmt_execute($stmt_user)) {
        $user_id = mysqli_insert_id($conn);

        // Insert additional info based on role
        if ($role_id == 2) {
            // Insert into vendor table
            $vendor_contact = mysqli_real_escape_string($conn, $_POST['contact']);
            $insert_vendor = "INSERT INTO vendor (vendor_id, contact_name, email, phone_no, role_id) VALUES (?, ?, ?, ?, ?)";
            $stmt_vendor = mysqli_prepare($conn, $insert_vendor);
            mysqli_stmt_bind_param($stmt_vendor, "isssi", $user_id, $user_name, $user_email, $vendor_contact, $role_id);
            mysqli_stmt_execute($stmt_vendor);
            mysqli_stmt_close($stmt_vendor);
        } else if ($role_id == 1) {
            // Insert into service_delivery_manager 
            $insert_user = "INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)";
            $stmt_user = mysqli_prepare($conn, $insert_user);
            // Use $default_password directly instead of $hashed_password
            mysqli_stmt_bind_param($stmt_user, "sssi", $user_name, $user_email, $default_password, $role_id);
        }
        $user_type = $role_id == 2 ? "Vendor" : "Admin";
        $insert_view_all_users = "INSERT INTO view_all_users (id, name, email, contact_phone, role_id, type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_view_all_users = mysqli_prepare($conn, $insert_view_all_users);
        mysqli_stmt_bind_param($stmt_view_all_users, "isssis", $user_id, $user_name, $user_email, $vendor_contact, $role_id, $user_type);
        mysqli_stmt_execute($stmt_view_all_users);
        mysqli_stmt_close($stmt_view_all_users);
        echo "<script>alert('New user added successfully!')</script>";
        echo "<script>window.open('index.php?add_user','_self')</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt_user);
}
