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
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
</head>
<body>

@include('header')

<div class="container mt-4">
    <main>
        <div class="container px-4 py-2" id="custom-cards">
            <h5>โปรโมชัน</h5>

            <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-2">
                @foreach($promotions as $promotion)
                <div class="col">
                    <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg card-hover"
                        style="background-image: url('{{ asset('backgroundimage/พื้นหลัง promotion10.jpg') }}'); background-size: cover; background-position: center;"
                        onclick="showPromotionDetails({{ $promotion->promotion_id }})">
                        <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                            <h3 class="pt-2 mt-5 mb-4 display-4 lh-1 fw-bold text-dark">{{ $promotion->promotion_name }}</h3>
                            <h3 class="pt-2 mt-2 mb-2 display-6 lh-1 fw-bold text-dark">ลด
                                @if($promotion->discount_type == 'percentage')
                                    {{ floor($promotion->discount_value) }}%
                                @else
                                    {{ floor($promotion->discount_value) }} บาท
                                @endif
                            </h3>
                            <h5 class="text-dark">
                                โค้ดส่วนลด : {{ $promotion->promotion_code }}
                                <i class="fas fa-copy text-dark ms-2 fa-sm" onclick="copyToClipboard('{{ $promotion->promotion_code }}')" style="cursor: pointer;" title="คัดลอกโค้ด"></i>
                            </h5>
                            <ul class="d-flex list-unstyled mt-auto">
                                <li class="d-flex align-items-center me-3 py-2">
                                    <small class="text-dark">
                                        <b>ตั้งเเต่</b> {{ \Carbon\Carbon::parse($promotion->start_time)->translatedFormat('j F ') }}
                                        <b>ถึง</b> {{ $promotion->end_time ? \Carbon\Carbon::parse($promotion->end_time)->translatedFormat('j F Y') : 'ไม่ระบุ' }}
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </main>
</div>

<!-- Popup Modal -->
<div class="modal fade" id="promotionModal" tabindex="-1" aria-labelledby="promotionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="promotionModalLabel">รายละเอียดโปรโมชัน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container mt-4" id="promotionDetails">
                <!-- Details will be loaded here -->
            </div>
        </div>
    </div>
</div>


<script>
    function showPromotionDetails(promotionId) {
        fetch('{{ url('/promotion/details') }}' + '/' + promotionId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('promotionDetails').innerHTML = data;
                new bootstrap.Modal(document.getElementById('promotionModal')).show();
            })
            .catch(error => console.error('Error fetching promotion details:', error));
    }
</script>





@include('footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



</body>
</html>
