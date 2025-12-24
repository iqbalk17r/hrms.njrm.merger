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

    .fc-event {
        height: 30px !important;
        font-size: medium;
    }

    .fc-day-number {
        font-size: 20px;
        margin-right: 5px;
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

    .fc-today {
        background-color: rgba(255, 209, 113, 0.65) !important;
        font-weight: bolder;
    }

    .fc-sun {
        background-color: rgba(248, 197, 197, 0.71);
        color: #f34747;
        /*your styles goes here*/
    }

    .fc-title {
        font-size: .9em;
    }
</style>
<legend><?php echo $title; ?></legend>
<?php if (!empty($message)) { ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h3><i class="icon fa fa-warning"></i> Perhatian!</h3>
        <h4><?php echo $message ?></h4>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-body">
                <div class="btn-toolbar">
                    <div class="btn-group">
                        <?php if ($this->useraccess->user($menuID,'aksesinput') AND $userhr){ ?>
                            <a href="<?php echo $inputUrl; ?>" type="button" class="btn btn-success create"  aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-plus"></i> Buat Agenda
                            </a>
                        <?php } ?>

                    </div>
<!--                    <a href="#" class="btn btn-md btn-facebook pull-right back">Filter</a>-->
                </div>
            </div>
        </div>
        <div class="box box-primary padding-tb-10">

            <div class="box-body no-padding">
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

        init_events($('#external-events div.external-event'))
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()
        $('#calendar').fullCalendar({
            plugins: ['interaction', 'dayGrid', 'timeGrid', 'list', 'googleCalendar'],
            selectable: true,
            eventLimit: true, // for all non-TimeGrid views
            header: {
                left: 'prev today next',
                center: 'title',
                right: 'month,agendaWeek,agendaDay '
            },
            buttonText: {
                today: 'Sekarang',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                prev: '<',
                prevYear: '<<',
                next: '>',
                nextYear: '>>',
            },
            buttonIcons: {
                prev: 'left-single-arrow',
                next: 'right-double-arrow',
                prevYear: 'left-double-arrow',
                nextYear: 'right-double-arrow'
            },
            monthNames: 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'.split('_'),
            monthNamesShort: 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agt_Sep_Okt_Nov_Des'.split('_'),
            dayNames: 'Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu'.split('_'),
            dayNamesShort: 'Min_Sen_Sel_Rab_Kam_Jum_Sab'.split('_'),
            columnFormat: {
                month: 'dddd',    // Monday, Wednesday, etc
                week: 'dddd, MMM dS', // Monday 9/7
                day: 'dddd, MMM dS'  // Monday 9/7
            },
            //Random default events
            events: '<?php echo $loadEventUrl ?>',
            eventClick: function(info) {
                loadmodal(info.link)
            },
            eventRender: function(event, element){
                element.find('.fc-event-time').hide();
                element.popover({
                    html : true,
                    animation:true,
                    delay: 300,
                    content: function () {
                        var clone = '<div>' + event.title +'</div>';
                        return clone;
                    },
                    trigger: 'hover',
                    container: 'body',
                    placement: 'top'
                });

            },

            select: function(start, end, jsEvent, view) {

            },
            eventMouseover: function(calEvent, jsEvent) {
                var tooltip = ``;
                var $tooltip = $(tooltip).appendTo('body');

                $(this).mouseover(function(e) {
                    $('.fc-event').css( 'cursor', 'pointer' );
                    $(this).css('z-index', 10000);
                    $tooltip.fadeIn('500');
                    $tooltip.fadeTo('10', 1.9);
                }).mousemove(function(e) {
                    $tooltip.css('top', e.pageY + 10);
                    $tooltip.css('left', e.pageX + 20);
                });
            },
            eventMouseout: function(calEvent, jsEvent) {
                $(this).css('z-index', 8);
                $('.tooltipevent').remove();
            },
            dayClick: function (date, jsEvent, view) {
                var day = date.getDay(); // number 0-6 with Sunday as 0 and Saturday as 6
            },
            nowIndicator: true,
            now: date,
            editable: false,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject')

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject)

                // assign it the date that was reported
                copiedEventObject.start = date
                copiedEventObject.allDay = allDay
                copiedEventObject.backgroundColor = $(this).css('background-color')
                copiedEventObject.borderColor = $(this).css('border-color')

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                // $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove()
                }

            },
            defaultView: 'month',
        })

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
        })
    })
</script>