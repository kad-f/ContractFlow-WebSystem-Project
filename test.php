<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS for full calender -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
    <!-- JS for jQuery -->
   <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <!-- JS for full calender -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <!-- bootstrap css and js -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div id="calendar"></div>
</body>

<script>
    $(document).ready(function() {
        display_events();
    }); //end document.ready block

    function display_events() {
        var events = new Array();
        $.ajax({
            url: 'display_event.php',
            dataType: 'json',
            success: function(response) {

                var result = response.data;
                $.each(result, function(i, item) {
                    events.push({
                        event_id: result[i].event_id,
                        title: result[i].title,
                        start: result[i].start,
                        end: result[i].end,
                        color: result[i].color,
                        url: result[i].url
                    });
                })
                var calendar = $('#calendar').fullCalendar({
                    defaultView: 'month',
                    timeZone: 'local',
                    editable: true,
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end) {
                        alert(start);
                        alert(end);
                        $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
                        $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
                        $('#event_entry_modal').modal('show');
                    },
                    events: events,
                    eventRender: function(event, element, view) {
                        element.bind('click', function() {
                            alert(event.event_id);
                        });
                    }
                }); //end fullCalendar block	
            }, //end success block
            error: function(xhr, status) {
                alert(response.msg);
            }
        }); //end ajax block	
    }

    function save_event() {
        var event_name = $("#event_name").val();
        var event_start_date = $("#event_start_date").val();
        var event_end_date = $("#event_end_date").val();
        if (event_name == "" || event_start_date == "" || event_end_date == "") {
            alert("Please enter all required details.");
            return false;
        }
        $.ajax({
            url: "save_event.php",
            type: "POST",
            dataType: 'json',
            data: {
                event_name: event_name,
                event_start_date: event_start_date,
                event_end_date: event_end_date
            },
            success: function(response) {
                $('#event_entry_modal').modal('hide');
                if (response.status == true) {
                    alert(response.msg);
                    location.reload();
                } else {
                    alert(response.msg);
                }
            },
            error: function(xhr, status) {
                console.log('ajax error = ' + xhr.statusText);
                alert(response.msg);
            }
        });
        return false;
    }
</script>

</html>