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
    <form style="width: 28rem;" action="{{ url('save_edit_naildesign', $naildesign->nail_design_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="nailname">ลายเล็บ</label>
                    <input type="text" id="nailname" name="nailname" value="{{ $naildesign->nailname }}" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="design_price">ราคา</label>
                    <input type="number" id="design_price" name="design_price" value="{{ $naildesign->design_price }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="design_time">เวลาในการทำ (ชั่วโมง)</label>
                    <select id="design_time" class="form-control" name="design_time" required>
                        <option value="1" {{ $naildesign->design_time == 1 ? 'selected' : '' }}>1 ชั่วโมง</option>
                        <option value="1.5" {{ $naildesign->design_time == 1.5 ? 'selected' : '' }}>1 ชั่วโมง 30 นาที</option>
                        <option value="2" {{ $naildesign->design_time == 2 ? 'selected' : '' }}>2 ชั่วโมง</option>
                        <option value="2.5" {{ $naildesign->design_time == 2.5 ? 'selected' : '' }}>2 ชั่วโมง 30 นาที</option>
                        <option value="3" {{ $naildesign->design_time == 3 ? 'selected' : '' }}>3 ชั่วโมง</option>
                        <option value="3.5" {{ $naildesign->design_time == 3.5 ? 'selected' : '' }}>3 ชั่วโมง 30 นาที</option>
                        <option value="4" {{ $naildesign->design_time == 4 ? 'selected' : '' }}>4 ชั่วโมง</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="design_type">ประเภทลายเล็บ</label>
                    <select id="design_type" class="form-control" name="design_type" required>
                        <option value="พื้น" {{ $naildesign->design_type == 'พื้น' ? 'selected' : '' }}>ลายสีพื้น</option>
                        <option value="กริตเตอร์" {{ $naildesign->design_type == 'กริตเตอร์' ? 'selected' : '' }}>ลายสีกริตเตอร์</option>
                        <option value="แมท" {{ $naildesign->design_type == 'แมท' ? 'selected' : '' }}>ลายสีแมท</option>
                        <option value="มาร์เบิล" {{ $naildesign->design_type == 'มาร์เบิล' ? 'selected' : '' }}>ลายสีมาร์เบิล</option>
                        <option value="เฟรนช์" {{ $naildesign->design_type == 'เฟรนช์' ? 'selected' : '' }}>ลายสีเฟรนช์</option>
                        <option value="ออมเบร" {{ $naildesign->design_type == 'ออมเบร' ? 'selected' : '' }}>ลายสีออมเบร</option>
                        <option value="เพ้นท์ลาย" {{ $naildesign->design_type == 'เพ้นท์ลาย' ? 'selected' : '' }}>ลายสีเพ้นท์ลาย</option>
                        <option value="3D" {{ $naildesign->design_type == '3D' ? 'selected' : '' }}>ลาย 3D</option>
                        <option value="แม่เหล็ก" {{ $naildesign->design_type == 'แม่เหล็ก' ? 'selected' : '' }}>ลายสีแม่เหล็ก</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label">รูปเก่า</label><br>
                    <img src="naildesingimage/{{ $naildesign->image }}" width="150" height="150" alt="Old Image">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-outline">
                    <label class="form-label">เปลี่ยนรูป</label><br>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg btn-block mb-4">บันทึก</button>
        </div>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
