<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
</head>
<body>
<main class="d-flex flex-nowrap">
   @include('navbar')
   <div class="p-3 container-fluid" >
        <div class="p-2 mb-1 bg-light rounded-3">
            <center><h5 class="fw-bold">เพิ่มพนักงาน</h5></center>
        </div>

        <section class="w-100 p-4 d-flex justify-content-center pb-4">
            <form class="needs-validation" action="{{ url('upload_manicurist') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="nickname" class="form-label">ชื่อเล่น</label>
                        <input type="text" class="form-control" name="nickname" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="phoneNumber" class="form-label">เบอร์โทร</label>
                        <input type="text" class="form-control" name="phone_number" required>
                    </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-primary btn-lg w-50 d-block mx-auto" type="submit">บันทึก</button>
            </form>
        </section>

        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-1">
                <h4 class="fw-bold">พนักงาน</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>

                            <th scope="col">ชื่อ-นามสกุล</th>
                            <th scope="col">ชื่อเล่น</th>
                            <th scope="col">เบอร์โทร</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($manicurists as $manicurist)
                            <tr>

                                <td>{{ $manicurist->first_name }} {{ $manicurist->last_name }}</td>
                                <td>{{ $manicurist->nickname }}</td>
                                <td>{{ $manicurist->phone_number }}</td>
                                <td>
                                    <a href="#" class="btn btn-warning editBtn" data-id="{{$manicurist->manicurist_id}}" data-bs-toggle="modal" data-bs-target="#editModal">แก้ไข</a>
                                    <a href="{{ url('delete_manicurist', $manicurist->manicurist_id) }}" class="btn btn-danger">ลบ</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal for Edit -->
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
$(document).ready(function(){
    $('.editBtn').click(function(){
        var manicuristId = $(this).data('id');
        $.get('/edit_manicurist/' + manicuristId, function(data){
            $('#editModalBody').html(data);
        });
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
