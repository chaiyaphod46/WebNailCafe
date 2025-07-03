<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>
<body>
 <section class="w-100 p-4 d-flex justify-content-center pb-4">
    
 <form  class="needs-validation" action="{{url('save_edit_manicurist',$manicurist->manicurist_id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="firstName" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" name="first_name" value="{{$manicurist->first_name}}" required>
        </div>
        <div class="col-sm-6">
            <label for="lastName" class="form-label">นามสกุล</label>
            <input type="text" class="form-control" name="last_name" value="{{$manicurist->last_name}}" required>
        </div>
        <div class="col-sm-6">
            <label for="nickname" class="form-label">ชื่อเล่น</label>
            <input type="text" class="form-control" name="nickname" value="{{$manicurist->nickname}}" required>
        </div>
        <div class="col-sm-6">
            <label for="phoneNumber" class="form-label">เบอร์โทร</label>
            <input type="text" class="form-control" name="phone_number" value="{{$manicurist->phone_number}}" required>
        </div>
    </div>
    <hr class="my-4">
    <button class="btn btn-primary btn-lg w-50 d-block mx-auto" type="submit">บันทึก</button>
</form>

 </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>
</html>