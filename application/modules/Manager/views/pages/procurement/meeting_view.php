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
                    <h4 class="modal-title">Procurement Meeting Scheduler</h4>
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="row" style="margin: 5px;">
                        <input type="text" class="form-control" id='venue' placeholder="Enter Venue e.g Room 406"/>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id='saveSchedule' class="btn btn-primary" >Schedule Meeting</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Procurement Meeting</h4>
                </div>
                <div class="modal-body" style="padding: 10px;">
                    <div class="row" style="margin: 5px;">
                        <input type="text" class="form-control venue" id='venue1' />
                    </div>                   
                </div>
                <div class="modal-footer">
                    <table>
                        <tr>
                            <td>
                                <button type="button" id='saveEdit'  class="btn btn-primary" >Save Edit</button>

                            </td>
                            <td>
                                <button type="button" id='startMeeting'  class="btn btn-success" >Start Meeting</button>

                            </td>
                            <td>
                                <button type="button" data-minute='' id='viewMinutes' style="margin-right: 10px; display:none" class="btn btn-primary" >View Minutes</button>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div><!--end page wrapper--->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script>

    $(document).ready(function () {
        starter = '', ender = '', dataid = '';

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




        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header: {
                left: 'prev,next', //, today',
                center: 'title',
                right: 'month'//,agendaWeek,agendaDay'
            },
            events: '<?php echo base_url(); ?>Manager/Procurement/loadEvents/',
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay)
            {
                starter = start;
                ender = end;

                // if (start.isBefore(moment().subtract(1, "days"))) {
                // $('#calendar').fullCalendar('unselect');
                // return false;
                // }

                $("#myModal").modal();


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
                    data: {venue: $('.venue').val()},
                    success: function ()
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated");
                    }
                });
            },

            eventClick: function (event) {

                dataid = event.id;
                $('.venue').val(event.venue);
                $.getJSON('<?php echo base_url(); ?>Manager/Procurement/lookForMeeting/' + dataid, function (resp) {
                    if (resp.count === 1) {
                        $('#saveEdit').css('display', 'none');
                        $('#startMeeting').css('display', 'none');
                        $('#viewMinutes').css('display', 'block');
                        $('.venue').prop('readonly', true);
                    } else {
                        $('#saveEdit').css('display', 'block');
                        $('#startMeeting').css('display', 'block');
                        $('#viewMinutes').css('display', 'none');
                        $('.venue').prop('readonly', false);
                    }
                    $("#exModal").modal();
                });
            }

        });

        $('#viewMinutes').click(function () {
            window.open('<?php echo base_url(); ?>manager/public/minute/' + dataid, '_blank');
        });

        $('#saveSchedule').click(function () {
            var venue = $('#venue').val();
            var start = $.fullCalendar.formatDate(starter, "Y-MM-DD 09:00:00");
            var end = $.fullCalendar.formatDate(starter, "Y-MM-DD 02:00:00");
            $.ajax({
                url: "<?php echo base_url(); ?>Manager/Procurement/saveEvent/",
                type: "POST",
                data: {title: 'Procurement Meeting', venue: venue, start: start, end: end},
                success: function ()
                {
                    calendar.fullCalendar('refetchEvents');
                    swal({
                        title: "Schedule Created",
                        text: "Procurement Planning Meeting Scheduled",
                        icon: "success",
                    });
                    $('#myModal').modal('toggle');
                }
            });
        });


        $('#saveEdit').click(function () {
            var venue = $('.venue').val();
            $.ajax({
                url: "<?php echo base_url(); ?>Manager/Procurement/updateEvent/" + dataid,
                type: "POST",
                data: {venue: venue},
                success: function ()
                {
                    calendar.fullCalendar('refetchEvents');
                    swal({
                        title: "Schedule Room Changed",
                        text: "Procurement Planning Meeting Room Changed",
                        icon: "success",
                    });
                }
            });
        });

        $('#startMeeting').click(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>Manager/Procurement/minuteAdd/" + dataid,
                type: "GET",
                success: function ()
                {
                    window.location.href = "<?php echo base_url(); ?>manager/procurement/meeting/minute/"+dataid
                }
            });
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