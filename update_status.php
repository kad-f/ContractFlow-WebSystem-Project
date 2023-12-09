<?php
// update_status.php

include('./database/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contractId = $_POST['contractId'];
    $status = $_POST['status'];

    // Perform database update
    $updateSql = "UPDATE contract SET status = '$status' WHERE contract_no = '$contractId'";
    $updateResult = $conn->query($updateSql);

    if ($updateResult === true) {
        // Send a success response
        header('Location: view_contract.php');
        echo json_encode(['success' => true]);
    } else {
        // Send an error response
        header('Location: view_contract.php');
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
