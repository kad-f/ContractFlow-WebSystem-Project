<?php
include('./database/config.php');

if (isset($_GET['contract_no'])) {
    
    $contractNo = $_GET['contract_no'];

    // Query to fetch events for a specific contract
    $sql = "SELECT * FROM calendar_event_master WHERE contract_no = '$contractNo'";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error in SQL query: " . $conn->error);
    }

    $events = [];

    while ($row = $result->fetch_assoc()) {
        // Create an array for each event
        $event = [
            'title' => $row['event_name'],
            'start' => $row['event_start_date'],
            'end' => $row['event_end_date'], 
        ];

        // Add the event to the events array
        $events[] = $event;
    }

    // Output events in JSON format
    echo json_encode($events);
}
