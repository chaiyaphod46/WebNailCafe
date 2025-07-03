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

<form style="width: 22rem;" action="{{ url('save_edit_otherservice', $service->service_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-outline mb-4">
        <label class="form-label" for="service_name">ชื่อบริการ</label>
        <input type="text" id="service_name" name="service_name" value="{{ $service->service_name }}" class="form-control">
        
    </div>
    <div class="form-outline mb-4">
        <label class="form-label" for="service_price">ราคา</label>
        <input type="number" id="service_price" name="service_price" value="{{ $service->service_price }}" class="form-control">
    </div>
    <div class="form-outline mb-4">
        <label class="form-label" for="service_time">เวลาในการทำ (ชั่วโมง)</label>
        <select id="service_time" class="form-control" name="service_time" required>
            <option value="0.5" {{ $service->service_time == 0.5 ? 'selected' : '' }}>30 นาที</option>
            <option value="1" {{ $service->service_time == 1 ? 'selected' : '' }}>1 ชั่วโมง</option>
            <option value="1.5" {{ $service->service_time == 1.5 ? 'selected' : '' }}>1 ชั่วโมง 30 นาที</option>
            <option value="2" {{ $service->service_time == 2 ? 'selected' : '' }}>2 ชั่วโมง</option>
            <option value="2.5" {{ $service->service_time == 2.5 ? 'selected' : '' }}>2 ชั่วโมง 30 นาที</option>
            <option value="3" {{ $service->service_time == 3 ? 'selected' : '' }}>3 ชั่วโมง</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary btn-block">บันทึก</button>
</form>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
