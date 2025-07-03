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
 <form class="needs-validation" action="{{url('save_edit_promotion', $promotion->promotion_id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="promotion_name" class="form-label">ชื่อโปรโมชัน</label>
                <input type="text" class="form-control" name="promotion_name" value="{{ $promotion->promotion_name }}">
            </div>
            <div class="col-sm-6">
                <label for="promotion_code" class="form-label">รหัสโปรโมชัน</label>
                <input type="text" class="form-control" name="promotion_code" value="{{ $promotion->promotion_code }}">
            </div>
            <div class="col-sm-12">
                <label for="" class="form-label">ส่วนลด</label>
                <div class="d-flex align-items-center">
                    <input type="number" class="form-control me-2 flex-grow-1" name="discount_value" value="{{ $promotion->discount_value }}">
                    <select class="form-select" name="discount_type">
                        <option value="percentage" {{ $promotion->discount_type == 'percentage' ? 'selected' : '' }}>%</option>
                        <option value="fixed" {{ $promotion->discount_type == 'fixed' ? 'selected' : '' }}>บาท</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-12">
    <label for="nail_names" class="form-label">เลือกลายเล็บที่ต้องการลด</label>
<!-- เเก้ใหม่-->
    <div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        เลือกลายเล็บ
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 300px; overflow-y: auto; position: static;">
            <!-- Dropdown ฟิลเตอร์ -->

            <!-- รายการลายเล็บ -->
            <div id="nailDesignList">
                @foreach($naildesigns as $naildesign)
                    <div class="dropdown-item" data-design-type="{{ $naildesign->design_type }}">
                        <input type="checkbox" class="nail-design-checkbox" name="nail_names[]" value="{{ $naildesign->nail_design_id }}"
                            @if(in_array($naildesign->nail_design_id, $selectedNailDesigns)) checked @endif>
                        <img src="naildesingimage/{{$naildesign->image}}" alt="{{ $naildesign->nail_design_id }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                        {{ $naildesign->nailname }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
   <!-- ------------------------------>
            <div class="col-sm-6">
                <label for="start_time" class="form-label">เริ่ม</label>
                <input type="date" class="form-control" name="start_time" value="{{ $promotion->start_time }}">
            </div>
            <div class="col-sm-6">
                <label for="end_time" class="form-label">สิ้นสุด</label>
                <input type="date" class="form-control" name="end_time" value="{{ $promotion->end_time }}">
            </div>
        </div>
        <hr class="my-4">
        <button class="btn btn-primary btn-lg w-50 d-block mx-auto" type="submit">บันทึก</button>
    </form>


 </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVFykSAYCgmbB6dmANt6XizYpEPJbPye1iEZFl+bc4NkuLh2L9gZ" crossorigin="anonymous"></script>
</body>
</html>
