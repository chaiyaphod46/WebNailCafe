<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <script src={{ asset('js/jquery-3.6.4.min.js') }}></script>
    <script src={{ asset('js/moment.min.js') }}></script>
    <script src={{ asset('js/fullcalendar.min.js') }}></script>
    {{-- <link rel="stylesheet" href={{ asset('css/fullcalendar.min.css') }}> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <script type="text/javascript">
        function openSmallWindow(url) {
            // เปิดหน้าต่างใหม่ที่มีขนาด 790x600 และล็อกขนาดไม่ให้ขยายได้
            window.open(url, 'newwindow', 'width=790,height=600,resizable=no');
        }
    </script>

</head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('header')

    <div class="container mt-4">
        <main>
            <div id="calendar"></div>
            <p1>*หมายเหตุการจอง*</p1>
            <p style="margin-bottom: 10px;">1. หากลูกค้าจองคิวเข้ามาในระบบ เเละชำระเงินมัดจำกับทางร้านแล้ว
                หากลูกค้ากดยกเลิกการจองทางร้านจะไม่คืนเงินมัดจำทุกกรณี</p>
            <p style="margin-bottom: 10px;">2. หากมีเหตุจำเป็นของทางร้าน
                เมื่อลูกค้าจองคิวเข้ามาเเละชำระเงินมัดจำกับทางร้านเเล้ว ทางร้านได้ทำการยกเลิกคิวของลูกค้า
                ลูกค้าสามารถติดต่อไปที่ Line: @nailcafe.kkc ส่งหลักฐานการโอนเงิน เพื่อทางร้านจะคืนเงินมัดจำให้ลูกค้า</p>
            <script src={{ asset('js/jquery-3.6.4.min.js') }}></script>
            <script src={{ asset('js/moment.min.js') }}></script>
            <script src={{ asset('js/fullcalendar.min.js') }}></script>


            <script>
                function formatThaiDate(date) {
                    var monthsThai = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม',
                        'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                    ];
                    var day = date.date();
                    var month = monthsThai[date.month()];
                    var year = date.year() + 543;

                    return `วันที่ ${day} ${month} ${year}`;
                }

                $(document).ready(function() {
                    $.ajax({
                        url: '{{ url('get-closed-dates') }}',
                        // url: '/get-closed-dates',
                        type: 'GET',
                        success: function(response) {
                            var closedDates = response.closedDates.map(date => moment.utc(date, 'YYYY-MM-DD'));
                            var now = moment().add(7, 'hours');

                            $('#calendar').fullCalendar({
                                header: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'agendaWeek'
                                },
                                titleFormat: 'D MMMM YYYY',
                                defaultView: 'agendaWeek',
                                allDaySlot: false,
                                events: {!! json_encode($bookedEvents) !!},
                                selectable: true,
                                minTime: '11:00',
                                maxTime: '20:00',
                                slotLabelFormat: 'H:mm',
                                timeFormat: 'H:mm',
                                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม',
                                    'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม',
                                    'พฤศจิกายน', 'ธันวาคม'
                                ],
                                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.',
                                    'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
                                ],
                                dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์',
                                    'เสาร์'
                                ],
                                dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],

                                select: function(start, end, jsEvent, view) {
                                    var now = moment().add(7, 'hours');
                                    if (start.isBefore(now)) {
                                        alert('ไม่สามารถจองช่วงเวลาที่ผ่านไปแล้ว');
                                        return;
                                    }

                                    var maxTime = moment(start).hours(20).minutes(0);

                                    if (end.isAfter(maxTime)) {
                                        alert(
                                            'เวลาสิ้นสุดต้องไม่เกินเวลา 20:00 กรุณาเลือกเวลาใหม่'
                                        );
                                        return;
                                    }

                                    var isClosed = closedDates.some(closedDate => moment.utc(
                                        closedDate).isSame(moment.utc(start), 'day'));
                                    if (isClosed) {
                                        alert('วันที่นี้ปิดให้บริการ');
                                        return;
                                    }


                                    var isOverlapping = function(start, end) {
                                        var events = {!! json_encode($bookedEvents) !!};
                                        for (var i = 0; i < events.length; i++) {
                                            var eventStart = moment(events[i].start);
                                            var eventEnd = moment(events[i].end);
                                            if (start.isBefore(eventEnd) && end.isAfter(
                                                    eventStart)) {
                                                return true;
                                            }
                                        }
                                        return false;
                                    };
                                    $.ajax({
                                        url: '{{ url('check-pending-deposit') }}',
                                        // url: '/check-pending-deposit', // เส้นทางสำหรับเช็คสถานะ
                                        type: 'GET',
                                        data: {
                                            user_id: '{{ Auth::user()->id }}'
                                        },
                                        success: function(response) {
                                            if (response.pending) {
                                                alert(
                                                    'คุณมีรายการที่ค้างชำระเงินมัดจำ กรุณาชำระเงินก่อนทำการจองใหม่'
                                                );
                                                return; // หยุดการเลือกเวลา
                                            }

                                            // ดึงค่า nail_design_id จาก URL
                                            const urlParams = new URLSearchParams(window
                                                .location.search);
                                            const nailDesignId = urlParams.get(
                                                'nail_design_id');
                                            const nailImage = urlParams.get(
                                                'nail_image');
                                            const nailName = urlParams.get('nail_name');
                                            const nailPrice = urlParams.get(
                                                'nail_price');
                                            const nailTime = urlParams.get('nail_time');
                                            // const promotionCode = urlParams.get(
                                            //     'promotion_code');

                                            if (nailDesignId) {
                                                // ถ้ามีค่า nail_design_id ให้ข้าม bookingModal และไป servicesModal ทันที
                                                $('#selectedNailImage').attr('src',
                                                    `naildesingimage/${nailImage}`);
                                                $('#selectedNailDesignId').val(
                                                    nailDesignId);
                                                $('.nail-design[data-id="' +
                                                    nailDesignId + '"]').addClass(
                                                    'selected');

                                                $('#selectedNailTime').val(nailTime);
                                                $('#selectedNailPrice').val(nailPrice);
                                                $('#selectedNailName').text(nailName);
                                                $('#selectedNailPrice').text(nailPrice);



                                                $('#selectedNailTime').text(nailTime);
                                                $('#selectedTime').text(formatThaiDate(
                                                        start) + ' เริ่มเวลา ' +
                                                    start.format('HH:mm'));
                                                $('#inputdate').val(start.format(
                                                    'YYYY-MM-DD HH:mm'));

                                                var startTime = moment($('#inputdate')
                                                    .val());
                                                $('#inputtime').val(moment(startTime)
                                                    .add(
                                                        parseInt(nailTime), 'hours')
                                                );
                                                var endTime = moment($('#inputtime')
                                                    .val());

                                                // endTime = moment(startTime).add(
                                                //     parseInt(nailTime), 'hours');


                                                $('#endTimeDisplayServices').text(
                                                    'เริ่มเวลา: ' + start.format(
                                                        'HH:mm') +
                                                    '  สิ้นสุดเวลา: ' + endTime
                                                    .format('HH:mm'));
                                                console.log("Input Date:", $(
                                                    '#inputdate').val());
                                                console.log("Input Time:", $(
                                                    '#inputtime').val());
                                                // console.log("Input selectedNailPrice:", $(
                                                // '#selectedNailPrice').val());


                                                $('#servicesModal').modal('show');
                                            } else {
                                                // ถ้าไม่มีค่ามา ให้แสดง bookingModal ตามปกติ
                                                $('#bookingModal').modal('show');
                                                $('#selectedTime').text(formatThaiDate(
                                                        start) + ' เริ่มเวลา ' +
                                                    start.format('HH:mm'));
                                                $('#inputdate').val(start.format(
                                                    'YYYY-MM-DD HH:mm'));

                                            }


                                            // เมื่อกดถัดไป
                                            $('.nail-design').click(function() {
                                                var selectedNailDesign = $(this)
                                                    .data(
                                                        'id'
                                                    ); // ดึง ID ลายเล็บที่เลือก
                                                var selectedNailImage = $(this)
                                                    .attr(
                                                        'src'
                                                    ); // ดึง URL ของรูปภาพ
                                                var selectedNailTime = $(this)
                                                    .data(
                                                        'design-time'
                                                    ); // ดึงเวลาที่ใช้ทำลายเล็บ
                                                var selectedNailPrice = $(this)
                                                    .data(
                                                        'price'
                                                    ); // ดึงราคาของลายเล็บ

                                                var selectedNailName = $(this)
                                                    .attr('alt');

                                                var start = moment($(
                                                    '#inputdate').val());
                                                var end = moment($('#inputtime')
                                                    .val());

                                                if (!selectedNailDesign) {
                                                    alert('กรุณาเลือกลายเล็บ');
                                                    return;
                                                }
                                                // ตรวจสอบเวลาซ้อนทับ
                                                if (isOverlapping(start, end)) {
                                                    alert(
                                                        'ช่วงเวลานี้มีการจองแล้ว กรุณาเลือกเวลาอื่น'
                                                    );
                                                    return;
                                                }
                                                $('#selectedNailImage').attr(
                                                    'src', selectedNailImage
                                                );
                                                // เก็บค่าลายเล็บที่เลือกในตัวแปร hidden
                                                $('#selectedNailDesignId').val(
                                                    selectedNailDesign);
                                                $('#selectedNailTime').val(
                                                    selectedNailTime);
                                                $('#selectedNailPrice').val(
                                                    selectedNailPrice);

                                                $('#selectedNailName').text(
                                                    selectedNailName);
                                                $('#selectedNailPrice').text(
                                                    selectedNailPrice);
                                                $('#selectedNailTime').text(
                                                    selectedNailTime);

                                                $('#bookingModal').modal(
                                                    'hide');
                                                $('#servicesModal').modal(
                                                    'show');


                                            });

                                            $('#backToDesigns').click(function() {
                                                $('#servicesModal').modal(
                                                    'hide');
                                                $('#bookingModal').modal(
                                                    'show');



                                                // ล้างค่า URL โดยไม่ต้องรีโหลดหน้า
                                                window.history.pushState({},
                                                    document.title, window
                                                    .location.pathname);
                                                $('#promotionCode').val('')
                                                    .prop('readonly',
                                                        false
                                                    ); // รีเซทค่าในช่องโปรโมชั่น
                                            });

                                            // ปุ่มไปยืนยันการจอง
                                            $('#nextToConfirmation').click(function() {

                                                var selectedNailImage = $(
                                                        '.nail-design.selected')
                                                    .attr('src');
                                                var start = moment($(
                                                        '#inputdate')
                                                    .val()
                                                ); // วันที่เริ่มต้นการจอง
                                                var endTime = moment($(
                                                        '#inputtime')
                                                    .val()
                                                ); // เวลาสิ้นสุดามทที่คำนวณแล้ว

                                                // ตรวจสอบเวลาซ้อนทับสำหรับบริการเสริม
                                                var totalServiceTime = 0;
                                                $('input[name="service[]"]:checked')
                                                    .each(function() {
                                                        totalServiceTime +=
                                                            parseInt($(this)
                                                                .data(
                                                                    'service-time'
                                                                )
                                                            ); // รวมเวลาบริการเสริม
                                                    });

                                                var endWithServices =
                                                    totalServiceTime > 0 ?
                                                    moment(endTime).add(
                                                        totalServiceTime,
                                                        'minutes') : endTime;

                                                console.log("Final End Time:",
                                                    endWithServices.format(
                                                        'YYYY-MM-DD HH:mm:ss'
                                                    ));

                                                // ตรวจสอบเวลาซ้อนทับของบริการเสริม
                                                if (isOverlapping(start,
                                                        endWithServices)) {
                                                    alert(
                                                        'ช่วงเวลานี้มีการจองแล้ว กรุณาเลือกเวลาอื่น'
                                                    );
                                                    return; // ไม่ให้ไปถัดไป
                                                }
                                                // แสดงข้อมูลผู้ใช้
                                                $('#userName').text(
                                                    '{{ Auth::user()->name }}'
                                                ); // ดึงชื่อผู้ใช้
                                                $('#userPhone').text(
                                                    '{{ Auth::user()->phon }}'
                                                ); // ดึงเบอร์โทรของผู้ใช้

                                                // แสดงลายเล็บและเวลา
                                                $('#nailDesignImage').attr(
                                                    'src', selectedNailImage
                                                );
                                                $('#bookingDate').text(
                                                    formatThaiDate(start)
                                                ); // แสดงวันที่จองเป็นภาษาไทย
                                                $('#bookingStartTime').text(
                                                    start.format('HH:mm')
                                                ); // เวลาเริ่มจอง
                                                $('#bookingEndTime').text(
                                                    endTime.format('HH:mm')
                                                ); // เวลาสิ้นสุดจอง

                                                // แสดงบริการเสริมที่เลือก
                                                var selectedServicesNames = [];
                                                $('input[name="service[]"]:checked')
                                                    .each(function() {
                                                        selectedServicesNames
                                                            .push($(this)
                                                                .parent()
                                                                .find(
                                                                    'strong'
                                                                ).text()
                                                                .trim());
                                                    });
                                                $('#selectedServices').text(
                                                    selectedServicesNames
                                                    .join(', ')
                                                ); // แสดงชื่อบริการเสริมที่เลือก

                                                $('#servicesModal').modal(
                                                    'hide');
                                                $('#confirmationModal').modal(
                                                    'show');
                                            });

                                            $('#backToServices').click(function() {
                                                $('#confirmationModal').modal(
                                                    'hide');
                                                $('#servicesModal').modal(
                                                    'show');
                                            });

                                            $('#confirmBookingButton').off().click(
                                                function() {
                                                    var selectedNailDesign = $(
                                                            '.nail-design.selected')
                                                        .data('id');

                                                    var selectedServices = [];
                                                    $('input[name="service[]"]:checked')
                                                        .each(function() {
                                                            selectedServices
                                                                .push($(this)
                                                                    .data(
                                                                        'service-id'
                                                                    ));
                                                        });

                                                    var start = moment($(
                                                        '#inputdate').val());
                                                    var endTime = moment($(
                                                        '#inputtime').val());
                                                    // ดึง promotion_code จาก input
                                                    var promotionCode = $(
                                                        '#promotionCode').val();

                                                    var eventData = {
                                                        date: start.format(
                                                            'YYYY-MM-DD HH:mm:ss'
                                                        ),
                                                        time: endTime.format(
                                                            'YYYY-MM-DD HH:mm:ss'
                                                        ),
                                                        nail: selectedNailDesign,
                                                        additional_services: selectedServices,
                                                        promotion_code: promotionCode,
                                                        _token: $(
                                                            'meta[name="csrf-token"]'
                                                        ).attr(
                                                            'content')
                                                    };

                                                    $.ajax({
                                                        url: '{{ url('create-reservation') }}',
                                                        // url: '/create-reservation',
                                                        type: 'POST',
                                                        data: eventData,
                                                        success: function(
                                                            response) {
                                                            alert(
                                                                'เลือกวันเเละเวลาการจองเเล้ว กรุณาชำระเงินมัดจำเพื่อยืนยันการจอง'
                                                            );
                                                            $('#confirmationModal')
                                                                .modal(
                                                                    'hide'
                                                                );
                                                            $('#bookingModal')
                                                                .modal(
                                                                    'hide'
                                                                );

                                                            $('#paymentModal')
                                                                .modal(
                                                                    'show'
                                                                );
                                                            $('#reservs_id')
                                                                .val(
                                                                    response
                                                                    .reservs_id
                                                                );

                                                            resetUrl();

                                                        },
                                                        error: function(
                                                            xhr) {
                                                            alert('เกิดข้อผิดพลาดในการจอง : ' +
                                                                xhr
                                                                .responseText
                                                            );
                                                        }
                                                    });
                                                });

                                            $('#goToPayment').click(function() {
                                                var reservs_id = $(
                                                        '#reservs_id')
                                                    .val(); // รับค่า reservs_id จาก Hidden Input

                                                if (reservs_id) {
                                                    window.location.href =
                                                        '{{ url('payment') }}?reservs_id=' +
                                                        reservs_id // ส่งค่าไปยังหน้า payment
                                                } else {
                                                    alert(
                                                        'เกิดข้อผิดพลาด ไม่พบรหัสการจอง'
                                                    );
                                                }
                                            });
                                            // เพิ่มตอนนับเวลาถอยหลัง
                                            $('#paymentModal').on('shown.bs.modal',
                                                function() {
                                                    let reservs_id = $(
                                                        '#reservs_id').val();

                                                    if (reservs_id) {
                                                        axios.get(
                                                                '{{ url('get-expiration') }}/' +
                                                                reservs_id
                                                            )
                                                            .then(response => {
                                                                let expiration =
                                                                    response
                                                                    .data
                                                                    .expiration;

                                                                // เริ่มนับถอยหลังใหม่
                                                                startCountdown(
                                                                    reservs_id,
                                                                    expiration
                                                                );
                                                            })
                                                            .catch(error => {
                                                                console.error(
                                                                    "เกิดข้อผิดพลาดในการดึงเวลา:",
                                                                    error);
                                                            });
                                                    }
                                                });

                                            $('#paymentModal').on('hidden.bs.modal',
                                                function() {
                                                    $('#countdownTimer').text('');
                                                    location
                                                        .reload(); // รีโหลดหน้าหลังจากปิด Modal
                                                });
                                        },
                                        error: function(xhr) {
                                            alert(
                                                'เกิดข้อผิดพลาดในการตรวจสอบสถานะการชำระเงิน'
                                            );
                                        }
                                    });




                                },
                                dayRender: function(date, cell) {
                                    var isClosed = closedDates.some(closedDate => moment.utc(
                                        closedDate).isSame(moment.utc(date), 'day'));
                                    var isPast = date.isBefore(now, 'day');

                                    if (isClosed) {
                                        cell.css('background-color', 'rgb(253, 83, 83)');
                                    } else if (isPast) {
                                        cell.addClass('past-slot');
                                        cell.css('background-color', 'lightgray');
                                    }
                                },
                                viewRender: function(view, element) {

                                    var viewStart = view.start;
                                    var viewEnd = view.end;

                                    element.find('.fc-day, .fc-time-grid .fc-slot').each(
                                        function() {
                                            var date = $(this).data('date') || $(this).closest(
                                                '.fc-day').data('date');
                                            if (date) {
                                                var isClosed = closedDates.some(closedDate =>
                                                    moment.utc(closedDate).isSame(moment
                                                        .utc(date), 'day'));
                                                var isPast = moment(date).isBefore(now, 'day');
                                                if (isClosed) {
                                                    $(this).css('background-color',
                                                        'rgb(253, 83, 83)');
                                                    $(this).css('pointer-events', 'none');
                                                } else if (isPast) {
                                                    $(this).addClass('past-slot');
                                                    $(this).css('background-color',
                                                        'lightgray');
                                                }

                                            }
                                        });
                                }
                            });
                        },
                        error: function(xhr) {
                            alert('เกิดข้อผิดพลาดในการดึงวันที่ปิด: ' + xhr.responseText);
                        }
                    });
                });
            </script>

            <!-- Booking Modal (เลือกเล็บ) -->
            <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen"> <!-- เปลี่ยนเป็น fullscreen -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เลือกลายเล็บ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-body-custom">
                            <!--<p id="selectedTime" style="font-size: 1.5em; margin: 20px 0; text-align: center;"></p>-->
                            <input type="hidden" id="inputdate" name="date">
                            <input type="hidden" id="inputtime" name="endtime">
                            <center>
                                <h3>ลายเล็บทั้งหมด</h3>
                            </center>

                            {{-- แสดงลายเล็บทั้งหมด --}}
                            <div class="d-flex justify-content-end">
                                <div class="form-group" style="width: 150px;">
                                    <select id="design_type" name="design_type" class="form-select">
                                        <option value="" disabled selected>ค้นหา</option>
                                        <option value="all">ทั้งหมด</option>
                                        <option value="พื้น">ลายสีพื้น</option>
                                        <option value="กริตเตอร์">ลายกริตเตอร์</option>
                                        <option value="แมท">ลายสีแมท</option>
                                        <option value="มาร์เบิล">ลายมาร์เบิล</option>
                                        <option value="เฟรนช์">ลายเฟรนช์</option>
                                        <option value="ออมเบร">ลายออมเบร</option>
                                        <option value="เพ้นท์ลาย">เพ้นท์ลาย</option>
                                        <option value="3D">ลาย 3D</option>
                                        <option value="แม่เหล็ก">ลายแม่เหล็ก</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row nail-design-wrapper">
                                @foreach ($nailDesigns as $design)
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 p-2 nail-design-container">
                                        <div class="position-relative">
                                            <img src="naildesingimage/{{ $design->image }}"
                                                class="img-fluid nail-design" data-id="{{ $design->nail_design_id }}"
                                                data-design-time="{{ $design->design_time }}"
                                                data-design-type="{{ $design->design_type }}"
                                                data-price="{{ $design->design_price }}"
                                                alt="{{ $design->nailname }}">

                                            <!-- ปุ่ม Virtual try-on ตำแหน่งมุมขวาล่าง -->

                                            <button type="button" onclick="openSmallWindow('http://localhost:3000/')"
                                                class="btn btn-sm virtual-try-on position-absolute">
                                                Virtual try-on
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- <center><p id="endTimeDisplay" style="font-size: 1em;"></p></center> --}}


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>

                        </div>
                    </div>
                </div>
            </div>




            <!-- Additional Services Modal (เลือกบริการเสริม) -->
            <div class="modal fade" id="servicesModal" tabindex="-1" aria-labelledby="servicesModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เลือกบริการเสริม</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- ฝั่งซ้าย: แสดงลายเล็บที่เลือก -->
                                <div class="col-md-5 text-center">
                                    <img id="selectedNailImage" src="" class="img-fluid" alt="ลายเล็บที่เลือก"
                                        style="border-radius: 10px; max-width: 80%; height: auto;">
                                    <h5>
                                        <p class="mt-2"><strong id="selectedNailName"></strong></p>
                                    </h5>
                                    <p>ราคาลายเล็บ <span id="selectedNailPrice"></span> บาท</p>
                                </div>
                                <!-- ฝั่งขวา: เลือกบริการเสริม -->
                                <div class="col-md-7">
                                    <h5>บริการเสริม</h5>
                                    <div class="list-group">
                                        @foreach ($otherServices as $service)
                                            <label class="list-group-item d-flex align-items-center">
                                                <input type="checkbox" class="form-check-input me-3" name="service[]"
                                                    data-service-id="{{ $service->service_id }}"
                                                    data-service-time="{{ $service->service_time }}"
                                                    data-service-price="{{ $service->service_price }}">
                                                <div class="w-100">
                                                    <strong>{{ $service->service_name }}</strong>
                                                    <p class="mb-0">ราคา {{ $service->service_price }} บาท </p>
                                                    <p class="text-success">

                                                        @if ($service->service_time == 0.5)
                                                            + 30 นาที
                                                        @elseif($service->service_time == 1.0)
                                                            + 1 ชั่วโมง
                                                        @elseif($service->service_time == 1.5)
                                                            + 1 ชั่วโมง 30 นาที
                                                        @elseif($service->service_time == 2.0)
                                                            + 2 ชั่วโมง
                                                        @elseif($service->service_time == 2.5)
                                                            + 2 ชั่วโมง 30 นาที
                                                        @else
                                                            {{ $service->service_time * 60 }} นาที
                                                        @endif
                                                    </p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    <center>
                                        <p id="endTimeDisplayServices" class="mt-3" style="font-size: 1.2em;"></p>
                                    </center>
                                </div>
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="backToDesigns">กลับ</button>
                            <button type="button" class="btn btn-primary" id="nextToConfirmation">จอง</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmation Modal (ยืนยันการจอง) -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title w-100 ">ยืนยันการจอง</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-center">
                                <!-- Text Section -->
                                <div class="flex-fill p-3">
                                    <input type="hidden" id="reservs_id">
                                    <p class="fs-5 mb-2"><strong>ชื่อผู้ใช้:</strong> <span id="userName"></span></p>
                                    <p class="fs-5 mb-2"><strong>เบอร์โทร:</strong> <span id="userPhone"></span></p>
                                    <p class="fs-5 mb-2"><strong>วันที่จอง:</strong> <span id="bookingDate"></span>
                                    </p>
                                    <p class="fs-5 mb-2"><strong>เวลา:</strong> เริ่ม <span
                                            id="bookingStartTime"></span> ถึง <span id="bookingEndTime"></span></p>
                                    <p class="fs-5 mb-2"><strong>บริการเสริม:</strong> <span
                                            id="selectedServices"></span></p>
                                    <p class="fs-5 mb-2"><strong>ราคารวม:</strong> <span id="totalPrice"></span> บาท
                                    </p>
                                    <div class="mb-3">
                                        <label for="promotionCode"
                                            class="form-label"><strong>กรอกโค้ดโปรโมชั่น:</strong></label>
                                        @if (request()->get('promotion_code'))
                                            <input type="text" id="promotionCode"
                                                value="{{ request()->get('promotion_code') }}" class="form-control"
                                                placeholder="ใส่โค้ดที่นี่" readonly>
                                        @else
                                            <input type="text" id="promotionCode" class="form-control"
                                                placeholder="ใส่โค้ดที่นี่">
                                            <small id="promotionFeedback" class="form-text"></small>
                                        @endif
                                    </div>
                                    <p class="fs-5 mb-2"><strong>ราคารวมหลังลด:</strong> <span
                                            id="discountedPrice"></span> บาท</p>
                                </div>

                                <div class="text-center p-3">
                                    <img id="nailDesignImage" class="img-thumbnail"
                                        style="width: 100%; max-width: 400px; height: auto;" alt="ลายเล็บ">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="backToServices">กลับ</button>
                            <button type="button" class="btn btn-primary"
                                id="confirmBookingButton">ยืนยันการจอง</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Payment Modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ชำระเงินมัดจำ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>กรุณาชำระเงินมัดจำจำนวน 300 บาท</p>
                            <div id="countdownTimer" class="text fw-bold"></div>
                            <!--<img id="qrCode" src="imag\qr_test.png" alt="QR Code" class="img-fluid">-->
                            <button type="button" class="btn btn-primary" id="goToPayment">ชำระเงินมัดจำ</button>

                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>


    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            var $promotionCode = $('#promotionCode');
            var $totalPriceDisplay = $('#totalPrice');
            var $discountedPriceDisplay = $('#discountedPrice');
            var $promotionFeedback = $('#promotionFeedback');
            var $endTimeDisplay = $('#endTimeDisplay');
            var $endTimeDisplayServices = $('#endTimeDisplayServices');
            var $inputtime = $('#inputtime');

            function calculateTotalPrice() {
                var totalPrice = 0;
                var selectedNailDesign = $('.nail-design.selected');
                var selectedNailDesignPrice = parseFloat(selectedNailDesign.data('price')) || 0;
                var servicePrice = 0;

                $('input[name="service[]"]:checked').each(function() {
                    servicePrice += parseFloat($(this).data('service-price')) || 0;
                });

                var preDiscountPrice = selectedNailDesignPrice + servicePrice;
                $totalPriceDisplay.text(preDiscountPrice.toFixed(2));
                calculateDiscountedPrice(selectedNailDesignPrice, servicePrice, selectedNailDesign.data('id'));
            }

            function calculateDiscountedPrice(nailDesignPrice, servicePrice, nailDesignId) {
                var promotionCode = $promotionCode.val();
                if (promotionCode) {
                    $.ajax({
                        url: '{{ url('check-promotion') }}',
                        method: 'POST',
                        data: {
                            promotion_code: promotionCode,
                            nail_design_id: nailDesignId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.valid) {
                                var discountValue = response.discount_value;
                                var discountType = response.discount_type;
                                $promotionFeedback.text('โค้ดนี้สามารถใช้ได้').css('color', 'green');

                                var discountedNailPrice = nailDesignPrice;
                                if (discountType === 'percentage') {
                                    discountedNailPrice -= nailDesignPrice * (discountValue / 100);
                                } else if (discountType === 'fixed') {
                                    discountedNailPrice -= discountValue;
                                }

                                var finalPrice = discountedNailPrice + servicePrice;
                                $discountedPriceDisplay.text(finalPrice.toFixed(2));
                            } else {
                                $discountedPriceDisplay.text((nailDesignPrice + servicePrice).toFixed(
                                    2));
                                $promotionFeedback.text('โค้ดนี้ไม่สามารถใช้ได้').css('color', 'red');
                            }
                        },
                        error: function() {
                            $discountedPriceDisplay.text((nailDesignPrice + servicePrice).toFixed(2));
                            $promotionFeedback.text('เกิดข้อผิดพลาดในการตรวจสอบโค้ด').css('color',
                                'red');
                        }
                    });
                } else {
                    $discountedPriceDisplay.text((nailDesignPrice + servicePrice).toFixed(2));
                    $promotionFeedback.text('');
                }
            }

            function updateEndTime(start) {
                var selectedNailDesign = $('.nail-design.selected');
                var designTime = selectedNailDesign.data('design-time');
                var totalTimeHours = parseFloat(designTime);

                $('input[name="service[]"]:checked').each(function() {
                    totalTimeHours += parseFloat($(this).data('service-time'));
                });

                var endTime = start.clone().add(totalTimeHours, 'hours');
                var maxTime = moment(start).hours(20).minutes(0);

                if (endTime.isAfter(maxTime)) {
                    alert('เวลาสิ้นสุดต้องไม่เกินเวลา 20:00 กรุณาเลือกเวลาใหม่');
                    $endTimeDisplay.text('เวลาสิ้นสุดต้องไม่เกินเวลา 20:00');
                    $endTimeDisplayServices.text('เวลาสิ้นสุดต้องไม่เกินเวลา 20:00');
                    $inputtime.val('');
                    $('.nail-design').removeClass('selected');
                    $('input[name="service[]"]').prop('checked', false);
                    return;
                }

                $endTimeDisplay.text('เริ่มเวลา: ' + start.format('HH:mm') + '  สิ้นสุดเวลา: ' + endTime.format(
                    'HH:mm'));
                $endTimeDisplayServices.text('เริ่มเวลา: ' + start.format('HH:mm') + '  สิ้นสุดเวลา: ' + endTime
                    .format('HH:mm'));
                $inputtime.val(endTime.format('YYYY-MM-DD HH:mm'));
            }

            $(document).on('click', '#nextToConfirmation', calculateTotalPrice);

            $(document).on('click', '.nail-design', function() {
                if (!$(this).hasClass('selected')) {
                    $('.nail-design').removeClass('selected');
                    $(this).addClass('selected');
                }
                calculateTotalPrice();

                var start = moment($('#inputdate').val());
                if (start.isValid()) {
                    updateEndTime(start);
                }
            });

            $promotionCode.on('input', function() {
                var selectedNailDesign = $('.nail-design.selected');
                var nailDesignPrice = parseFloat(selectedNailDesign.data('price')) || 0;
                var nailDesignId = selectedNailDesign.data('id');
                var servicePrice = 0;

                $('input[name="service[]"]:checked').each(function() {
                    servicePrice += parseFloat($(this).data('service-price')) || 0;
                });

                calculateDiscountedPrice(nailDesignPrice, servicePrice, nailDesignId);
            });

            $('input[name="service[]"]').on('change', function() {
                calculateTotalPrice();
                var start = moment($('#inputdate').val());
                if (start.isValid()) {
                    updateEndTime(start);
                }
            });
        });
    </script>


    <script>
        document.getElementById('design_type').addEventListener('change', function(event) {
            event.preventDefault();
            var selectedValue = this.value;
            $('.nail-design-container').each(function() {
                var designType = $(this).find('.nail-design').data('design-type');
                if (selectedValue === 'all' || designType === selectedValue) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>


    <script>
        let countdownInterval; // เก็บตัวแปร setInterval

        // ฟังก์ชันเริ่มต้นนับถอยหลัง
        function startCountdown(reservs_id, expirationTime) {
            let countdownElement = document.getElementById('countdownTimer');

            // ถ้ามี setInterval ที่ทำงานอยู่ ให้ล้างก่อน
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }

            // เก็บค่าเวลาหมดอายุใน localStorage
            localStorage.setItem('payment_expiration', expirationTime);
            localStorage.setItem('reservs_id', reservs_id);

            countdownInterval = setInterval(() => {
                let now = new Date().getTime();
                let timeLeft = new Date(expirationTime).getTime() - now;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    cancelReservation(reservs_id);
                } else {
                    let hours = Math.floor(timeLeft / 3600000);
                    let minutes = Math.floor((timeLeft % 3600000) / 60000);
                    let seconds = Math.floor((timeLeft % 60000) / 1000);
                    countdownElement.innerText =
                        `เวลาที่เหลือในการชำระเงินมัดจำ: ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
                }
            }, 1000);
        }

        // ฟังก์ชันยกเลิกการจองเมื่อหมดเวลา
        function cancelReservation(reservs_id) {
            if (!reservs_id) {
                alert("ไม่พบรหัสการจองที่ต้องการยกเลิก");
                return;
            }

            axios.post(`{{ url('cancel-reservation') }}/${reservs_id}`)
                .then(response => {
                    alert(response.data.message); // แสดงข้อความจากเซิร์ฟเวอร์
                    localStorage.removeItem('payment_expiration');
                    localStorage.removeItem('reservs_id');
                    location.reload();
                })
                .catch(error => {
                    if (error.response) {
                        // ถ้าเซิร์ฟเวอร์ตอบกลับด้วย status ที่ไม่ใช่ 2xx (เช่น 404)
                        // alert(error.response.data.message || "เกิดข้อผิดพลาดในการยกเลิกการจอง");
                        alert("เริ่มการจอง")
                    } else {
                        console.error("ข้อผิดพลาดในการเชื่อมต่อ:", error);
                        alert("เกิดข้อผิดพลาดในการยกเลิกการจอง");
                    }
                });
        }

        // ตรวจสอบว่าเคยมีเวลาหมดอายุใน localStorage หรือไม่
        document.addEventListener("DOMContentLoaded", function() {
            let storedExpiration = localStorage.getItem('payment_expiration');
            let storedReservId = localStorage.getItem('reservs_id');

            if (storedExpiration && storedReservId) {
                startCountdown(storedReservId, storedExpiration);
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
    <script>
        // จ่ายเงิน
        window.onload = async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const success = urlParams.get('success');
            const cancel = urlParams.get('cancel');
            const reservs_id = urlParams.get('reservs_id');

            if (success) {
                try {
                    const response = await axios.get(`http://127.0.0.1:8000/order/${success}`);
                    const orderData = response.data;

                    await axios.get(`http://127.0.0.1:8000/updateorder/${orderData.order_id}`);
                    alert(orderData.fullname + " ชำระเงินมัดจำสำเร็จ");

                    // อัปเดตสถานะใน timereservs
                    await axios.get(`http://127.0.0.1:8000/success/${success}?reservs_id=${reservs_id}`);

                    // รีเซ็ตพารามิเตอร์ใน URL
                    window.history.replaceState({}, document.title, window.location.pathname);
                } catch (error) {
                    console.error('Error fetching order data:', error);
                    alert('เกิดข้อผิดพลาดในการตรวจสอบการชำระเงิน');
                }
            }

            if (cancel) {
                alert("ชำระเงินภายหลัง");
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        }
    </script>



</body>

</html>
