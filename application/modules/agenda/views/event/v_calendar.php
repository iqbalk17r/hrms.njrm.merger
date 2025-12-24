<style>
    .ml-3 {
        margin-left: 1rem;
    }
    .box .box-body .fc-header-left, .box .box-body .fc-header-center, .box .box-body .fc-header-right {
        border-style: none !important;
    }

    .box .box-body .fc-header-center .fc-header-title {
        font-size: 50px !important;
    }
    .fc-daygrid-day-top{
        font-size: 2em;
        margin-right: 2rem;
    }
    .fc-col-header-cell{
        font-size: 1.5em;
    }

    .fc-event {
        height: 30px !important;
        font-size: medium;
    }

    .fc-day-number {
        font-size: 5vh;
        margin-right: 10em;
    }

    .fc-day:hover ~ .fc-day-number {
        background: #ddd;
        border-radius: 50%;
        color: #fff;
        transition: background-color 0.2s ease;
    }

    .fc-day-header {
        height: 30px;
        text-align: center;
        font-size: medium;
    }

    .fc-title {
        font-size: .9em;
    }
    .fc .fc-day-sun{
        background-color: rgba(231, 28, 28, 0.45);
    }
    .fc .fc-col-header-cell-cushion{
        color: black !important;
    }
    .fc .fc-daygrid-day-number {
        color: black !important;
    }
    .fc-day:hover, .fc-today:hover {
        background-color: rgba(54, 241, 60, 0.58) !important;
        transition: background-color 0.2s ease;
    }

    .fc-daygrid-event.fc-event-end:hover, .fc-daygrid-event.fc-event-start:hover {
        margin-right: 2px;
        color: #000000;
    }

    .fc-day, .fc-today {
        background-color: #f1f7ff; /* Initial background color */
        transition: background-color 0.4s ease; /* Smooth transition */
    }

    #calendar:hover{
        cursor: pointer;
    }


</style>
<legend><?php echo $title; ?></legend>

<div class="row">
    <div class="col-md-12">
        <!-- <?php// if ($this->useraccess->user($menuID,'aksesinput') AND $userhr){ ?> -->
        <div class="box box-success">
            <div class="box-body">
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="<?php echo $inputUrl; ?>" type="button" class="btn btn-success create"  aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-plus"></i> Buat Agenda
                        </a>
                    </div>
                        <button id="reload-events" class="btn btn-primary pull-right" data-toggle="tooltip" title="Muat Ulang" ><i class="fa fa-refresh"></i></button>
                </div>
            </div>
        </div>
        <!-- <?php //} ?> -->
        <div class="box box-primary padding-tb-10">
            <div class="box-body calendar-container">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /. box -->
    </div>
</div>
<!-- Modal Event-->
<div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"></div>
<script>
    function loadmodal(url) {
        $('div#modal-event')
            .empty()
            .load(url, {}, function (response, status, xhr) {
                if (status === 'error') {
                    Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-sm btn-success m-1',
                            cancelButton: 'btn btn-sm btn-warning m-1',
                            denyButton: 'btn btn-sm btn-danger m-1',
                        },
                        buttonsStyling: false,
                    }).fire({
                        position: 'top',
                        icon: 'error',
                        title: 'Gagal Memuat Detail',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                } else {
                    $('div#modal-event').modal({
                        keyboard: false,
                        backdrop: 'static',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    $('div#modal-event').modal('show');
                }
            });
    }
    $(document).ready(function () {
        function init_events(ele) {
            ele.each(function () {

                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                }

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject)

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0  //  original position after the drag
                })

            })
        }
        /* initialize the calendar
     -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var calendarEl = $('#calendar')[0];

        // initialize the external events
        // -----------------------------------------------------------------

        init_events($('#external-events div.external-event'))
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        var calendar = new Calendar(calendarEl, {
            locale:'id',
            titleFormat: { // will produce something like "Tuesday, September 18, 2018"
                month: 'long',
            },
            headerToolbar: {
                left  : 'prev,next today',
                center: 'title',
                right : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            navLinks: true, // can click day/week names to navigate views
            editable: true,
            selectable: true,
            nowIndicator: true,
            dayMaxEvents: true,
            displayEventTime : false,
            themeSystem: 'standard',
            //events: '<?php //echo $loadEventUrl ?>//',
            events: '<?php echo $loadEventUrl ?>',
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    loadmodal(info.event.url)
                }
            },
            editable  : false,
            droppable : false, // this allows things to be dropped onto the calendar !!!
            drop      : function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            }
        });

        calendar.render();

        /* ADDING EVENTS */
        var currColor = '#3c8dbc' //Red by default
        //Color chooser button
        var colorChooser = $('#color-chooser-btn')
        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault()
            //Save color
            currColor = $(this).css('color')
            //Add color effect to button
            $('#add-new-event').css({'background-color': currColor, 'border-color': currColor})
        })
        $('#add-new-event').click(function (e) {
            e.preventDefault()
            //Get value and make sure it is not null
            var val = $('#new-event').val()
            if (val.length == 0) {
                return
            }

            //Create events
            var event = $('<div />')
            event.css({
                'background-color': currColor,
                'border-color': currColor,
                'color': '#fff'
            }).addClass('external-event')
            event.html(val)
            $('#external-events').prepend(event)

            //Add draggable funtionality
            init_events(event)

            //Remove event from text input
            $('#new-event').val('')
        });
        $('#reload-events').click(function() {
            calendar.refetchEvents();
        });
    });
</script>