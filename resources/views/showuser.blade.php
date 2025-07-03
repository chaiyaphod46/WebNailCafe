<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/adminstyle.css">
    <link rel="icon" href="{{ asset('imag/nailcafe1.jpg') }}">
</head>
<body>
  
<main class="d-flex flex-nowrap" >
   @include('navbar')

   <div class="p-3 container-fluid">
        <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center><h5 class="fw-bold">ข้อมูลลูกค้า</h5></center>
          </div>
      <section class="w-100 p-4 d-flex justify-content-center pb-4">
      
      </section>
      
      <div class="p-3 mb-4 bg-light rounded-3">
        <div class="container-fluid py-1">
            <h5 class="fw-bold">ลูกค้า</h5>
        
            <table class="table table-striped">
                <thead style="position: sticky; top: 0; background-color: #fff; z-index: 10;">
                    <tr>
                        <th scope="col">รหัสลูกค้า</th>
                        <th scope="col">ชื่อลูกค้า</th>
                        <th scope="col">อีเมล</th>
                        <th scope="col">เบอร์โทรศัพท์</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id}}</th>
                        <th scope="row">{{ $user->name }}</th>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phon }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
    </div>    
    </div>
</main>






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
</body>
</html>
