<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('./database/config.php');

if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_issue'])) {
    // Text data variables
    $contract_num = $_POST['contract-num'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $issuer_name = $_POST['issuer-name'];
    $issuer_role = $_POST['issuer-role'];

    $input_issue = "INSERT INTO issues (contract_no, subject, description, issuer_name, issuer_role)
                    VALUES ('$contract_num', '$subject', '$description', '$issuer_name', '$issuer_role')";

    $query = mysqli_query($conn, $input_issue);
    if ($query) {
        echo "<script>alert('Issue submitted successfully!')</script>";
        echo "<script>window.open('index.php?submit_issue', '_self')</script>";
    }
}
?>

<h1 style="text-align: left; padding-left: 5%;">Submit An Issue</h1>
<div class="form-container" style="background-color: yellow; color: #000;">
    <form method="post" action="index.php?submit_issue" id="form">
        <fieldset>
            <legend>Issue Details</legend>
            <ul class="form-flex-outer">
                <li>
                    <label for="contract-num">Contract No.</label>
                    <input type="text" id="contract-num" name="contract-num" placeholder="Enter Contract Number Here">
                </li>

                <li>
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter Issue Subject">
                </li>

                <li>
                    <label for="description">Description</label>
                    <textarea rows="6" id="description" name="description" placeholder="Enter Issue Description"></textarea>
                </li>

                <li>
                    <label for="issuer-name">Issuer Name</label>
                    <input type="text" id="issuer-name" name="issuer-name" placeholder="Enter Your Name">
                </li>

                <li>
                    <label for="issuer-role">Issuer Role</label>
                    <input type="text" id="issuer-role" name="issuer-role" placeholder="Enter Your Role">
                </li>

                <li>
                    <button type="submit" name="submit_issue">SUBMIT</button>
                </li>
            </ul>
        </fieldset>
    </form>
</div>