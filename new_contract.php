<?php
if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}



include('update_notifications.php');
?>
<h1 style="text-align: left; padding-left: 5%;">Add New Contract</h1>
<div class="form-container">
    <form method="post" action="index.php?new_contract" enctype="multipart/form-data" id="form">
        <fieldset>
            <legend>Contract Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="reference-num">Reference No.</label>
                    <input type="text" id="reference-num" name="reference-num" value="<?php echo strtoupper(uniqid()); ?>" placeholder="Enter contract reference number here">
                </li>
                <li>
                    <p>Type</p>
                    <ul class="form-flex-inner">
                        <li>
                            <input type="radio" id="hardware" name="contract_type" value="hardware">
                            <label for="hardware">Hardware</label>
                        </li>
                        <li>
                            <input type="radio" id="software" name="contract_type" value="software" checked="checked">
                            <label for="software">Software</label>
                        </li>
                        <li>
                            <input type="radio" id="license" name="contract_type" value="license">
                            <label for="license">License</label>
                        </li>
                        <li>
                            <input type="radio" id="other" name="contract_type" value="other">
                            <label for="other">Other</label>
                        </li>
                    </ul>
                </li>
                <li>
                    <label for="category">Category</label>
                    <select name="category" id="category" required>
                        <option>Select a Category</option>
                        <?php
                        $get_category = "select * from category";
                        $result_category = mysqli_query($conn, $get_category);
                        while ($row_category = mysqli_fetch_array($result_category)) {
                            $category_id = $row_category['category_id'];
                            $category_name = $row_category['category'];
                            echo "<option value = '$category_id'>$category_name</option>";
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="description">Description</label>
                    <textarea rows="6" id="description" name="description" placeholder="Enter Goods/Services Description here"></textarea>
                </li>
                <li>
                    <label for="datepicker">Date of Agreement</label>
                    <input type="text" name="date" id="datepicker">
                </li>
                <li>
                    <label for="life">Total Committed Value (Years)</label>
                    <input type="number" name="life" id="life">
                </li>
                <li>
                    <label for="supplier">Name of Supplier</label>
                    <input type="text" name="supplier" id="supplier" placeholder="Enter Supplier's Name here">
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <ul class="form-flex-outer">
                <li>
                    <label for="payment_type">Payment Type</label>
                    <select name="payment_type" id="payment_type" required>
                        <option>Select a Payment Type</option>
                        <?php
                        $get_payment_types = "SELECT * FROM payment_type";
                        $result_payment_types = mysqli_query($conn, $get_payment_types);
                        while ($row_payment_type = mysqli_fetch_array($result_payment_types)) {
                            $payment_type_id = $row_payment_type['payment_type_id'];
                            $payment_type_name = $row_payment_type['payment_name'];
                            echo "<option value='$payment_type_id'>$payment_type_name</option>";
                        }
                        ?>
                    </select>
                </li>

                <li>
                    <label for="spend">Annual Spend</label>
                    <input type="text" name="spend" id="spend" placeholder="Total Spend Annually">
                </li>
                <li>
                    <label for="terms">Terms</label>
                    <textarea rows="6" name="payment_terms" id="terms" placeholder="Enter terms of payment here"></textarea>
                </li>
                <li>
                    <label for="status">Status</label>
                    <input type="text" id="status" name="status" placeholder="Enter status of payment here">
                </li>
            </ul>
        </fieldset>
        <!-- Vendor Details -->
        <fieldset>
            <legend>Vendor Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="vendor_id">Vendor</label>
                    <select name="vendor_id" id="vendor_id" required>
                        <option>Select a Vendor</option>
                        <?php
                        $get_vendors = "SELECT * FROM vendor";
                        $result_vendors = mysqli_query($conn, $get_vendors);
                        while ($row_vendor = mysqli_fetch_array($result_vendors)) {
                            $vendor_id = $row_vendor['vendor_id'];
                            $vendor_name = $row_vendor['contact_name'];
                            echo "<option value='$vendor_id'>$vendor_name</option>";
                        }
                        ?>
                    </select>
                </li>
            </ul>
        </fieldset>

        <!-- Service Delivery Manager Details -->
        <fieldset>
            <legend>Service Delivery Manager</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="sdm_id">Service Delivery Manager</label>
                    <select name="sdm_id" id="sdm_id" required>
                        <option>Select a Service Delivery Manager</option>
                        <?php
                        $get_sdms = "SELECT * FROM service_delivery_manager";
                        $result_sdms = mysqli_query($conn, $get_sdms);
                        while ($row_sdm = mysqli_fetch_array($result_sdms)) {
                            $sdm_id = $row_sdm['sdm_id'];
                            $sdm_name = $row_sdm['name'];
                            echo "<option value='$sdm_id'>$sdm_name</option>";
                        }
                        ?>
                    </select>
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Contract Expiration and Notices</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="e-datepicker">Expiration Date</label>
                    <input type="text" name="expiration_date" id="e-datepicker">
                </li>
                <li>
                    <label for="renewal_provision">Renewal Provision</label>
                    <select name="renewal_provision" id="renewal_provision" required>
                        <option>Choose Renewal Provision</option>
                        <?php
                        $get_renewal_provision = "select * from renewal_provision";
                        $result_renewal_provision = mysqli_query($conn, $get_renewal_provision);
                        while ($row_renewal_provision = mysqli_fetch_array($result_renewal_provision)) {
                            $renewal_provision_id = $row_renewal_provision['renewal_provision_id'];
                            $renewal_provision_name = $row_renewal_provision['renewal_provision'];
                            echo "<option value = '$renewal_provision_id'>$renewal_provision_name</option>";
                        }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="termination_provision">Termination Rights / Provision</label>
                    <textarea rows="6" name="termination_provision" id="termination_provision" placeholder="Enter Remarks here"></textarea>
                </li>
                <li>
                    <label for="assignment_provision">Assignment Provision</label>
                    <input type="text" id="assignment_provision" name="assignment_provision" placeholder="Assignment Provision">
                </li>
                <li>
                    <input type="submit" name="create_contract">
                </li>
            </ul>
        </fieldset>
    </form>
</div>
<?php

if (isset($_POST['create_contract'])) {
    //Text data variables
    $contract_type = $_POST['contract_type'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $dateArray = explode('/', $_POST['date']);
    $date = $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
    $life = mysqli_real_escape_string($conn, $_POST['life']);
    $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
    $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);
    $spend = mysqli_real_escape_string($conn, $_POST['spend']);
    $terms = mysqli_real_escape_string($conn, $_POST['payment_terms']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $vendor_id = mysqli_real_escape_string($conn, $_POST['vendor_id']);
    $sdm_id = mysqli_real_escape_string($conn, $_POST['sdm_id']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']); //Insert rest into expiration
    $expirationDateArray = explode('/', $_POST['expiration_date']);
    $expiration_date = $expirationDateArray[2] . '-' . $expirationDateArray[0] . '-' . $expirationDateArray[1];
    $renewal_provision = mysqli_real_escape_string($conn, $_POST['renewal_provision']);
    $termination_provision = mysqli_real_escape_string($conn, $_POST['termination_provision']);
    $assignment_provision = mysqli_real_escape_string($conn, $_POST['assignment_provision']);
    // Generate a unique reference number
    $reference_num = strtoupper(uniqid());
    $created_at = date('Y-m-d H:i:s');
    
    // Check if the contract already exists in the selected category
    $check_contract_query = "SELECT * FROM contract WHERE category_id = '$category' AND contract_no = '$reference_num'";
    $check_contract_result = mysqli_query($conn, $check_contract_query);

    if (mysqli_num_rows($check_contract_result) > 0) {
        echo "<script>alert('Contract already exists in this category.');</script>";
    } else {
        // Insert expiration details
        $insert_expiration = "INSERT INTO expiration(contract_no, date, renewal_provision_id, termination_rights, assignment_provision, notified) VALUES ('$reference_num','$expiration_date', '$renewal_provision', '$termination_provision', '$assignment_provision',0)";
        mysqli_query($conn, $insert_expiration);
        $expiration_id = mysqli_insert_id($conn);

        // Insert contract details
        $insert_contract = "INSERT INTO contract(contract_no, type_id, category_id, description, date_of_agreement, supplier_name, life_of_contract, vendor_id, sdm_id, sdm_remarks, annual_spend, payment_type, payment_terms, status, expiration_id, created_at) VALUES ('$reference_num', '$contract_type', '$category', '$description', '$date', '$supplier', '$life', '$vendor_id', '$sdm_id', '$remarks', '$spend', '$payment_type', '$terms', '$status', '$expiration_id', '$created_at')";
    $result_contract = mysqli_query($conn, $insert_contract);

        if ($result_contract) {
            // Add notification
            $add_notification = "INSERT INTO notification(contract_no, status, notification_text) VALUES ('$reference_num', 0, 'Contract $reference_num Added')";
            mysqli_query($conn, $add_notification);

            echo "<script>window.open('index.php?new_contract','_self')</script>";
        }
    }
}
?>