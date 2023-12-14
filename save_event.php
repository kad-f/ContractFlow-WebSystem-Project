<?php
// Include necessary files and check session
include('./database/config.php');
include('update_notifications.php');

// Initialize the response array
$response = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data to prevent SQL injection
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_start_date = mysqli_real_escape_string($conn, $_POST['event_start_date']);
    $contract_no = mysqli_real_escape_string($conn, $_POST['contract_no']);

    // Your SQL query to insert the event into the database
    $sql = "INSERT INTO calendar_event_master (event_name, event_start_date, contract_no) VALUES ('$event_name', '$event_start_date', '$contract_no')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Event saved successfully");</script>';
        header("Location: index.php?view_contract");
        exit();
    } else {
        $response['status'] = false;
        $response['message'] = 'Error: ' . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the form is not submitted, redirect or handle accordingly
    header("Location: index.php");
    exit();
}
