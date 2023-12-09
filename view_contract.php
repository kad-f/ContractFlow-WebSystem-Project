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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha256-FdyAql1EZKZDSuNtIe2L0+fm1V/D7YdzrbzN+j8B8sE=" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-oLME3iI72w26o0NSNJ3qVFqbrXRI2owPhcE4rL+1/RM=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha256-T3YlP0f8w+3Q/Gbfk9Z4Yb05pFypIjBAs/Y4nbk6UU8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha256-C/dZc9l16R+H2LrwJDmr/3lc9r7l6lmpC6N1Z+8yCZ0=" crossorigin="anonymous"></script>


    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
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
                'Delivered' => 'green',
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
            'default' => 'gray', // Default color for other statuses
        ];

        $events = []; // Initialize the $events array
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $startAgreement = $row['date_of_agreement'];
                $endAgreement = $row['expiration_id'];
                $status = $row['status'];

                // Event for date_of_agreement with color based on status
                $events[] = [
                    'title' => 'Date of Agreement: ' . $row['contract_no'],
                    'start' => $startAgreement,
                    'color' => getStatusColor($status),
                ];

                // Event for expiration_date with color based on status
                $events[] = [
                    'title' => 'Expiration Date: ' . $row['expiration_id'],
                    'start' => $endAgreement,
                    'color' => getStatusColor($status),
                ];
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


        <?php
            }
        } else {
            echo "<div class='no-contract-message'>No contracts available in this category.</div>";
        }

        ?>
        <!-- Calendar container -->
        <div id='calendar'></div>
    </div>
    <script>
        var statusColors = <?php echo json_encode($statusColors); ?>;

        function getStatusColor(status) {
            return statusColors[status] || statusColors['default'];
        }

        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: <?php echo json_encode($events); ?>,
                eventRender: function(event, element) {
                    element.css('background-color', getStatusColor(event.color));
                },
            });
        });
    </script>
</body>

</html>