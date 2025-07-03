<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
</head>
<body>

@include('header')

<main>
    <div class="container-fluid px-0 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item carousel-item-next carousel-item-start">
                    <img class="w-100 img-fluid" src="imag/nailcafe5.jpg" alt="Image" style="max-height: 500px; object-fit: cover;">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 text-center">
                                    <h2 class="display-1 text-dark mb-4 animated zoomIn">Welcome to <strong class="text-white">Nailcafe</strong></h2>
                                    <a href="{{ url('/reserv') }}" class="btn btn-light py-3 px-5 animated zoomIn me-3">จองคิว</a>
                                    <a class="btn btn-dark py-3 px-5 animated zoomIn">Virtual try-on</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="album py-5 bg-body-tertiary" style="background-image: url('imag/nailcafe6.jpg'); background-size: cover; background-position: center; position: relative;">
        <div class="pricing-header p-3 pb-0 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis">Nail designs</h1>
            <!-- เพิ่มใหม่  ----------------------->
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
    <li style="margin: 0 15px;">
        <a href="{{ url()->current() }}" class="nav-link px-2 custom-nav {{ request()->has('sort') || request()->has('recommended') ? '' : 'active' }}"
           style="font-size: 20px; color:rgb(132, 131, 130); position: relative; padding-bottom: 5px;">
           ทั้งหมด
        </a>
    </li>
    <li style="margin: 0 15px;">
        <a href="{{ url()->current() }}?sort=newest" class="nav-link px-2 custom-nav {{ request('sort') == 'newest' ? 'active' : '' }}"
           style="font-size: 20px; color:rgb(132, 131, 130); position: relative; padding-bottom: 5px;">
           ลายเล็บใหม่
        </a>
    </li>
    <li style="margin: 0 15px;">
        <a href="{{ url()->current() }}?recommended=true" class="nav-link px-2 custom-nav {{ request('recommended') ? 'active' : '' }}"
           style="font-size: 20px; color: rgb(132, 131, 130); position: relative; padding-bottom: 5px;">
           ลายเล็บแนะนำ
        </a>
    </li>
</ul>
<!--  ----------------------->
        </div>
        <hr style="border: 2px solid #a5a4a4; margin-top: 10px; width: 50%; margin-left: auto; margin-right: auto;">

        <div class="container">
            <div class="row justify-content-end mb-4">
                <div class="col-md-3">
                    <!-- เพิ่มใหม่  ----------------------->
                <form id="filter-form" action="{{ url()->current() }}" method="GET" style="display: none;">
                    <!--  ----------------------->
                        <div class="form-group">
                            <label for="design_type" class="text-white"></label>
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
                                <option value="3D">ลาย3D</option>
                                <option value="แม่เหล็ก">ลายแม่เหล็ก</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ลายเล็บ -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3"style="max-height: 600px; overflow-y: auto;">
                @include('nail')
            </div>
        </div>
    </div>

</main>

@include('footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // กรองชนิดลายเล็บ
   document.getElementById('design_type').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });

</script>

<!-- เพิ่มใหม่  ----------------------->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('.custom-nav');
    const filterForm = document.getElementById('filter-form');

    // Initial state - show filter only if "ทั้งหมด" is active
    if (!window.location.search || window.location.search === "") {
        filterForm.style.display = "block";
    } else {
        filterForm.style.display = "none";
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            const url = this.getAttribute('href');

            // Update active state
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            // Show filter form only for "ทั้งหมด" tab
            if (!url.includes('?')) {
                filterForm.style.display = "block";
            } else {
                filterForm.style.display = "none";
            }

            history.pushState({}, "", url);
            loadNailDesigns(url);
        });
    });

    function loadNailDesigns(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const nailDesigns = doc.querySelector('.row-cols-1.row-cols-sm-2.row-cols-md-3.row-cols-lg-4');

            document.querySelector('.row-cols-1.row-cols-sm-2.row-cols-md-3.row-cols-lg-4').innerHTML =
                nailDesigns ? nailDesigns.innerHTML : '';
        })
        .catch(error => console.error('Error loading nail designs:', error));
    }

    // Handle design type filter changes
    document.getElementById('design_type').addEventListener('change', function(e) {
        e.preventDefault();
        const form = document.getElementById('filter-form');
        const formData = new FormData(form);
        const url = new URL(window.location);

        for (const [key, value] of formData.entries()) {
            url.searchParams.set(key, value);
        }

        history.pushState({}, "", url);
        loadNailDesigns(url.toString());
    });
});
</script>
<!-- เพิ่มใหม่  ----------------------->


</body>
</html>
