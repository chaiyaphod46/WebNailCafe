<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .custom-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 12px;
            /* ขอบโค้งมน */
        }

        .custom-card:hover {
            transform: translateY(-5px) scale(1.03);
            /* ดันขึ้น + ขยาย */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            /* เพิ่มเงา */
        }

        .custom-card:active {
            transform: scale(0.98);
            /* ลดขนาดเล็กลงเมื่อกด */
        }

        .card {
            cursor: pointer;
        }
    </style>

</head>

<body>

    <!-- jQuery และ FullCalendar JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dashboardCalendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month'
                },
                defaultView: 'month',
                events: @json($paymentEvents),
                selectable: false,
                allDaySlot: false,
                slotLabelFormat: 'H:mm',
                timeFormat: 'H:mm',
                minTime: '11:00',
                maxTime: '20:00',
                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                    'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
                ],
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.',
                    'ต.ค.', 'พ.ย.', 'ธ.ค.'
                ],
                dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                dayNamesShort: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                eventClick: function(event) {
                    if (event.details) {
                        // เช็คสีของ event เพื่อกำหนดหัวตาราง
                        let dateHeader = (event.color === 'green') ?
                            'วัน/เวลาชำระเงินมัดจำ' :
                            'วัน/เวลาคืนเงินมัดจำ';

                        let textColor = (event.color === 'green') ? 'green' : 'red';

                        let tableRows = event.details.map(detail => {
                            let statusColor = (detail.status === 'จองสำเร็จ') ? 'green' : 'red';
                            return `
                            <tr>
                                <td>${detail.reservs_id}</td>
                                <td style="color: ${statusColor}; ">${detail.status}</td>
                                <td>${detail.time}</td>
                                <td style="color: ${textColor}; ">${detail.amount}</td>
                            </tr>
                            `;
                        }).join('');

                        let modalContent = `
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th>รหัสการจอง</th>
                                    <th>สถานะ</th>
                                    <th>${dateHeader}</th>
                                    <th>จำนวนเงิน</th>
                                </tr>
                            </thead>
                            <tbody>${tableRows}</tbody>
                        </table>
                    `;

                        $('#modalBody').html(modalContent);
                        $('#detailModal').modal('show');
                    }
                }
            });
        });
    </script>

    <!-- Modal สำหรับแสดงรายละเอียด -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">รายละเอียดรายการ</h5>
                </div>
                <div class="modal-body" id="modalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <main class="d-flex flex-nowrap">
        @include('navbar')

        <div class="p-3 container-fluid">
            <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center>
                    <h5 class="fw-bold">เเดชบอร์ด</h5>
                </center>
            </div>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">


                </div>

                <!-- เเถวเเรก------------------------------------------->
                <div class="row">

                    <!-- จำนวนรายการจอง -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#reservationModal">
                        <div class="card border-left-primary shadow-lg h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            รายการจองทั้งหมด
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $totalReservations }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-fill fs-2 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal แสดงข้อมูลการจอง -->
                    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="reservationModalLabel">รายละเอียดการจองทั้งหมด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม scroll ถ้าข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อคนจอง</th>
                                                <th>เริ่มตอนไหน</th>
                                                <th>สิ้นสุดตอนไหน</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reservations as $key => $reservation)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $reservation->reservs_id }}</td>
                                                    <td>{{ $reservation->user->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($reservation->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td
                                                        class="{{ in_array($reservation->statusdetail, ['จองสำเร็จ']) ? 'text-success' : 'text-danger' }}">
                                                        {{ $reservation->statusdetail }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ------------------------------------- -->



                    <!-- รายการจองสำเร็จ -->

                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        <div class="card border-left-success shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            รายการจองสำเร็จ
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $successfulBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-check-fill fs-2" style="color:rgb(66, 151, 42);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดง popup รายละเอียดการจองสำเร็จ -->
                    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bookingModalLabel">รายละเอียดการจองสำเร็จ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม scroll ถ้าข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th> <!-- คอลัมน์ลำดับที่ -->
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อลูกค้า</th>
                                                <th>เริ่มเวลา</th>
                                                <th>สิ้นสุดเวลา</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($successfulBookingDetails as $index => $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- แสดงเลขลำดับ -->
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->user->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-success">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ----------------------------------- -->



                </div>

                <!-- ------------------------------------------------------------->

                <!-- เเถวสอง ------------------------------------------->

                <div class="row">

                    <!-- Card ที่สามารถกดเพื่อเปิด Popup -->
                    <div class="col-xl-3 col-md-6 mb-4" id="cancelledBookingsCard" data-bs-toggle="modal"
                        data-bs-target="#allcancelledBookingsModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            รายการถูกยกเลิก</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $cancelledBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-x-fill fs-2 " style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popup Modal -->
                    <div class="modal fade" id="allcancelledBookingsModal" tabindex="-1"
                        aria-labelledby="allcancelledBookingsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl"> <!-- เปลี่ยนจาก modal-lg เป็น modal-xl -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="allcancelledBookingsModalLabel">
                                        รายละเอียดการจองที่ถูกยกเลิก</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม scroll ถ้าข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary"> <!-- เปลี่ยนสี header ให้เหมือนกัน -->
                                            <tr>
                                                <th>#</th> <!-- เพิ่มคอลัมน์ลำดับที่ -->
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มต้น</th>
                                                <th>สิ้นสุด</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allcancelledBookingDetails as $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- ลำดับที่ -->
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->user->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                    <!-- ให้สถานะเป็นสีแดง -->
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ----------------------------->



                    <!-- จำนวนรายการจอง หมดเวลาชำระเงิน -->
                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal"
                        data-bs-target="#expiredPaymentsModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            หมดเวลาชำระเงิน</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $expiredPayments->count() }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-stopwatch-fill fs-2" style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Popup Modal -->
                    <div class="modal fade" id="expiredPaymentsModal" tabindex="-1"
                        aria-labelledby="expiredPaymentsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="expiredPaymentsModalLabel">
                                        รายละเอียดการจองที่หมดเวลาชำระเงิน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th> <!-- คอลัมน์ลำดับที่ -->
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มเวลา</th>
                                                <th>สิ้นสุดเวลา</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expiredPayments as $index => $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- แสดงลำดับที่ -->
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->user->name ?? 'ไม่ทราบ' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ---------------------------------------->


                    <!-- ยกเลิกจากเจ้าของร้าน -->

                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal"
                        data-bs-target="#cancelledBookingsModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            ยกเลิกจากเจ้าของร้าน
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $ownerCancelledBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar2-x-fill fs-2 " style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดงรายละเอียดการจองที่ถูกยกเลิก -->
                    <div class="modal fade" id="cancelledBookingsModal" tabindex="-1"
                        aria-labelledby="cancelledBookingsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelledBookingsModalLabel">
                                        รายละเอียดการจองที่ถูกยกเลิก</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม Scroll เมื่อข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th> <!-- คอลัมน์ลำดับที่ -->
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มเวลา</th>
                                                <th>สิ้นสุดเวลา</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cancelledBookingDetails as $index => $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- แสดงเลขลำดับ -->
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->user->name ?? 'ไม่ทราบ' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------- -->

                    <!-- รายการยกเลิกการจองจากลูกค้า -->

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card" data-bs-toggle="modal"
                            data-bs-target="#cancelledModal">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            ยกเลิกการจองจากลูกค้า
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $cancelledBookingsbyUser }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar2-x-fill fs-2" style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดงข้อมูลการจองที่ถูกยกเลิก -->
                    <div class="modal fade" id="cancelledModal" tabindex="-1" aria-labelledby="cancelledModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelledModalLabel">รายการจองที่ถูกยกเลิกโดยผู้ใช้
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม scroll ถ้าข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary"> <!-- เปลี่ยนสีหัวตารางให้สื่อถึงการยกเลิก -->
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มเวลา</th>
                                                <th>สิ้นสุดเวลา</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cancelledBookingbyUserDetails as $index => $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->user->name ?? 'ไม่ระบุ' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- -------------------------------------------------------------->

                <!--เเถวสาม -------------------------------------------------------------->

                <div class="row">

                    <!-- ค่ามัดจำั้งหมด -->
                    <!-- ปุ่มเปิด Modal -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#depositModal">
                        <div class="card border-left-success shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            ค่ามัดจำทั้งหมด</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format($totalDeposit) }} บาท
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-baht-sign fs-2" style="color:rgb(66, 151, 42);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดงข้อมูลค่ามัดจำ -->
                    <div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="depositModalLabel">รายละเอียดค่ามัดจำ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped">
                                        <thead class="table-success">
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อคนจอง</th>
                                                <th>วันที่ชำระเงิน</th>
                                                <th>สถานะ</th>
                                                <th>จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($depositPayments as $key => $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $payment->reservs_id }}</td>
                                                    <td>{{ $payment->customer_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td
                                                        class="{{ $payment->statusdetail === 'จองสำเร็จ' ? 'text-success' : ($payment->statusdetail === 'ยกเลิกการจองจากผู้ใช้' ? 'text-danger' : '') }}">
                                                        {{ $payment->statusdetail }}
                                                    </td>
                                                    <td class="text-success">{{ $payment->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- คืนค่ามัดจำ -->
                    <div class="col-xl-3 col-md-6 mb-4" style="cursor: pointer;" data-bs-toggle="modal"
                        data-bs-target="#refundModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            คืนค่ามัดจำ
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ number_format(abs($refundAmount)) }} บาท
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-dash fs-2" style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดงข้อมูลคืนค่ามัดจำ -->
                    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="refundModalLabel">รายละเอียดคืนค่ามัดจำ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped">
                                        <thead class="table-danger">
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>วันที่กดยกเลิก</th>
                                                <th>สถานะ</th>
                                                <th>จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($refundPayments as $key => $payment)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $payment->reservs_id }}</td>
                                                    <td>{{ $payment->customer_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->deleted_at)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $payment->statusdetail }}</td>
                                                    <td class="text-danger">{{ $payment->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Card สำหรับยกเลิกการจองที่ลูกค้าชำระเงินแล้ว -->
                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal"
                        data-bs-target="#cancelledBookingModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            เจ้าของร้านยกเลิก (ชำระเงินเเล้ว)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $cancelledPaidBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar2-x-fill fs-2 " style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal แสดงรายละเอียดการจองที่ถูกยกเลิก (ชำระเงินแล้ว) -->
                    <div class="modal fade" id="cancelledBookingModal" tabindex="-1"
                        aria-labelledby="cancelledBookingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl"> <!-- เปลี่ยนจาก modal-lg เป็น modal-xl -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelledBookingModalLabel">
                                        รายละเอียดการจองที่ถูกยกเลิก (ชำระเงินแล้ว)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <!-- เพิ่ม scroll ถ้าข้อมูลเยอะ -->
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th> <!-- เพิ่มคอลัมเลขลำดับ -->
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มการจอง</th>
                                                <th>สิ้นสุดการจอง</th>
                                                <th>วันที่ชำระเงิน</th>
                                                <th>วันที่กดยกเลิก</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cancelledPaidBookingDetails as $booking)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- ใส่ลำดับรายการ -->
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->customer_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->payment_date)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->deleted_at)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -------------------------------------------------------- -->


                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal"
                        data-bs-target="#cancelledBookingbyUserModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            ลูกค้ายกเลิก (ชำระเงินเเล้ว)
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $userCancelledPaidBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar2-x-fill fs-2 " style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="cancelledBookingbyUserModal" tabindex="-1"
                        aria-labelledby="cancelledBookingbyUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelledBookingbyUserModalLabel">
                                        รายละเอียดการจองที่ถูกยกเลิก (ชำระเงินแล้ว)</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>รหัสการจอง</th>
                                                <th>ชื่อผู้จอง</th>
                                                <th>เริ่มการจอง</th>
                                                <th>สิ้นสุดการจอง</th>
                                                <th>วันที่ชำระเงิน</th>
                                                <th>วันที่กดยกเลิก</th>
                                                <th>สถานะ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cancelledPaidBookingbyUserDetails as $index => $booking)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $booking->reservs_id }}</td>
                                                    <td>{{ $booking->customer_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_start)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->reservs_end)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->payment_date)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->deleted_at)->addYears(543)->translatedFormat('d F Y เวลา H:i') }}
                                                    </td>
                                                    <td class="text-danger">{{ $booking->statusdetail }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">ปิด</button>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- -------------------------------------------------------------->

                <!-- เเสดงปฏิทิน ----------------------------->

                <div class="row">

                    <!-- ปฏิทินรายรับจากค่ามัดจำ -->
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ปฏิทินรายรับจากค่ามัดจำ</h6>

                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div id="dashboardCalendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -------------------------------------------------------------->


                <div class="row">



                    <!--  -->
                    <div class="col-12">
                        <div class="card shadow mb-4" style="max-height: 350px; max-width: 100%; overflow: hidden;">
                            <!-- Card Header -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ลายเล็บที่ลูกค้าเลือกจองมากที่สุด</h6>
                            </div>

                            <!-- Card Body (เลื่อนซ้าย-ขวา) -->
                            <div class="card-body" style="max-width: 100%; overflow-x: auto; white-space: nowrap;">
                                <div class="d-flex" style="gap: 10px;">
                                    @foreach ($popularNailDesigns as $nail)
                                        <div class="card shadow-sm border-0"
                                            style="min-width: 200px; max-width: 220px;">
                                            <div class="card-body p-2 text-center">
                                                <!-- รูปภาพลายเล็บ -->
                                                <img src="{{ asset('naildesingimage/' . $nail->nailDesign->image) }}"
                                                    alt="ลายเล็บ" class="img-fluid rounded"
                                                    style="width: 180px; height: 180px; object-fit: cover;">

                                                <!-- จำนวนครั้งที่ถูกจอง -->
                                                <div class="bg-light mt-2 py-1 rounded">
                                                    <p class="mb-0 text-secondary">เลือกจากลูกค้า
                                                        <strong>{{ $nail->total_reservations }}</strong> ครั้ง
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>




                </div>



                <div class="row">

                    <!-- กราฟรายรับค่ามัดจำ -->
                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">รายการจองตลอดทั้งปี</h6>

                                <div class="d-flex align-items-center">
                                    <div>
                                        <select id="yearSelect" class="form-control w-auto mx-2"> <!-- เพิ่ม mx-2 -->
                                            @for ($year = date('Y'); $year >= 2020; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div>
                                        <select id="chartTypeSelect" class="form-control w-auto">
                                            <option value="deposit">กราฟค่ามัดจำ</option>
                                            <option value="booking">กราฟรายการจอง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="myAreaChart2"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <!-- เเถวสี่-------------------------------------------------------------->
                <div class="row">

                    <!-- จำนวนรายการจอง -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            ผู้ใช้ในระบบทั้งหมด</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $totalUsers }} คน
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-person-fill fs-2" style="color:rgb(24, 121, 206);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        <div class="card border-left-success shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            รายการจองสำเร็จ
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $successfulBookings }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-check-fill fs-2" style="color:rgb(66, 151, 42);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earnings (Monthly) Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card" data-bs-toggle="modal"
                            data-bs-target="#cancelledModal">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            ยกเลิกการจองจากลูกค้า
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $cancelledBookingsbyUser }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar2-x-fill fs-2" style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4" data-bs-toggle="modal"
                        data-bs-target="#expiredPaymentsModal">
                        <div class="card border-left-danger shadow h-100 py-2 custom-card">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                            หมดเวลาชำระเงิน</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $expiredPayments->count() }} รายการ
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-stopwatch-fill fs-2" style="color:rgb(236, 45, 45);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- ------------------------------------------------------------------->

                <div class="row">

                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ข้อมูลลูกค้า</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div id="customer-table" class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>#</th>
                                                <th>ชื่อ</th>
                                                <th>อีเมล</th>
                                                <th>เบอร์โทร</th>
                                                <th>จองสำเร็จ</th>
                                                <th>ยกเลิกการจอง</th>
                                                <th>หมดเวลาชำระเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $index => $customer)
                                                <tr>
                                                    <td>{{ $customers->firstItem() + $index }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->phon }}</td>
                                                    <td>{{ $customer->successful_count }}</td>
                                                    <td>{{ $customer->cancelled_count }}</td>
                                                    <td>{{ $customer->expired_payment_count }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    <nav>
                                        <ul class="pagination">
                                            {{-- ปุ่มย้อนกลับ --}}
                                            @if ($customers->onFirstPage())
                                                <li class="page-item disabled"><span class="page-link">&laquo;</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link pagination-link"
                                                        data-url="{{ $customers->previousPageUrl() }}">&laquo;</a>
                                                </li>
                                            @endif

                                            {{-- ตัวเลขหน้า --}}
                                            @foreach ($customers->getUrlRange(1, $customers->lastPage()) as $page => $url)
                                                <li
                                                    class="page-item {{ $customers->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page-link pagination-link"
                                                        data-url="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- ปุ่มถัดไป --}}
                                            @if ($customers->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link pagination-link"
                                                        data-url="{{ $customers->nextPageUrl() }}">&raquo;</a>
                                                </li>
                                            @else
                                                <li class="page-item disabled"><span class="page-link">&raquo;</span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="row">

                    <!-- จำนวนใช้โปรโมชัน-->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            จำนวนการใช้โปรโมชันทั้งหมด
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $totalPromotionUsage }} ครั้ง
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <!----------------------------------------------------->

                <div class="row">

                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">โปรโมชันที่ลูกค้าเลือกใช้มากที่สุด</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>ชื่อโปรโมชัน</th>
                                                <th>รหัสโปรโมชัน</th>
                                                <th>จำนวนครั้งที่ถูกใช้</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usedPromotions as $promotion)
                                                <tr>
                                                    <td>{{ $promotion['promotion_name'] }}</td>
                                                    <td>{{ $promotion['promotion_code'] }}</td>
                                                    <td>{{ $promotion['usage_count'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- ปุ่มเปลี่ยนหน้า --}}
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $usedPromotions->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



                <div class="row">

                    <div class="col-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">ลูกค้าที่ใช้โปรโมชัน</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>ชื่อลูกค้า</th>
                                                <th>อีเมล</th>
                                                <th>ชื่อโปรโมชัน</th>
                                                <th>รหัสโปรโมชัน</th>
                                                <th>จำนวนครั้งที่ลูกค้าใช้</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usedPromotionsbyUser as $promotion)
                                                <tr>
                                                    <td>{{ $promotion->customer_name }}</td>
                                                    <td>{{ $promotion->customer_email }}</td>
                                                    <td>{{ $promotion->promotion_name }}</td>
                                                    <td>{{ $promotion->promotion_code }}</td>
                                                    <td>{{ $promotion->usage_count }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{-- แสดง Pagination --}}
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $usedPromotionsbyUser->links() }}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>




            </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let ctx = document.getElementById("myAreaChart2").getContext("2d");
            let chartTypeSelect = document.getElementById("chartTypeSelect");
            let yearSelect = document.getElementById("yearSelect"); // ดึง <select> ปี
            let myChart;

            // สร้าง Chart เริ่มต้น
            myChart = new Chart(ctx, {
                type: 'bar', // หรือ 'line' ตามต้องการ
                data: {
                    labels: [], // ข้อมูลจะถูกเติมใน fetchDepositData()
                    datasets: []
                },
                options: {
                    // ... (options อื่นๆ ของ Chart.js)
                }
            });

            function fetchDepositData(year) { // เพิ่ม parameter year
                fetch("{{ route('dashboard.depositData') }}?year=" + year) // ส่ง year เป็น query parameter
                    .then(response => response.json())
                    .then(data => {
                        myChart.data.labels = [
                            "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                            "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ];
                        myChart.data.datasets = [{
                                label: "รายรับค่ามัดจำ",
                                data: data.deposit,
                                backgroundColor: "rgba(54, 162, 235, 0.6)", // สีน้ำเงิน
                                borderColor: "rgba(54, 162, 235, 1)",
                                borderWidth: 1
                            },
                            {
                                label: "คืนค่ามัดจำ",
                                data: data.refund,
                                backgroundColor: "rgba(242, 91, 83, 0.6)", // เปลี่ยนเป็นสีเหลือง
                                borderColor: "rgb(255, 97, 54)",
                                borderWidth: 1
                            }
                        ];
                        myChart.update();
                    });
            }

            // เรียก fetchDepositData() ครั้งแรกด้วยปีปัจจุบัน
            fetchDepositData(yearSelect.value);

            // Event Listener สำหรับการเปลี่ยนแปลงปี
            yearSelect.addEventListener('change', function() {
                fetchDepositData(this.value); // เรียก fetchDepositData() เมื่อปีมีการเปลี่ยนแปลง
            });

            function fetchBookingData() {
                fetch("{{ route('dashboard.bookingStatistics') }}")
                    .then(response => response.json())
                    .then(data => {
                        myChart.data.labels = [
                            "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
                            "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                        ];
                        myChart.data.datasets = [{
                                label: "จองสำเร็จ",
                                data: data.successful,
                                backgroundColor: "rgba(75, 192, 192, 0.6)",
                                borderColor: "rgba(75, 192, 192, 1)",
                                borderWidth: 1
                            },
                            {
                                label: "จองไม่สำเร็จ",
                                data: data.cancelled,
                                backgroundColor: "rgba(255, 99, 132, 0.6)",
                                borderColor: "rgba(255, 99, 132, 1)",
                                borderWidth: 1
                            }
                        ];
                        myChart.update();
                    });
            }

            function initializeChart() {
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [],
                        datasets: []
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: "จำนวน"
                                }
                            }
                        }
                    }
                });
                fetchDepositData(); // โหลดกราฟค่ามัดจำเป็นค่าเริ่มต้น
            }

            chartTypeSelect.addEventListener("change", function() {
                if (chartTypeSelect.value === "deposit") {
                    fetchDepositData();
                } else {
                    fetchBookingData();
                }
            });

            initializeChart();
        });
    </script>






    <script>
        $(document).ready(function() {
            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault(); // ป้องกันการโหลดหน้าใหม่
                var url = $(this).data('url');

                if (url) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function(data) {
                            $("#customer-table").html($(data).find("#customer-table")
                                .html()); // อัปเดตตาราง
                            $(".pagination").html($(data).find(".pagination")
                                .html()); // อัปเดตปุ่ม
                        },
                        error: function() {
                            alert("เกิดข้อผิดพลาดในการโหลดข้อมูล");
                        }
                    });
                }
            });
        });
    </script>



</body>

</html>
