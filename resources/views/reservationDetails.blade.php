<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
</head>
<body>

<div class="container">
        <div class="reservation-detail">
            <p><strong>ชื่อ:</strong> {{ $reservation->user->name }}</p>
            <p><strong>เบอร์โทร:</strong> {{ $reservation->user->phon }}</p>
            <p><strong>วันที่:</strong> {{ \Carbon\Carbon::parse($reservation->reservs_start)->translatedFormat('j F Y') }}</p>
            <p><strong>เวลา:</strong> {{ date('H:i', strtotime($reservation->reservs_start)) }} ถึง {{ date('H:i', strtotime($reservation->reservs_end)) }}</p>


            @if($reservation->detailTimereservs->first() && $reservation->detailTimereservs->first()->nailDesign)
                <div class="image-container">
                    <img src="{{ asset('naildesingimage/' . $reservation->detailTimereservs->first()->nailDesign->image) }}" width="100%" height="auto">
                </div>
            @else
                <p>ไม่มีลายเล็บ</p>
            @endif

            <p><strong>บริการเสริม:</strong></p>
            @if($reservation->detailTimereservs->isNotEmpty())
                <ul>
                    @foreach($reservation->detailTimereservs as $detail)
                        @if($detail->additionalServices)
                            <li>{{ $detail->additionalServices->service_name }}</li>
                        @endif
                    @endforeach
                </ul>
            @else
                <p>ไม่มีบริการเสริม</p>
            @endif
            <p><strong>โปรโมชั่น:</strong> {{ $reservation->promotion ? $reservation->promotion->promotion_name : 'ไม่ใช้โปรโมชัน' }}</p>
@if ($reservation->promotion)
    <p><strong>ส่วนลด:</strong>
        @if($reservation->promotion->discount_type == 'percentage')
            {{ number_format($reservation->promotion->discount_value) }}%
        @elseif($reservation->promotion->discount_type == 'fixed')
            {{ number_format($reservation->promotion->discount_value) }} บาท
        @else
            ไม่ระบุประเภทส่วนลด
        @endif
    </p>
@endif

{{-- เช็คราคารวมว่ามีโปรโมชันหรือไม่ --}}
@php
    $totalPrice = $reservation->promotion ? $reservation->use_promotion_price : $reservation->price;
@endphp

<p><strong>ราคารวม:</strong> {{ number_format($totalPrice) }} บาท</p>

{{-- เช็คว่าสถานะเป็น 'ชำระเงินมัดจำแล้ว' หรือ 'จองสำเร็จ' --}}
@if (in_array($reservation->statusdetail, ['ชำระเงินมัดจำแล้ว', 'จองสำเร็จ']))
    <p><strong>เงินที่ต้องชำระอีก:</strong> {{ number_format($totalPrice - 300) }} บาท</p>
@endif

<p><strong>สถานะ:</strong>
    <span class="{{
            $reservation->statusdetail == 'รอชำระเงินมัดจำ' ? 'text-warning' :
            (in_array($reservation->statusdetail, ['ชำระเงินมัดจำแล้ว', 'จองสำเร็จ']) ? 'text-success' : '')
            }}">
            {{ $reservation->statusdetail }}
    </span>
</p>
        @if($reservation->statusdetail !== 'จองสำเร็จ')

            <div class="text-end mt-4 d-flex justify-content-end gap-2">


            <form action="{{ route('reservations.cancel', $reservation->reservs_id) }}" method="POST" onsubmit="return confirm('คุณต้องการยกเลิกการจองนี้หรือไม่?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">ยกเลิกการจอง</button>
            </form>
            <form action="{{ route('reservations.confirm', $reservation->reservs_id) }}" method="POST" onsubmit="return confirm('คุณต้องการยืนยันการจองนี้หรือไม่?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">ยืนยันการจอง</button>
            </form>
            </div>
        @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
