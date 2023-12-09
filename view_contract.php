<?php
include('./database/config.php');
session_start();
if (isset($_SESSION['logged']) != "true") {
    header("Location: login.php");
    die();
}

include('update_notifications.php');

// Get the category ID from the query parameter in the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if (!$category_id) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Details</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.print.min.css"></script>

    <!-- ... (your existing scripts) -->


    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
            text-decoration: none;
        }

        .contract-card {
            max-width: 90%;
            margin: 0 auto;
            background-color: yellow;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            overflow-x: auto;
            /* Added for horizontal scrolling if needed */
        }

        .contract-field {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h2 {
            color: #333;
            text-align: center;
            font-size: 1.5em;
            /* Adjusted for responsiveness */
        }

        .contract-field strong {
            display: block;
            font-size: 1.2em;
            /* Adjusted for responsiveness */
            color: #333;
            margin-bottom: 5px;
        }

        .contract-field strong {
            display: block;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        #calendar {
            flex: 0 0 48%;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .Complete {
            background-color: yellowgreen;
            /* Adjust the color based on your needs */
        }

        .Delayed {
            background-color: orange;
        }

        .NotDelivered {
            background-color: red;
        }

        .Expired {
            background-color: black;
        }

        .default {
            background-color: gray;
            /* Default color for other statuses */
        }

        @media only screen and (max-width: 600px) {
            .contract-card {
                max-width: 100%;
                /* Adjusted for smaller screens */
            }

            h2 {
                font-size: 1.2em;
                /* Adjusted for smaller screens */
            }

            .contract-field strong {
                font-size: 1em;
                /* Adjusted for smaller screens */
            }
        }
    </style>
</head>

<body>
    <div class="contract-card">
        <h2>Contract Details</h2>
        <br>
        <?php
        // Get the category ID from the query parameter in the URL
        $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

        if (!$category_id) {
            header("Location: index.php");
            exit();
        }

        function getStatusColor($status)
        {
            $statusColors = [
                'Delivered' => 'yellowgreen',
                'Delayed' => 'orange',
                'Not Delivered' => 'red',
                'Expired' => 'black',
                'default' => 'gray', // Default color for other statuses
            ];

            return $statusColors[$status] ?? $statusColors['default'];
        }
        // Check the user's role
        $role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : null;
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        if ($role_id == 1 || $role_id == 3) {
            // Admin can see all contracts
            $sql = "SELECT * FROM contract 
                    LEFT JOIN type ON contract.type_id = type.type_id
                    LEFT JOIN category ON contract.category_id = category.category_id
                    LEFT JOIN vendor ON contract.vendor_id = vendor.vendor_id
                    LEFT JOIN service_delivery_manager ON contract.sdm_id = service_delivery_manager.sdm_id
                    LEFT JOIN expiration ON contract.expiration_id = expiration.expiration_id
                    LEFT JOIN payment_type ON contract.payment_type = payment_type.payment_type_id
                    WHERE contract.category_id = '$category_id'";
        } else if ($role_id == 2) {
            $vendor_id = $_SESSION['id'];
            $sql = "SELECT * FROM contract 
            LEFT JOIN type ON contract.type_id = type.type_id
            LEFT JOIN category ON contract.category_id = category.category_id
            LEFT JOIN vendor ON contract.vendor_id = vendor.vendor_id
            LEFT JOIN service_delivery_manager ON contract.sdm_id = service_delivery_manager.sdm_id
            LEFT JOIN expiration ON contract.expiration_id = expiration.expiration_id
            LEFT JOIN payment_type ON contract.payment_type = payment_type.payment_type_id
            WHERE contract.vendor_id = '$vendor_id' AND contract.category_id = '$category_id'";
        }

        $result = $conn->query($sql);

        if ($result === false) {
            die("Error in SQL query: " . $conn->error);
        }

        $statusColors = [
            'Complete' => 'green',
            'Delayed' => 'orange',
            'Not Delivered' => 'red',
            'Expired' => 'black',
            'default' => '', // Default color for other statuses
        ];

        $events = []; // Initialize the $events array

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $startAgreement = $row['created_at'];
                $endAgreement = $row['date']; // Use 'expiration_date' instead of 'expiration_id'
                $status = $row['status'];

                // Convert the date strings to ISO8601 format with explicit time format
                $isoStartDate = date('Y-m-d H:i A', strtotime($startAgreement));
                $isoEndDate = date('Y-m-d H:i A', strtotime($endAgreement));

                // Event for date_of_agreement with color based on status
                $events[] = [
                    'title' => 'Created Date',
                    'start' => $isoStartDate,
                    'className' => $status,
                ];

                // Event for expiration_date with color based on status
                $events[] = [
                    'title' => 'Expiration Date',
                    'start' => $isoEndDate,
                    'className' => $status,
                ];
                $contractNumber = $row['contract_no'];
        ?>

                <div class="contract-field">
                    <strong>Contract No:</strong>
                    <?php echo $row['contract_no']; ?>
                </div>
                <div class="contract-field">
                    <strong>Type:</strong>
                    <?php echo $row['type']; ?>
                </div>
                <div class="contract-field">
                    <strong>Category:</strong>
                    <?php echo $row['category']; ?>
                </div>
                <div class="contract-field">
                    <strong>Description:</strong>
                    <?php echo $row['description']; ?>
                </div>
                <div class="contract-field">
                    <strong>Date of Agreement:</strong>
                    <?php echo $row['date_of_agreement']; ?>
                </div>
                <div class="contract-field">
                    <strong>Supplier Name:</strong>
                    <?php echo $row['contact_name']; ?>
                </div>
                <div class="contract-field">
                    <strong>Life of Contract:</strong>
                    <?php echo $row['life_of_contract']; ?>
                </div>
                <div class="contract-field">
                    <strong>SDM:</strong>
                    <?php echo $row['name']; ?>
                </div>
                <div class="contract-field">
                    <strong>SDM Remarks:</strong>
                    <?php echo $row['sdm_remarks']; ?>
                </div>
                <div class="contract-field">
                    <strong>Annual Spend:</strong>
                    <?php echo $row['annual_spend']; ?>
                </div>
                <div class="contract-field">
                    <strong>Payment Type:</strong>
                    <?php echo $row['payment_name']; ?>
                </div>
                <div class="contract-field">
                    <strong>Payment Terms:</strong>
                    <?php echo $row['payment_terms']; ?>
                </div>
                <div class="contract-field">
                    <strong>Status:</strong>
                    <?php echo $row['status']; ?>
                </div>
                <div class="contract-field">
                    <strong>Expiration Date:</strong>
                    <?php echo $row['date']; ?>
                </div>

                <div class="modal fade" id="eventFormModal" tabindex="-1" role="dialog" aria-labelledby="eventFormModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" aria-label="Close" onclick="closeEventFormModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                                <h4 class="modal-title" id="eventFormModalLabel">Update Contract Status</h4>
                            </div>
                            <div class="modal-body">
                                <!-- Event Form -->
                                <form method="post" action="update_status.php" id="eventForm_<?php echo $contractNumber; ?>" a>
                                    <div class="form-group">
                                        <label for="status">Select Status:</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Complete">Complete</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Delayed">Delayed</option>
                                            <option value="Not Delivered">Not Delivered</option>
                                            <option value="Expired">Expired</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="contractId_<?php echo $contractNumber; ?>" name="contractId" value="<?php echo $contractNumber; ?>">
                                    <br>
                                    <button type="submit" class="btn btn-primary" onclick="updateContractStatus()">Update Status</button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
            }
        } else {
            echo "<div class='no-contract-message'>No contracts available in this category.</div>";
        }

            ?>

                </div>
                <div id="calendar"></div>
    </div>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            var statusColors = <?php echo json_encode($statusColors); ?>;
            var calendarInitialized = false;


            function getStatusColor(status) {
                return statusColors[status] || statusColors['default'];
            }

            function openEventForm() {
                var contractId = 'contract_no';

                // Log the contractId to the console for debugging
                console.log('Contract ID:', contractId);
                var contractId = 'contract_no';
                $('#contractId').val(contractId);
                $('#eventFormModal').modal('show');

            }


            function closeEventFormModal() {
                $('#eventFormModal').modal('hide');
            }

            function updateContractStatus() {
                var status = $('#status').val();
                var contractId = $('#contractId').val();

                $.ajax({
                    url: 'update_status.php',
                    type: 'POST',
                    data: {
                        contractId: contractId,
                        status: status,
                        remarks: remarks
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update the calendar with the new status
                            updateCalendarStatus(contractId, status);
                            // Close the modal after updating
                            $('#eventFormModal').modal('hide');
                        } else {
                            // Handle the error (you may show an alert or log it to the console)
                            console.error('Error updating status:', response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the AJAX error (you may show an alert or log it to the console)
                        console.error('AJAX Error:', error);
                    }
                });
            }

            // Function to update the calendar with the new status
            function updateCalendarStatus(contractId, status) {
                var eventClassName = getStatusColor(status);
                var calendarEvent = {
                    'title': 'Updated Status',
                    'start': moment().format('Y-MM-DD H:mm A'), // Update with the current date and time
                    'className': eventClassName
                };
                $('#calendar').fullCalendar('renderEvent', calendarEvent);
            }

            if (!calendarInitialized) {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'month, agendaWeek, agendaDay, list',
                        center: 'title',
                        right: 'prev, today, next , openEventFormButton',
                    },
                    buttonText: {
                        today: 'Today',
                        month: 'Month',
                        week: 'Week',
                        day: 'Day',
                        list: 'List',
                    },
                    events: <?php echo json_encode($events); ?>,
                    eventRender: function(event, element) {
                        element.css('background-color', getStatusColor(event.className));
                        element.attr('title', event.description);
                    },
                    dayRender: function(date, cell) {
                        var dateString = date.format('YYYY-MM-DD');
                        var createdDateEvents = $('#calendar').fullCalendar('clientEvents', function(event) {
                            return event.title === 'Created Date' && event.start.format('YYYY-MM-DD') === dateString;
                        });
                        var expirationDateEvents = $('#calendar').fullCalendar('clientEvents', function(event) {
                            return event.title === 'Expiration Date' && event.start.format('YYYY-MM-DD') === dateString;
                        });

                        if (expirationDateEvents.length > 0) {
                            cell.html("<strong>Expiration Date: </strong>" + expirationDateEvents[0].className);
                        } else if (createdDateEvents.length > 0) {
                            cell.html("<strong>Created Date: </strong>" + createdDateEvents[0].className);
                        } else {
                            cell.html("<strong>No events</strong>");
                        }

                        // Set background color based on status
                        if (expirationDateEvents.length > 0 && cell.css('background-color') !== 'red') {
                            cell.css('background-color', 'red');
                        } else if (createdDateEvents.length > 0) {
                            cell.css('background-color', statusColors[createdDateEvents[0].className]);
                        } else {
                            cell.css('background-color', statusColors['default']);
                        }
                    },
                    timeFormat: 'h:mm A',
                    customButtons: {
                        openEventFormButton: {
                            text: 'Open Event Form',
                            click: function() {
                                openEventForm();
                            }
                        }
                    },
                });

                calendarInitialized = true;
            }
        });
    </script>


</body>

</html>