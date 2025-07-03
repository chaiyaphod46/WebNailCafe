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
</head>

<body>

    <main class="d-flex flex-nowrap">
        @include('navbar')

        <div class="p-3 container-fluid">
            <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center>
                    <h5 class="fw-bold">เพิ่มลายเล็บ</h5>
                </center>
            </div>
            <section class="w-100 p-4 d-flex justify-content-center pb-4">
                <form class="needs-validation" action="{{ url('upload_naildesign') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="nailname" class="form-label">ลายเล็บ</label>
                            <input type="text" class="form-control" name="nailname" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="file" class="form-label">รูปลายเล็บ</label>
                            <input type="file" class="form-control" name="file">
                        </div>

                        <div class="col-sm-3">
                            <label for="design_price" class="form-label">ราคา</label>
                            <input type="number" class="form-control" name="design_price">
                        </div>

                        <div class="col-sm-3">
                            <label for="design_time" class="form-label">เวลาในการทำเล็บ (ชั่วโมง)</label>
                            <select class="form-select" name="design_time" required>
                                <option value="1">1 ชั่วโมง</option>
                                <option value="1.5">1 ชั่วโมง 30 นาที</option>
                                <option value="2">2 ชั่วโมง</option>
                                <option value="2.5">2 ชั่วโมง 30 นาที</option>
                                <option value="3">3 ชั่วโมง</option>
                                <option value="3.5">3 ชั่วโมง 30 นาที</option>
                                <option value="4">4 ชั่วโมง</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <label for="design_type" class="form-label">ประเภทลายเล็บ</label>
                            <select class="form-select" name="design_type" required>
                                <option value="พื้น">ลายสีพื้น</option>
                                <option value="กริตเตอร์">ลายกริตเตอร์</option>
                                <option value="แมท">ลายสีแมท</option>
                                <option value="มาร์เบิล">ลายสีมาร์เบิล</option>
                                <option value="เฟรนช์">ลายสีเฟรนช์</option>
                                <option value="ออมเบร">ลายสีออมเบร</option>
                                <option value="เพ้นท์ลาย">ลายสีเพ้นท์ลาย</option>
                                <option value="3D">ลาย 3D</option>
                                <option value="แม่เหล็ก">ลายสีแม่เหล็ก</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">
                    <button class="btn btn-primary btn-lg w-25 d-block mx-auto" type="submit">บันทึก</button>

                    @if (session('success'))
                        <div id="successToast"
                            class="toast align-items-center text-white bg-success border-0 position-fixed top-50 start-50 translate-middle"
                            role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                </form>
            </section>

            <div class="p-3 mb-4 bg-light rounded-3">
                <div class="container-fluid py-1">
                    <h5 class="fw-bold">Naildesign</h5>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead style="position: sticky; top: 0; background-color: #fff; z-index: 10;">
                                <tr>
                                    <th scope="col">Nail ID</th>
                                    <th scope="col">ลายเล็บ</th>
                                    <th scope="col">รูปลายเล็บ</th>
                                    <th scope="col">ราคา(บาท)</th>
                                    <th scope="col">เวลาในการทำ</th>
                                    <th scope="col">ประเภทลายเล็บ</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($naildesign as $naildesigns)
                                    @php
                                        $designTime = $naildesigns->design_time;
                                        $hours = floor($designTime);
                                        $minutes = ($designTime - $hours) * 60;
                                        $formattedTime = $hours . ' ชั่วโมง';
                                        if ($minutes > 0) {
                                            $formattedTime .= ' ' . $minutes . ' นาที';
                                        }
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $naildesigns->nail_design_id }}</th>
                                        <td class="nailname-cell">{{ $naildesigns->nailname }}</td>
                                        <td><img src="naildesingimage/{{ $naildesigns->image }}" width="50%"
                                                height="100"></td>
                                        <td>{{ $naildesigns->design_price }} </td>
                                        <td>{{ $formattedTime }}</td>
                                        <td>{{ $naildesigns->design_type }}</td>
                                        <td>
                                            <a href="#" class="btn btn-warning editBtn"
                                                data-id="{{ $naildesigns->nail_design_id }}" data-bs-toggle="modal"
                                                data-bs-target="#editModal">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                    <path
                                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                                </svg>
                                            </a>
                                            <a href="{{ url('delete_naildesign', $naildesigns->nail_design_id) }}"
                                                class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                    <path
                                                        d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- popup -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">แก้ไข</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editModalBody">

                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.editBtn').click(function() {
                var nailId = $(this).data('id');
                $.get('{{ url('/edit_naildesign') }}/' + nailId, function(data) {
                    $('#editModalBody').html(data);
                });
                //   $.get('/edit_naildesign/'+nailId, function(data){
                //       $('#editModalBody').html(data);
                //   });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            //  session success
            var successToast = new bootstrap.Toast(document.getElementById('successToast'), {
                delay: 2000 // แสดง 2 วินาที
            });

            if ($('#successToast').length) {
                successToast.show();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // เมื่อคลิกปุ่มลบ
            $('.btn-danger').click(function(event) {
                var result = confirm("คุณต้องการลบลายเล็บนี้?");
                if (!result) {
                    event.preventDefault(); // ถ้าผู้ใช้ไม่กดยืนยัน, ให้หยุดการกระทำ
                }
            });
        });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
