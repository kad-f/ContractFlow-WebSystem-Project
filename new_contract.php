    <?php
    if (isset($_SESSION['logged']) != "true") {
        header("Location: login.php");
        die();
    }



    include('update_notifications.php');
    ?>

    <h1 style="text-align: left; padding-left: 5%;">Add New Contract</h1>
    <div class="form-container" style="background-color: yellow; color: #000;">
        <form method="post" action="index.php?new_contract" enctype="multipart/form-data" id="form">
            <fieldset>
                <legend>Contract Details</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="reference-num">Contract Number</label>
                        <input type="text" id="reference-num" name="reference-num" value="<?php echo strtoupper(uniqid()); ?>" placeholder="Enter contract reference number here">
                    </li>
                    <li>
                    <li>
                        <label for="contract_name">Contract Name</label>
                        <input type="text" name="contract_name" id="contract_name" placeholder="Enter Contract's Name here">
                    </li>

                    <li>
                        <label for="description">Contract Description</label>
                        <textarea rows="6" id="description" name="description" placeholder="Enter Contract Description here"></textarea>
                    </li>
                    <li>
                        <label for="product_type">Product Type</label>
                        <input type="text" name="product_type" id="product_type" placeholder="Enter type of computer parts or gadgets">
                    </li>
                    <li>
                        <label for="datepicker">Date of Purchase</label>
                        <input type="date" name="date" id="datepickerp">
                    </li>
                    <li>
                        <label for="life">Expected Lifespan (Years)</label>
                        <input type="number" name="life" id="life">
                    </li>
                    <li>
                        <label for="supplier">Name of Supplier</label>
                        <input type="text" name="supplier" id="supplier" placeholder="Enter Supplier's Name here">
                    </li>

                </ul>
            </fieldset>
            <!-- Client Details -->
            <fieldset>
                <legend>Client Details</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="vendor_id">Client</label>
                        <select name="vendor_id" id="vendor_id" required>
                            <option>Select a Client</option>
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
            <!-- Delivery Section -->
            <fieldset>
                <legend>Delivery Information</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="delivery_terms">Delivery Terms</label>
                        <textarea name="delivery_terms" id="delivery_terms" cols="30" rows="10"></textarea>
                    </li>
                    <li>
                        <label for="delivery_location">Delivery Location</label>
                        <input type="text" name="delivery_location" id="delivery_location" placeholder="Enter delivery location">
                    </li>
                    <li>
                        <label for="delivery_date">Delivery Date</label>
                        <input type="date" name="delivery_date" id="delivery_date">
                    </li>
                    <li>
                        <button type="button" onclick="generateDelivery()">Generate Delivery Terms</button>
                    </li>
                </ul>
            </fieldset>

            <script>
                function generateDelivery() {
                    var deliveryLocation = document.getElementById('delivery_location').value;
                    var deliveryDate = document.getElementById('delivery_date').value;
                    var deliveryTerms = document.getElementById('delivery_terms').value;
                    var contractName = document.getElementById('contract_name').value;
                    var buyerName = document.getElementById('vendor_id').value;
                    var supplierName = document.getElementById('supplier').value;

                    var deliveryTemplate = "**" + contractName + "**\n\n" +
                        "This section outlines the delivery terms for the products supplied under the " + contractName + ". Both parties agree to the following terms:\n\n" +
                        "1. **Delivery Location:** " + deliveryLocation + "\n" +
                        "2. **Delivery Date:** " + deliveryDate + "\n" +
                        "3. **Delivery Terms:** " + deliveryTerms + "\n\n" +
                        "The purpose of this agreement is to ensure the timely and secure delivery of products from " + supplierName + " to " + buyerName + ". Both parties agree to adhere to these delivery terms to facilitate a smooth and efficient delivery process.";

                    // Retain input values
                    var currentDeliveryTerms = document.getElementById('delivery_terms').value;
                    document.getElementById('delivery_terms').value = currentDeliveryTerms + deliveryTemplate;

                    // Set input values back
                    document.getElementById('contract_name').value = contractName;
                    document.getElementById('vendor_id').value = buyerName;
                    document.getElementById('supplier').value = supplierName;
                    document.getElementById('delivery_location').value = deliveryLocation;
                    document.getElementById('delivery_date').value = deliveryDate;
                }
            </script>

            <!-- Warranty Section -->
            <fieldset>
                <legend>Warranty Information</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="Warranty">Warranty</label>
                        <textarea name="warranty" id="warranty" rows="6"></textarea>
                    </li>
                    <li>
                        <label for="warranty_duration">Warranty Duration (in months)</label>
                        <input type="text" name="warranty_duration" id="warranty_duration">
                    </li>
                    <li>
                        <button type="button" onclick="generateWarranty()">Generate Warranty</button>
                    </li>
                </ul>
            </fieldset>

            <script>
                function generateWarranty() {
                    var duration = document.getElementById('warranty_duration').value;
                    var contractName = document.getElementById('contract_name').value;
                    var buyerName = document.getElementById('vendor_id').value;
                    var supplierName = document.getElementById('supplier').value;

                    var warrantyTemplate = "Supplier warrants that the Products shall be free from defects in materials and workmanship for a period of " + duration + " months from the date of delivery. Any defects discovered within this period shall be promptly rectified by Supplier at no additional cost to " + buyerName + ".";

                    // Retain input values
                    var currentWarrantyTerms = document.getElementById('warranty').value;
                    document.getElementById('warranty').value = currentWarrantyTerms + warrantyTemplate;

                    // Set input values back
                    document.getElementById('contract_name').value = contractName;
                    document.getElementById('vendor_id').value = buyerName;
                    document.getElementById('supplier').value = supplierName;
                    document.getElementById('warranty_duration').value = duration;
                }
            </script>

            <fieldset>
                <legend>Payment Terms</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="payment_terms">Payment Terms</label>
                        <textarea rows="6" name="payment_terms" id="payment_terms"></textarea>
                    </li>
                    <li>
                        <label for="payment_type">Payment Method</label>
                        <input name="payment_type" id="payment_type" required>
                    </li>
                    <li>
                        <label for="payment_day">Select Payment Day</label>
                        <select name="payment_day" id="payment_day">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </li>
                    <li>
                        <label for="payment_date">Payment Date</label>
                        <input type="date" name="payment_date" id="payment_date" class="payment-date" placeholder="Select payment date">
                    </li>
                    <li>
                        <label for="payment_description">Payment Description</label>
                        <textarea rows="6" name="payment_description" id="payment_description"></textarea>
                    </li>
                    <li>
                        <label for="spend">Annual Spend</label>
                        <input type="text" name="spend" id="spend" placeholder="Total Spend Annually">
                    </li>
                    <li>
                        <label for="status">Status</label>
                        <input type="text" id="status" name="status" placeholder="Enter status of payment here">
                    </li>
                    <li>
                        <button type="button" onclick="addPaymentEntry()">Add Payment Entry</button>
                    </li>
                </ul>
                <script>
                    function addPaymentEntry() {
                        var date = document.getElementById('payment_date').value;
                        var description = document.getElementById('payment_description').value;
                        var paymentType = document.getElementById('payment_type').value;
                        var paymentDay = document.getElementById('payment_day').value;
                        var spend = document.getElementById('spend').value;
                        var status = document.getElementById('status').value;
                        var contractName = document.getElementById('contract_name').value;
                        var buyerName = document.getElementById('vendor_id').value;
                        var supplierName = document.getElementById('supplier').value;
                        var dateStart = document.getElementById('datepickerp').value;
                        var paymentTermsTemplate = "**" + contractName + "**\n\n" +
                            "This section outlines the agreed-upon terms for financial transactions related to the " + contractName + ", " + buyerName + " and " + supplierName + ". Both parties commit to the following terms:\n\n" +
                            "1. **Payment Method:** " + paymentType + "\n" +
                            "2. **Payment Schedule:** [Specify Payment Schedule, e.g., Monthly, Quarterly, Annually]\n" +
                            "3. **Payment Details:**\n" +
                            "   - **Payment Day:** " + paymentDay + "\n" +
                            "   - **Payment Date:** " + date + "\n" +
                            "   - **Payment Description:** " + description + "\n" +
                            "4. **Annual Payment Commitment:**₱" + spend + "\n" +
                            "5. **Status:** " + status + "\n\n" +
                            "The purpose of this agreement is to establish a clear framework for the timely and secure transfer of funds between the parties in accordance with the terms specified in the broader " + contractName + ".\n\n" +
                            "Both parties agree to adhere to these financial arrangements to ensure a smooth and transparent transaction process.\n\n" +
                            "" + dateStart + "";

                        // Retain input values
                        var currentPaymentTerms = document.getElementById('payment_terms').value;
                        document.getElementById('payment_terms').value = currentPaymentTerms + paymentTermsTemplate;

                        // Set input values back
                        document.getElementById('contract_name').value = contractName;
                        document.getElementById('vendor_id').value = buyerName;
                        document.getElementById('supplier').value = supplierName;
                        document.getElementById('datepickerp').value = dateStart;
                        document.getElementById('payment_date').value = date;
                        document.getElementById('payment_day').value = paymentDay;
                        document.getElementById('payment_description').value = description;
                        document.getElementById('spend').value = spend;
                        document.getElementById('status').value = status;
                    }
                </script>


            </fieldset>


            <fieldset>
                <legend>Contract Expiration</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="e-datepicker">Expiration Date</label>
                        <input type="date" name="expiration_date" id="e-datepicker">
                    </li>
                </ul>
            </fieldset>
            <!-- Renewal Provision -->
            <fieldset>
                <legend>Renewal Provision</legend>
                <ul class="form-flex-outer">
                    <li>
                        <input type="hidden" name="assignment_provision">
                    </li>
                    <li>
                        <label for="renewal_provisions">Renewal Provisions</label>
                        <textarea rows="6" name="renewal_provisions" id="renewal_provisions" placeholder="Renewal provisions"></textarea>
                    </li>
                    <li>
                        <label for="initial_term">Initial Term (in years)</label>
                        <input type="text" name="initial_term" id="initial_term" placeholder="Enter initial term in years">
                    </li>
                    <li>
                        <label for="renewal_periods">Renewal Periods (in years)</label>
                        <input type="text" name="renewal_periods" id="renewal_periods" placeholder="Enter renewal periods in years">
                    </li>
                    <li>
                        <label for="notice_day">Select Notice Day</label>
                        <select name="notice_day" id="notice_day">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </li>
                    <li>
                        <label for="renewal_date">Renewal Date</label>
                        <input type="date" name="renewal_date" id="renewal_date" placeholder="Select renewal date">
                    </li>
                    <li>
                        <label for="renewal_conditions">Renewal Conditions</label>
                        <textarea rows="6" name="renewal_conditions" id="renewal_conditions" placeholder="Enter renewal conditions"></textarea>
                    </li>
                    <li>
                        <button type="button" onclick="generateRenewalProvision()">Generate Renewal Provision</button>
                    </li>
                </ul>
                <script>
                    function generateRenewalProvision() {
                        var initialTerm = document.getElementById('initial_term').value;
                        var renewalPeriods = document.getElementById('renewal_periods').value;
                        var noticeDay = document.getElementById('notice_day').value;
                        var renewalDate = document.getElementById('renewal_date').value;
                        var renewalConditions = document.getElementById('renewal_conditions').value;

                        var renewalProvision = "The initial term of this Agreement shall be " + initialTerm + " years from the effective date. " +
                            "Upon expiration of the initial term, this Agreement shall automatically renew for successive periods of " +
                            renewalPeriods + " years each, unless either party provides written notice of non-renewal at least " +
                            noticeDay + " prior to the expiration of the then-current term. " +
                            "The terms and conditions of the renewed Agreement shall be the same as the initial term unless otherwise " +
                            "mutually agreed upon in writing by both parties. The renewal date is set for " +
                            renewalDate + ".\n\n" + renewalConditions + ""

                        ;

                        var existingContent = document.getElementById('renewal_provisions').value;

                        var finalContent = existingContent + '\n\n' + renewalProvision;

                        // Set values for both renewal_provisions and assignment_provision
                        document.getElementById('renewal_provisions').value = finalContent;
                        document.getElementsByName('assignment_provision')[0].value = finalContent;

                        // Retain input values
                        document.getElementById('initial_term').value = initialTerm;
                        document.getElementById('renewal_periods').value = renewalPeriods;
                        document.getElementById('notice_day').value = noticeDay;
                        document.getElementById('renewal_date').value = renewalDate;
                        document.getElementById('renewal_conditions').value = renewalConditions;
                    }
                </script>


            </fieldset>



            <!-- Termination Rights/Provision -->
            <fieldset>
                <legend>Termination Rights/Provision</legend>
                <ul class="form-flex-outer">
                    <li>
                        <label for="termination_provisions">Termination Provisions</label>
                        <textarea rows="6" name="termination_provisions" id="termination_provisions" placeholder="Termination provisions"></textarea>
                    </li>
                    <li>
                        <label for="termination_notice_day">Select Termination Notice Day</label>
                        <select name="termination_notice_day" id="termination_notice_day">
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <!-- Add more options as needed -->
                        </select>
                    </li>
                    <li>
                        <label for="termination_date">Termination Date</label>
                        <input type="date" name="termination_date" id="termination_date" placeholder="Select termination date">
                    </li>
                    <li>
                        <label for="termination_conditions">Termination Conditions</label>
                        <textarea rows="5" name="termination_conditions" id="termination_conditions" placeholder="Enter termination conditions"></textarea>
                    </li>

                    <li>
                        <button type="button" onclick="generateTerminationProvision()">Generate Termination Provision</button>
                    </li>
                </ul>
                <script>
                    function generateTerminationProvision() {
                        var terminationNoticeDay = document.getElementById('termination_notice_day').value;
                        var terminationDate = document.getElementById('termination_date').value;
                        var terminationConditions = document.getElementById('termination_conditions').value;

                        var terminationProvision = "Either party may terminate this Agreement by providing written notice of termination " +
                            "at least " + terminationNoticeDay + " days.\n" +
                            "Termination Date: " + terminationDate + "\n" +
                            terminationConditions;

                        var existingContent = document.getElementById('termination_provisions').value;

                        var finalContent = existingContent + '\n\n' + terminationProvision;

                        document.getElementById('termination_provisions').value = finalContent;

                        // Retain input values
                        document.getElementById('termination_notice_days').value = terminationNoticeDays;
                        document.getElementById('termination_notice_day').value = terminationNoticeDay;
                        document.getElementById('termination_date').value = terminationDate;
                        document.getElementById('termination_conditions').value = terminationConditions;
                    }
                </script>

                \
            </fieldset>

            <fieldset>
                <legend>
                    <ul class="form-flex-outer">
                        <li>
                            <button type="submit" name="create_contract">SUBMIT</button>
                        </li>
                    </ul>
                </legend>
            </fieldset>


        </form>
    </div>
    <?php

    if (isset($_POST['create_contract'])) {
        //Text data variables
        $contract_name = mysqli_real_escape_string($conn, $_POST['contract_name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $life = mysqli_real_escape_string($conn, $_POST['life']);
        $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
        $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);
        $spend = mysqli_real_escape_string($conn, $_POST['spend']);
        $terms = mysqli_real_escape_string($conn, $_POST['payment_terms']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        $vendor_id = mysqli_real_escape_string($conn, $_POST['vendor_id']);
        $expiration_date =  mysqli_real_escape_string($conn, $_POST['expiration_date']);
        $renewal_provision = mysqli_real_escape_string($conn, $_POST['renewal_provisions']);
        $termination_provision = mysqli_real_escape_string($conn, $_POST['termination_provisions']);
        $assignment_provision = mysqli_real_escape_string($conn, $_POST['assignment_provision']);
        $reference_num = mysqli_real_escape_string($conn, $_POST['reference-num']);
        
        $productype = mysqli_real_escape_string($conn, $_POST['product_type']);
        $warranty = mysqli_real_escape_string($conn, $_POST['warranty']);
        $delivery_terms = mysqli_real_escape_string($conn, $_POST['delivery_terms']);
        $created_at = date('Y-m-d H:i:s');

        // Check if the contract already exists in the selected category
        $check_contract_query = "SELECT * FROM contract WHERE contract_no = '$reference_num'";
        $check_contract_result = mysqli_query($conn, $check_contract_query);

        if (mysqli_num_rows($check_contract_result) > 0) {
            echo "<script>alert('Contract already exists.');</script>";
        } else {
            $initial_term_text = mysqli_real_escape_string($conn, $_POST['initial_term']);
            $renewal_periods_text = mysqli_real_escape_string($conn, $_POST['renewal_periods']);
            $notice_day_text = mysqli_real_escape_string($conn, $_POST['notice_day']);
            $renewal_date_text = mysqli_real_escape_string($conn, $_POST['renewal_date']);
            $renewal_conditions_text = mysqli_real_escape_string($conn, $_POST['renewal_conditions']);
            // Insert into renewal_provision
            $insert_renewal_provision = "INSERT INTO renewal_provision(contract_no, renewal_provision, initial_term, renewal_periods, notice_day, renewal_date, renewal_conditions) VALUES ('$reference_num', '$renewal_provision', '$initial_term_text', '$renewal_periods_text', '$notice_day_text', '$renewal_date_text', '$renewal_conditions_text')";
            mysqli_query($conn, $insert_renewal_provision);
            $renewal_provision_id = mysqli_insert_id($conn);
            // Insert expiration details
            $insert_expiration = "INSERT INTO expiration(contract_no, date, renewal_provision_id, termination_rights, renewal_provision, notified) VALUES ('$reference_num', '$expiration_date', '$renewal_provision_id', '$termination_provision', '$renewal_provision', 0)";
            mysqli_query($conn, $insert_expiration);
            $expiration_id = mysqli_insert_id($conn);
            // Insert contract details
            $insert_contract = "INSERT INTO contract(contract_no, contract_name, description, date_of_agreement, supplier_name, product_type, life_of_contract, vendor_id, annual_spend, payment_type, payment_terms, warranty, delivery_terms,  status, expiration_id, created_at) VALUES ('$reference_num', '$contract_name', '$description', '$date', '$supplier', '$productype', '$life', '$vendor_id','$spend', '$payment_type', '$terms', '$warranty', '$delivery_terms', '$status', '$expiration_id', '$created_at')";
            echo $insert_contract;
            $result_contract = mysqli_query($conn, $insert_contract);

            if ($result_contract) {

                $delivery_date = mysqli_real_escape_string($conn, $_POST['$delivery_date']);
                $delivery_loc = mysqli_real_escape_string($conn, $_POST['delivery_location']);
                $delivery_terms_qry = "INSERT INTO delivery_terms(contract_no, vendor_id, supplier_name, delivery_location, delivery_date, delivery_terms) VALUES('$reference_num', '$vendor_id', '$supplier', '$delivery_loc', '$delivery_date', '$delivery_terms')";
                mysqli_query($conn, $delivery_terms_qry);

                $warranty_duration = mysqli_real_escape_string($conn, $_POST['warranty_duration']);
                $warranty_terms_qry = "INSERT INTO warranty_terms(contract_no, vendor_id, supplier_name, warranty_duration, warranty_terms) VALUES('$reference_num', '$vendor_id', '$supplier', '$warranty_duration', '$warranty')";
                mysqli_query($conn, $warranty_terms_qry);
                
                $payment_terms = mysqli_real_escape_string($conn, $_POST['payment_terms']);
                $payment_type_text = mysqli_real_escape_string($conn, $_POST['payment_type']);
                $payment_schedule_text = mysqli_real_escape_string($conn, $_POST['payment_day']);
                $payment_date_text = mysqli_real_escape_string($conn, $_POST['payment_date']);
                $payment_description_text = mysqli_real_escape_string($conn, $_POST['payment_description']);
                $spend_text = mysqli_real_escape_string($conn, $_POST['spend']);
                $status_text = mysqli_real_escape_string($conn, $_POST['status']);
             
                $insert_payment_terms = "INSERT INTO payment_type(contract_no, payment_name, payment_terms, payment_schedule, payment_date, payment_description, annual_spend, status) VALUES ('$reference_num', '$payment_type_text', '$payment_terms', '$payment_schedule_text', '$payment_date_text', '$payment_description_text', '$spend_text', '$status_text')";
                mysqli_query($conn, $insert_payment_terms);


                $termination_notice_day_text = mysqli_real_escape_string($conn, $_POST['termination_notice_day']);
                $termination_date_text = mysqli_real_escape_string($conn, $_POST['termination_date']);
                $termination_conditions_text = mysqli_real_escape_string($conn, $_POST['termination_conditions']);

                // Insert into termination_rights
                $insert_termination_rights = "INSERT INTO termination_rights(termination_provisions, contract_no, termination_notice_day, termination_date, termination_conditions) VALUES ('$termination_provision ','$reference_num',  '$termination_notice_day_text', '$termination_date_text', '$termination_conditions_text')";
                mysqli_query($conn, $insert_termination_rights);

                $add_notification = "Insert into notification(contract_no,status, notification_text) values('$reference_num',0,'Contract $reference_num Added ')";
                mysqli_query($conn, $add_notification);
                echo "<script>alert('Contract successfully created!');</script>";
                echo "<script>window.open('index.php?new_contract','_self')</script>";
            }
        }
    }
    ?>