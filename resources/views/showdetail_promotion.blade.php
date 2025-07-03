<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


</head>
<body>

<div class="container mt-4">
    <main>
        <!-- Section for Promotion Details -->
        <div class="mb-2 text-center">
            <h3 class="fw-bold">{{ $promotion->promotion_name }}</h3>
            <p class="fs-5 text-muted">
                ลด
                @if($promotion->discount_type == 'percentage')
                    {{ floor($promotion->discount_value) }}%
                @else
                    {{ floor($promotion->discount_value) }} บาท
                @endif
            </p>
            <p class="fs-6">โค้ดส่วนลด: <b>{{ $promotion->promotion_code }}</b></p>
            <p class="fs-6">
                <b>ตั้งแต่:</b> {{ \Carbon\Carbon::parse($promotion->start_time)->translatedFormat('j F') }}
                <b>ถึง:</b> {{ $promotion->end_time ? \Carbon\Carbon::parse($promotion->end_time)->translatedFormat('j F Y') : 'ไม่ระบุ' }}
            </p>

        </div>
        <p class="fs-6 text-center"> ลายเล็บที่เข้าร่วมโปรโมชัน </p>
        <!-- Section for Nail Design Details -->
        <div class="row">
            <div class="container">
                <div class="row">
                    @foreach($promotion->detailPromotions as $detail)
                        <div class="col-md-3 mb-3">
                            <div class="card shadow-sm">
                                <img src="{{ asset('naildesingimage/' . $detail->nailDesign->image) }}" width="100%" height="225" class="bd-placeholder-img card-img-top">
                                <div class="card-body">
                                    <p class="card-text">{{ $detail->nailDesign->nailname }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" id="start-camera" class="btn btn-sm btn-outline-secondary me-2" style="width: 100px; font-size: 12px;">Virtual try-on</button>
                                            <form action="{{ route('reserv') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="nail_design_id" value="{{ $detail->nailDesign->nail_design_id }}">
                                                <input type="hidden" name="nail_image" value="{{ $detail->nailDesign->image }}">
                                                <input type="hidden" name="nail_name" value="{{ $detail->nailDesign->nailname }}">
                                                <input type="hidden" name="nail_price" value="{{ $detail->nailDesign->design_price }}">
                                                <input type="hidden" name="nail_time" value="{{ $detail->nailDesign->design_time }}">
                                                <input type="hidden" name="promotion_code" value="{{ $promotion->promotion_code }}">
                                                <button type="submit" class="btn btn-sm btn-dark" style="width: 100px; font-size: 12px;">จอง</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
