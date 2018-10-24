<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<style>
    .ui-timepicker-container{
        z-index:9999 !important;
    }
</style>
<div id="page-wrapper">
    <!--row-->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb page-header">
                <li><a href="<?php echo base_url('manager/dashboard'); ?>">Dashboard</a></li>
                <li><a href="#">Procurement</a></li>
                <li class="active breadcrumb-item"><i class="white-text" aria-hidden="true"></i> <?php echo ucwords($page_name); ?></li>
                <li><span class="glyphicon glyphicon-question-sign" data-toggle="modal" data-target="#helpModal"></span></li>

            </ol>
        </div>
    </div><!--end row-->
    <div class="row">
        <div class="col-lg-12">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Procurement Meeting Schedule</h4>
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="row" style="margin: 5px;">
                        <input type="text" class="form-control" id='venue' placeholder="Enter Venue e.g Room 406"/>
                    </div>
                    <div class="row" style="margin: 5px;">
                        <input type="text" class="form-control timepicker" id='startTime' placeholder="Enter Start e.g 09:00"/>
                    </div>
                    <div class="row" style="margin: 5px;">
                        <input type="text" class="form-control timepicker" id='endTime' placeholder="Enter End e.g 2:00"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id='saveSchedule' class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div><!--end page wrapper--->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script>

    $(document).ready(function () {

        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '8',
            maxTime: '03:00pm',
            defaultTime: '9',
            startTime: '08:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
        $('#saveSchedule').click(function () {

        });
        
     


        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next', //, today',
                center: 'title',
                right: 'month'//,agendaWeek,agendaDay'
            },
            events: 'load.php',
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay)
            {

                if (start.isBefore(moment().subtract(1, "days"))) {
                    $('#calendar').fullCalendar('unselect');
                    return false;
                }


                $("#myModal").modal();

                /*var title = prompt("Enter Event Title");
                 if (title)
                 {
                 var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                 var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                 $.ajax({
                 url: "insert.php",
                 type: "POST",
                 data: {title: title, start: start, end: end},
                 success: function ()
                 {
                 calendar.fullCalendar('refetchEvents');
                 alert("Added Successfully");
                 }
                 });
                 }*/
            },
            editable: true,
            eventResize: function (event)
            {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "update.php",
                    type: "POST",
                    data: {title: title, start: start, end: end, id: id},
                    success: function () {
                        calendar.fullCalendar('refetchEvents');
                        alert('Event Update');
                    }
                })
            },

            eventDrop: function (event)
            {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "update.php",
                    type: "POST",
                    data: {title: title, start: start, end: end, id: id},
                    success: function ()
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated");
                    }
                });
            },

            eventClick: function (event)
            {
                if (confirm("Are you sure you want to remove it?"))
                {
                    var id = event.id;
                    $.ajax({
                        url: "delete.php",
                        type: "POST",
                        data: {id: id},
                        success: function ()
                        {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Removed");
                        }
                    })
                }
            },

        });
    });

    /*var secondthursday='';
     var thursday = moment()
     .startOf('month')
     .day("Thursday");
     if (thursday.date() > 7) thursday.add(7,'d');
     var month = thursday.month();
     while(month === thursday.month()){
     secondthursday += thursday.get('date')+"-";
     thursday.add(7,'d');
     }*/

</script>