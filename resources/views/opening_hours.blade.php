<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
</head>
<body>
    <main class="d-flex flex-nowrap">
        @include('navbar')

        <div class="p-3 container-fluid">
            <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center><h5 class="fw-bold">เลือกวันปิดให้บริการ</h5></center>
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
        var closedDates = {!! json_encode($closedDates) !!};
        var bookedEvents = {!! json_encode($bookedEvents) !!};  // ดึงข้อมูลที่จองไว้

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaDay'
            },
            defaultView: 'month',
            allDaySlot: false,
            selectable: true,
            selectHelper: true,
            events: bookedEvents,
            slotLabelFormat: 'H:mm',
            minTime: '11:00',
            maxTime: '20:00',
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            dayRender: function (date, cell) {
                var formattedDate = moment(date).format('YYYY-MM-DD');

                // ถ้าวันที่ถูกปิดให้บริการจะเปลี่ยนสีของเซลล์เป็นสีเทา
                if (closedDates.includes(formattedDate)) {
                    cell.css('background-color', 'lightgray');  // ทำให้วันที่ถูกปิดมีสีเทา
                }
            },

            select: function (start, end) {
                var selectedDate = moment(start).format('YYYY-MM-DD');

                // ตรวจสอบว่ามีการจองในวันที่เลือกหรือไม่
                var hasBookedEvents = bookedEvents.some(event => moment(event.start).format('YYYY-MM-DD') === selectedDate);

                if (hasBookedEvents) {
                    alert('ไม่สามารถปิดวันนี้ได้ เนื่องจากมีลูกค้าจองคิวในวันนั้นแล้ว');
                    $('#calendar').fullCalendar('unselect');
                    return;
                }

                if (closedDates.includes(selectedDate)) {
                    if (confirm('คุณต้องการเปิดให้บริการในวันนี้ใช่หรือไม่?')) {
                        $.ajax({
                            url: '{{ route("deleteClosedDate") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                closed_date: selectedDate
                            },
                            success: function (response) {
                                alert('เปิดให้บริการในวันนี้เรียบร้อยแล้ว');
                                closedDates = closedDates.filter(date => date !== selectedDate);

                                $('#calendar').fullCalendar('refetchEvents');
                                $('#calendar').fullCalendar('render');
                                location.reload();
                            }
                        });
                    }
                } else {
                    if (confirm('คุณต้องการปิดให้บริการในวันนี้ใช่หรือไม่?')) {
                        $.ajax({
                            url: '{{ route("saveClosedDate") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                closed_date: selectedDate
                            },
                            success: function (response) {
                                alert('ปิดให้บริการในวันนี้เรียบร้อยแล้ว');
                                closedDates.push(selectedDate);

                                $('#calendar').fullCalendar('refetchEvents');
                                $('#calendar').fullCalendar('render');
                                location.reload();
                            }
                        });
                    }
                }
            }
        });
    });
    </script>
</body>
</html>
