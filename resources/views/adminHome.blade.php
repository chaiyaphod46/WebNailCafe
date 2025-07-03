<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
</head>
<body>
    <main class="d-flex flex-nowrap">
        @include('navbar')

        <div class="p-3 container-fluid">
            <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center><h5 class="fw-bold">การจองของลูกค้า</h5></center>
            </div>
            <section class="w-100 p-4 d-flex justify-content-center pb-4">
                <div id="calendar"></div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <script>
        $(document).ready(function () {
            var bookedEvents = {!! json_encode($bookedEvents) !!};  // ข้อมูลการจองจาก Controller
            var closedDates = {!! json_encode($closedDates) !!}.map(date => moment.utc(date, 'YYYY-MM-DD'));
            var now = moment().add(7, 'hours');

            $('#calendar').fullCalendar({
                header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            titleFormat: 'D MMMM YYYY',
            defaultView: 'month',
            allDaySlot: false,
            selectable: true,
            events: bookedEvents,
            slotLabelFormat: 'H:mm',
            minTime: '11:00',
            maxTime: '20:00',
            slotLabelFormat: 'H:mm',
            timeFormat: 'H:mm',
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            eventClick: function (event) {
            // เมื่อคลิกที่ event เรียกใช้ฟังก์ชัน
            fetchReservationDetails(event.start);
        },
            dayRender: function (date, cell) {
                var isClosed = closedDates.some(closedDate => moment.utc(closedDate).isSame(moment.utc(date), 'day'));

                    if (isClosed) {
                        cell.css('background-color', 'rgb(253, 83, 83)');
                    }
            },
            viewRender: function (view, element) {
                element.find('.fc-day, .fc-time-grid .fc-slot').each(function () {
                    var date = $(this).data('date') || $(this).closest('.fc-day').data('date');
                    if (date) {
                        var isClosed = closedDates.some(closedDate => moment.utc(closedDate).isSame(moment.utc(date), 'day'));

                        if (isClosed) {
                            $(this).css('background-color', 'rgb(253, 83, 83)');
                            $(this).css('pointer-events', 'none');
                        }
                    }
                });
            }
        });
    });

    function fetchReservationDetails(startDate) {
        // ดึงข้อมูลการจอง
        $.ajax({
            url: "{{ url('/getReservationDetails') }}",

            method: 'GET',
            data: {
                date: startDate.format('YYYY-MM-DD H:mm:ss')  // ส่งวันที่และเวลา
            },
            success: function (response) {
                $('#reservationModal .modal-body').html(response.html);
                $('#reservationModal').modal('show');  // เปิด modal
            }
        });
    }
    </script>


<!-- Modal สำหรับแสดงรายละเอียดการจอง -->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 600px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">รายละเอียดการจอง</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
