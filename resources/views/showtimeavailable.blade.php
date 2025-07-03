<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
</head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('header')

    <div class="container mt-4">
        @csrf

        <main>
            <div id="calendar"></div>

            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

            <script>
                $(document).ready(function () {
                    var bookedEvents = {!! json_encode($bookedEvents) !!};
                    var closedDates = {!! json_encode($closedDates) !!}.map(date => moment.utc(date, 'YYYY-MM-DD'));
                    var now = moment().add(7, 'hours');
                    $('#calendar').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek'
                        },
                        titleFormat: 'D MMMM YYYY',
                        defaultView: 'agendaWeek',
                        allDaySlot: false,
                        events: bookedEvents,
                        selectable: true,
                        minTime: '11:00',
                        maxTime: '20:00',
                        slotLabelFormat: 'H:mm',
                        timeFormat: 'H:mm',
                        monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                        monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                        dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                        dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],

                        dayRender: function (date, cell) {
                            var isClosed = closedDates.some(closedDate => moment.utc(closedDate).isSame(moment.utc(date), 'day'));
                            var isPast = date.isBefore(now, 'day');
                            if (isClosed) {
                                cell.css('background-color', 'rgb(253, 83, 83)');
                            } else if (isPast) {
                                cell.addClass('past-slot');
                                cell.css('background-color', 'lightgray');
                        }
                        },

                        viewRender: function (view, element) {
                            var viewStart = view.start;
                            var viewEnd = view.end;

                            element.find('.fc-day, .fc-time-grid .fc-slot').each(function () {
                                var date = $(this).data('date') || $(this).closest('.fc-day').data('date');
                                if (date) {
                                    var isClosed = closedDates.some(closedDate => moment.utc(closedDate).isSame(moment.utc(date), 'day'));
                                    var isPast = moment(date).isBefore(now, 'day');
                                if (isClosed) {
                                    $(this).css('background-color', 'rgb(253, 83, 83)');
                                    $(this).css('pointer-events', 'none');
                                } else if (isPast) {
                                    $(this).addClass('past-slot');
                                    $(this).css('background-color', 'lightgray');
                                }
                                }
                            });
                        }
                    });
                });
            </script>
        </main>


    </div>
    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>



</body>

</html>
