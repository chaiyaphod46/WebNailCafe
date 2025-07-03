<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe </title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>

    <nav class="navbar navbar-expand-md sticky-top border-bottom"style="background-color: rgb(248, 216, 203);" >
      <div class="container">
          <h1 >NailCafe</h1>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel">NailCafe</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <ul class="navbar-nav flex-grow-1 justify-content-center">
              <li class="nav-item"><a class="nav-link px-2 link-secondary" href="{{url('/')}}">หน้าหลัก</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="#">การจอง</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('/showtimeavailable') }}">วันเวลาว่าง</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('/showpromotion') }}">โปรโมชัน</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="#">ถูกใจ</a></li>
            </ul>
            <div class="text-center text-md-end mt-2 mt-md-0">
              <a href="{{url('/login')}}" class="btn btn-light rounded-pill px-3 me-2">เข้าสู่ระบบ</a>
              <a href="{{url('/register')}}" class="btn btn-dark rounded-pill px-3">ลงทะเบียน</a>
            </div>
          </div>
        </div>
      </div>
    </nav>

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
                                    <a href="#" class="btn btn-light py-3 px-5 animated zoomIn me-3">จองคิว</a>
                                    <a  onclick="window.location.href='http://localhost:3000/?01.png'" class="btn btn-dark py-3 px-5 animated zoomIn">Virtual try-on</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- เพิ่มใหม่  -->
    <div class="album py-5 bg-body-tertiary" style="background-image: url('imag/nailcafe6.jpg'); background-size: cover; background-position: center; position: relative;">
        <div class="pricing-header p-3 pb-0 mx-auto text-center">
            <h1 class="display-4 fw-normal text-body-emphasis">Nail designs</h1>
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
        </div>
        <hr style="border: 2px solid #a5a4a4; margin-top: 10px; width: 50%; margin-left: auto; margin-right: auto;">
        <div class="container">
            <!-- Form Section Moved Here -->
            <div class="row justify-content-end mb-4">
                <div class="col-md-3">
                <form id="filter-form" action="{{ url()->current() }}" method="GET" style="display: none;">
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
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3"style="max-height: 600px; overflow-y: auto;">
                @foreach($naildesign as $naildesigns)
                  <div class="col">
                      <div class="card shadow-sm">
                        <img src="{{ asset('naildesingimage/' . $naildesigns->image) }}" width="100%" height="225" class="bd-placeholder-img card-img-top">
                          <div class="card-body">
                              <p class="card-text">{{$naildesigns->nailname}}</p>
                              <div class="d-flex justify-content-between align-items-center">
                              <div class="btn-group">
                                    <button type="button" id="start-camera" class="btn btn-sm btn-outline-secondary me-2">Virtual try-on</button>
                                    <form action="" method="">
                                        @csrf
                                        <input type="hidden" name="nail_design_id" value="">
                                        <button type="submit" class="btn btn-sm btn-dark" style="width: 120px;">จอง</button>
                                    </form>
                              </div>
                              <div class="d-flex align-items-center">
                                    <button type="button" class="like-button" data-nail-design-id="{{ $naildesigns->nail_design_id }}" style="border: none; background: none; padding: 0; display: flex; align-items: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                        </svg>
                                    </button>
                                    <span class="like-count ms-1" style="font-size: 12px;">{{ $naildesigns->likes_count }}</span>
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

@include('footer')



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
    // กรองชนิดลายเล็บ
    document.getElementById('design_type').addEventListener('change', function() {
        document.getElementById('filter-form').submit();
    });
</script>

<!-- เพิ่มใหม่  -->
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
</body>
</html>
