<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>

    <!-- ลำดับการโหลดสคริปต์ที่ถูกต้อง -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    @include('header')

    <div class="container mt-4">
        <main>
            <h5>รายการที่ถูกใจ</h5>

            <div class="row">
                <div class="container">
                    <div class="row">
                        @foreach ($nailDesigns as $nailDesign)
                            <div class="col-md-3 mb-3">
                                <div class="card shadow-sm">
                                    <img src="{{ asset('naildesingimage/' . $nailDesign->image) }}" width="100%" height="225"
                                        class="bd-placeholder-img card-img-top">
                                    <div class="card-body">
                                        <p class="card-text">{{ $nailDesign->nailname }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <button type="button" id="start-camera"
                                                    class="btn btn-sm btn-outline-secondary me-2">Virtual
                                                    try-on</button>
                                                <form action="{{ route('reserv') }}" method="GET">
                                                    @csrf
                                                    <input type="hidden" name="nail_design_id"
                                                        value="{{ $nailDesign->nail_design_id }}">
                                                    <input type="hidden" name="nail_image"
                                                        value="{{ $nailDesign->image }}">
                                                    <input type="hidden" name="nail_name"
                                                        value="{{ $nailDesign->nailname }}">
                                                    <input type="hidden" name="nail_price"
                                                        value="{{ $nailDesign->design_price }}">
                                                    <input type="hidden" name="nail_time"
                                                        value="{{ $nailDesign->design_time }}">
                                                    <button type="submit" class="btn btn-sm btn-dark"
                                                        style="width: 120px;">จอง</button>
                                                </form>
                                            </div>
                                            <button type="button" class="like-button"
                                                data-nail-design-id="{{ $nailDesign->nail_design_id }}"
                                                style="border: none; background: none; padding: 0;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                    <path
                                                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                </svg>
                                            </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            fetch('{{ url("liked-designs") }}')
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.like-button').forEach(button => {
                        const nailDesignId = button.getAttribute('data-nail-design-id');
                        if (data.likedDesigns.includes(parseInt(nailDesignId))) {
                            const svg = button.querySelector('svg');
                            svg.classList.add('liked');
                            svg.setAttribute('fill', 'red');
                        }

                        button.addEventListener('click', () => {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');

                            fetch('{{ url("toggle-like") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        nail_design_id: nailDesignId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const svg = button.querySelector('svg');
                                        svg.classList.toggle('liked');
                                        if (svg.classList.contains('liked')) {
                                            svg.setAttribute('fill', 'red');
                                        } else {
                                            svg.setAttribute('fill', 'currentColor');
                                        }
                                    }
                                });
                        });
                    });
                });
        });
    </script>

    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
