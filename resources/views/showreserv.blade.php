<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>

<body>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('header')

    <main>
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5>การจองของฉัน</h5>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('filter') == 'history' ? 'ประวัติการจอง' : 'การจองปัจจุบัน' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item"
                                href="{{ route('showreservations', ['filter' => 'active']) }}">การจองปัจจุบัน</a></li>
                        <li><a class="dropdown-item"
                                href="{{ route('showreservations', ['filter' => 'history']) }}">ประวัติการจอง</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                @forelse($reservations as $reservation)
                    <div class="col-lg-3 col-md-6 mb-3 d-flex">
                        <div class="card shadow-sm flex-fill" style="min-height: 100%;">
                            @if ($reservation->detailTimereservs->first() && $reservation->detailTimereservs->first()->nailDesign)
                                <img src="{{ asset('naildesingimage/' . $reservation->detailTimereservs->first()->nailDesign->image) }}"
                                    width="100%" height="220" class="bd-placeholder-img card-img-top">
                            @endif
                            <div class="card-body d-flex flex-column" style="line-height: 1.2;">
                                <h5>
                                    <p class="card-text">วันที่จอง:
                                        {{ \Carbon\Carbon::parse($reservation->reservs_start)->translatedFormat('j F Y') }}
                                    </p>
                                </h5>
                                <h5>
                                    <p class="card-text">เวลาที่จอง:
                                        {{ date('H:i', strtotime($reservation->reservs_start)) }} ถึง
                                        {{ date('H:i', strtotime($reservation->reservs_end)) }}</p>
                                </h5>

                                <p class="card-text
                                {{ $reservation->statusdetail == 'รอชำระเงินมัดจำ'
                                    ? 'text-warning'
                                    : ($reservation->statusdetail == 'ชำระเงินมัดจำแล้ว' || $reservation->statusdetail == 'จองสำเร็จ'
                                        ? 'text-success'
                                        : '') }}"
                                    id="status_{{ $reservation->reservs_id }}">
                                    {{ $reservation->statusdetail }}
                                </p>

                                @if ($reservation->detailTimereservs->isNotEmpty())
                                    <p class="card-text">บริการเพิ่มเติม:</p>
                                    <ul class="card-text">
                                        @foreach ($reservation->detailTimereservs as $detail)
                                            @if ($detail->additionalServices)
                                                <li>{{ $detail->additionalServices->service_name }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                <p class="card-text mt-auto"><strong>ใช้ code:</strong>
                                    {{ $reservation->promotion ? $reservation->promotion->promotion_code : 'ไม่มี' }}
                                </p>

                                <p class="card-text mt-auto"><strong>ราคารวม:</strong>
                                    {{ number_format($reservation->promotion ? $reservation->use_promotion_price : $reservation->price) }} บาท
                                </p>

                                {{-- แสดงเฉพาะเมื่อสถานะไม่ใช่ "รอชำระเงินมัดจำ" --}}
                                @if ($reservation->statusdetail != 'รอชำระเงินมัดจำ')
                                    <p class="card-text mt-auto"><strong>ต้องชำระอีก:</strong>
                                        {{ number_format(($reservation->promotion ? $reservation->use_promotion_price : $reservation->price) - 300) }} บาท
                                    </p>
                                @endif
                                {{-- <p class="card-text mt-auto"><strong>ราคารวม:</strong>
                                    {{ number_format($reservation->price) }} บาท </p>
                                <p class="card-text mt-auto"><strong>ใช้ code:</strong>
                                    {{ $reservation->promotion ? $reservation->promotion->promotion_code : 'ไม่มี' }}
                                </p>
                                <p class="card-text mt-auto"><strong>ราคาหลังลด:</strong>
                                    {{ number_format($reservation->use_promotion_price) }} บาท </p> --}}

                                @if (request('filter') !== 'history')
                                    @if ($reservation->statusdetail == 'รอชำระเงินมัดจำ')
                                        <p class="text-warning fw-bold">กรุณาชำระเงินภายใน: <span
                                                id="countdown_{{ $reservation->reservs_id }}"></span></p>
                                        <button class="btn btn-warning w-100 mb-2"
                                            id="paymentButton_{{ $reservation->reservs_id }}"
                                            onclick="goToPayment({{ $reservation->reservs_id }})">ชำระเงิน</button>
                                    @endif

                                    <form action="{{ route('showreservations.cancel', $reservation->reservs_id) }}"
                                        method="POST" onsubmit="return confirm('คุณต้องการยกเลิกการจองใช่หรือไม่?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" id="cancelButton_{{ $reservation->reservs_id }}"
                                            class="btn btn-danger w-100">ยกเลิกการจอง</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col">
                        <p>ไม่พบการจอง</p>
                    </div>
                @endforelse
            </div>

        </div>
    </main>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script>
        // กลับไปจ่ายเงิน


        function goToPayment(reservs_id) {
            window.location.href = "{{ url('/payment') }}" + '?reservs_id=' + encodeURIComponent(reservs_id);
        }

        // function goToPayment(reservs_id) {
        // window.location.href = '/payment?reservs_id=' + reservs_id;
        // }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function startCountdown(reservs_id, expirationTime) {
                let countdownElement = document.getElementById(`countdown_${reservs_id}`);
                let paymentButton = document.getElementById(`paymentButton_${reservs_id}`);
                let cancelButton = document.getElementById(`cancelButton_${reservs_id}`);
                if (!countdownElement || !paymentButton) return;

                let interval = setInterval(() => {
                    let now = new Date().getTime();
                    let timeLeft = new Date(expirationTime).getTime() - now;

                    if (timeLeft <= 0) {
                        clearInterval(interval);
                        countdownElement.innerText = "หมดเวลาชำระเงินแล้ว";
                        paymentButton.style.display = "none"; // ซ่อนปุ่มชำระเงิน
                        cancelButton.style.display = "none";
                        cancelReservation(reservs_id)


                        return;
                    }

                    let hours = Math.floor(timeLeft / 3600000);
                    let minutes = Math.floor((timeLeft % 3600000) / 60000);
                    let seconds = Math.floor((timeLeft % 60000) / 1000);
                    countdownElement.innerText =
                        `เวลาที่เหลือในการชำระเงินมัดจำ: ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
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




            @foreach ($reservations as $reservation)
                @if ($reservation->statusdetail == 'รอชำระเงินมัดจำ')
                    startCountdown({{ $reservation->reservs_id }}, "{{ $reservation->payment_expiration }}");
                @endif
            @endforeach
        });
    </script>

</body>

</html>
