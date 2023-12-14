    <?php
    // Include necessary files and check session
    include('./database/config.php');
    include('update_notifications.php');

    if (isset($_SESSION['logged']) != "true") {
        header("Location: login.php");
        die();
    }

    $roleID = $_SESSION['role_id'];
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ContractFlow</title>

        <script src="node_modules/jquery/dist/jquery.min.js"></script>
        <!-- CSS for full calender -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
        <!-- JS for jQuery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
     
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


        <!-- bootstrap css and js -->

        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                margin: 20px;
                background-color: #f5f5f5;
                text-decoration: none;
            }

            .contract-card {
                max-width: 100%;
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



            .modal-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .modal {
                display: none;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;

            }

            .modal-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .calendar {
                flex: 0 0 48%;
                border: 1px solid #ddd;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                padding: 20px;
                margin-bottom: 20px;
            }
        </style>
        <title>View Contract</title>
    </head>

    <body>

        <div class="page-wrap">
            <div class="contract-card">
                <?php
                $role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : null;
                $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

                // Check user's role and permissions

                if ($role_id == 1 || $role_id == 3) {
                    // Admin can see all contracts
                    $sql = "SELECT contract.*, 
                    expiration.date as expiration_date, 
                    vendor.contact_name, 
                    notice_period.date as notice_start_date,
                    termination_rights.termination_date,
                    renewal_provision.renewal_date,
                    payment_type.payment_date
                        FROM contract
                        LEFT JOIN expiration ON contract.expiration_id = expiration.expiration_id
                        LEFT JOIN vendor ON contract.vendor_id = vendor.vendor_id
                        LEFT JOIN notice_period ON contract.contract_no = notice_period.contract_no
                        LEFT JOIN termination_rights ON contract.contract_no = termination_rights.contract_no
                        LEFT JOIN renewal_provision ON contract.contract_no = renewal_provision.contract_no
                        LEFT JOIN payment_type ON contract.contract_no = payment_type.contract_no";
                } else if ($role_id == 2) {
                    // Client can see only their contracts
                    $vendor_id = $_SESSION['id'];
                    $sql = "SELECT contract.*, 
               expiration.date as expiration_date, 
               vendor.contact_name,  
               notice_period.date as notice_start_date,
               termination_rights.termination_date,
               renewal_provision.renewal_date,
               payment_type.payment_date
                FROM contract
                LEFT JOIN expiration ON contract.expiration_id = expiration.expiration_id   
                LEFT JOIN vendor ON contract.vendor_id = vendor.vendor_id
                LEFT JOIN notice_period ON contract.contract_no = notice_period.contract_no
                LEFT JOIN termination_rights ON contract.contract_no = termination_rights.contract_no
                LEFT JOIN renewal_provision ON contract.contract_no = renewal_provision.contract_no
                LEFT JOIN payment_type ON contract.contract_no = payment_type.contract_no
                WHERE contract.vendor_id = '$vendor_id'";
                }



                $result = $conn->query($sql);

                if ($result === false) {
                    die("Error in SQL query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<script>display_events('" . $row['contract_no'] . "', '" . $row['expiration_date'] . "', '" . $row['date_of_agreement'] . "', '" . $row['notice_start_date'] . "', '" . $row['termination_date'] . "' , '" . $row['renewal_date'] . "' , '" . $row['payment_date'] . "');</script>";

                ?>
                        <div class="contract-field">
                            <p style="font-size: 30px;">Contract Name:
                                <span style="font-size: 20px;"><i> <?php echo $row['contract_name']; ?></i></span>
                            </p>

                            <button class="btn btn-primary w-100" data-toggle="modal" data-target="#contractDetailsModal_<?php echo $row['contract_no']; ?>">
                                View
                            </button>

                        </div>
                        <!-- Contract Details Modal -->
                        <div class="modal fade" id="contractDetailsModal_<?php echo $row['contract_no']; ?>" tabindex="-1" role="dialog" aria-labelledby="contractDetailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-dark" style="background-color: yellow;">
                                        <h5 class="modal-title" id="contractDetailsModalLabel">Contract Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <strong>Contract No:</strong> <?php echo $row['contract_no']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Contract Name:</strong> <?php echo $row['contract_name']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Description:</strong> <?php echo $row['description']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Date of Agreement:</strong> <?php echo $row['date_of_agreement']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Supplier Name:</strong> <?php echo $row['supplier_name']; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <strong>Life of Contract:</strong> <?php echo $row['life_of_contract']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Client Name:</strong> <?php echo $row['contact_name']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Annual Spend:</strong> <?php echo $row['annual_spend']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Payment Type:</strong> <?php echo $row['payment_type']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Payment Terms:</strong> <?php echo $row['payment_terms']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Status:</strong> <?php echo $row['status']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Expiration Date:</strong> <?php echo $row['expiration_date']; ?>
                                                </div>

                                                <div class="form-group">
                                                    <strong>Created At:</strong> <?php echo $row['created_at']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Termination Date:</strong> <?php echo $row['termination_date']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Renewal Date:</strong> <?php echo $row['renewal_date']; ?>
                                                </div>
                                                <div class="form-group">
                                                    <strong>Payment Date:</strong> <?php echo $row['payment_date']; ?>
                                                </div>

                                            </div>

                                        </div>
                                        <div id="calendar_<?php echo $row['contract_no']; ?>" class="calendar-container" data-contract_no="<?php echo $row['contract_no']; ?>">
                                            <div class="calendar"></div>
                                        </div>
                                    <button type="button" class="btn text-dark" style="background-color: yellow;" onclick="openEventCalendar(
                                        '<?php echo $row['contract_no']; ?>', 
                                        '<?php echo $row['date_of_agreement']; ?>', 
                                        '<?php echo $row['expiration_date']; ?>', 
                                        '<?php echo $row['notice_start_date']; ?>', 
                                        '<?php echo $row['termination_date']; ?>', 
                                        '<?php echo $row['renewal_date']; ?>', 
                                        '<?php echo $row['payment_date']; ?>'
                                    )">View Progress</button>


                                        <!-- Start popup dialog box -->
                                        <div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: yellow;">
                                                        <h5 class="modal-title" id="modalLabel">Update Progress</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="img-container">
                                                            <form id="event_form_<?php echo $row['contract_no']; ?>" method="post" action="save_event.php">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="event_name">Event Name:</label>
                                                                            <select class="form-control" name="event_name" id="event_name">
                                                                                <option value="on-time">On Time</option>
                                                                                <option value="missed">Missed</option>
                                                                                <option value="delayed">Delayed</option>
                                                                            </select>
                                                                            <input type="hidden" name="contract_no" id="contract_no" value="<?php echo $row['contract_no']; ?>">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="event_start_date">Date start</label>
                                                                            <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="event_end_date">Date end</label>
                                                                            <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn text-dark" style="background-color: yellow;">Save Event</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn text-dark" style="background-color: yellow;" data-toggle="modal" data-target="#event_entry_modal">Add Event</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                    }
                }
                ?>
                <script>
                    function save_event() {
                        var contract_no = $("#contract_no").val();
                        document.getElementById('event_form_' + contract_no).submit();
                    }
                </script>
            </div>

        </div>

    </body>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>


    <script>
        $contractNo = $_GET['contract_no'];
        $(document).ready(function() {
            $('.calendar-container').each(function() {
                var contractNo = $(this).data('contract_no');
                display_events(contractNo);
            });
        });

        function getEventColor(eventName) {
            return {
                'on-time': 'yellowgreen',
                'missed': 'darkred',
                'delayed': 'orange'
            } [eventName] || 'blue';
        }

        function display_events(contractNo, dateOfAgreement, expirationDate, noticeStartDate, terminationDate, renewalDate, paymentDate) {
            var calendarId = '#calendar_' + contractNo;
            $(calendarId + ' .calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                defaultDate: new Date(),
                height: 'auto',
                contentHeight: '300px',
                eventLimit: true,
                eventLimitText: 'more',
                eventLimitClick: 'popover',
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: 'display_event.php',
                        type: 'GET',
                        data: {
                            contract_no: contractNo
                        },
                        success: function(events) {
                            var parsedEvents = JSON.parse(events);
                            var formattedEvents = [];

                            parsedEvents.forEach(function(event) {
                                // Customize how events are rendered
                                var formattedEvent = {
                                    title: event.title,
                                    start: event.start,
                                    end: event.end,
                                    color: getEventColor(event.event_name),
                                };

                                formattedEvents.push(formattedEvent);
                            });

                            // Add an event for the expiration date
                            formattedEvents.push({
                                title: 'Contract Expiration',
                                start: expirationDate,
                                color: 'red'
                            });
                            // Add an event for the date_of_agreement
                            formattedEvents.push({
                                title: 'Date of Agreement',
                                start: dateOfAgreement,
                                color: 'green'
                            });

                            // Add an event for the notice_date
                            formattedEvents.push({
                                title: 'Notice For Contract',
                                start: noticeStartDate,
                                color: 'yellow'
                            });

                            formattedEvents.push({
                                title: 'Contract Renewal',
                                start: renewalDate,
                                color: 'purple'
                            });

                            formattedEvents.push({
                                title: 'Contract Termination',
                                start: terminationDate,
                                color: 'red'
                            });

                            formattedEvents.push({
                                title: 'Contract Payment Due Date',
                                start: paymentDate,
                                color: 'skyblue'
                            });

                            callback(formattedEvents);
                        },
                        error: function(error) {
                            console.error('Error fetching events:', error);
                        }
                    });
                },

                dayRender: function(date, cell) {
                    var formattedDate = moment(date).format('YYYY-MM-DD');
                }
            });
        }





        function openEventEntryModal() {
            $('#event_entry_modal').modal('show');
        }

        function openEventCalendar(contractNo, dateOfAgreement, expirationDate, noticeStartDate, terminationDate, renewalDate, paymentDate) {
            var calendarId = '#calendar_' + contractNo;

            $(calendarId + ' .calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: 'display_event.php',
                        type: 'GET',
                        data: {
                            contract_no: contractNo
                        },
                        success: function(events) {
                            var parsedEvents = JSON.parse(events);

                            // Customize how events are rendered
                            var formattedEvents = parsedEvents.map(function(event) {
                                return {
                                    title: event.title,
                                    start: event.start,
                                    end: event.end,
                                    color: getEventColor(event.title),
                                };
                            });

                            // Add an event for the expiration date
                            formattedEvents.push({
                                title: 'Contract Expiration',
                                start: expirationDate,
                                color: 'red'
                            });
                            // Add an event for the date_of_agreement
                            formattedEvents.push({
                                title: 'Date of Agreement',
                                start: dateOfAgreement,
                                color: 'green'
                            });

                            // Add an event for the notice_date
                            formattedEvents.push({
                                title: 'Notice For Contract',
                                start: noticeStartDate,
                                color: 'pink'
                            });

                            formattedEvents.push({
                                title: 'Contract Renewal',
                                start: renewalDate,
                                color: 'purple'
                            });
                            formattedEvents.push({
                                title: 'Contract Termination',
                                start: terminationDate,
                                color: 'red'
                            });
                            formattedEvents.push({
                                title: 'Contract Payment Due Date',
                                start: paymentDate,
                                color: 'skyblue'
                            });

                            callback(formattedEvents);
                        },
                        error: function(error) {
                            console.error('Error fetching events:', error);
                        }
                    });
                },
                dayRender: function(date, cell) {
                    var formattedDate = moment(date).format('YYYY-MM-DD');
                    // You can customize the rendering of each day cell if needed
                },
                eventRender: function(event, element) {

                },
                defaultDate: dateOfAgreement,
            });

            $('#eventCalendarModal').modal('show');
        }


        $(document).ready(function() {
            if (typeof $.fn.fullCalendar !== 'undefined') {
                $('#calendar').fullCalendar();
            } else {
                console.error('FullCalendar not loaded.');
            }
        });
    </script>


    </html>