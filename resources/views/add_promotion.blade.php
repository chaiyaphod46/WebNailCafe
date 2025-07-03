<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NailCafe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
    <link rel="icon" href="{{ asset('imag/nailcafe8.jpg') }}">

</head>
<body>
<main class="d-flex flex-nowrap">
   @include('navbar')

   <div class="p-3 container-fluid " >
        <div class="p-2 mb-1 rounded-3 shadow-sm" style="background-color: rgb(252, 229, 220);">
                <center><h5 class="fw-bold">เพิ่มโปรโมชัน</h5></center>
          </div>
        <section class="w-100 p-4 d-flex justify-content-center pb-4">

        <form class="needs-validation" action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-sm-6">
            <label for="promotion_name" class="form-label">ชื่อโปรโมชัน</label>
            <input type="text" class="form-control" name="promotion_name" required>
        </div>
        <div class="col-sm-6">
            <label for="promotion_code" class="form-label">รหัสโปรโมชัน</label>
            <input type="text" class="form-control" name="promotion_code" required>
        </div>
        <div class="col-sm-6">
            <label for="" class="form-label">ส่วนลด</label>
            <div class="d-flex align-items-center">
                <input type="number" class="form-control me-2 flex-grow-1" name="discount_value" required>
                <select class="form-control flex-shrink-0"  name="discount_type" required style="width: auto;">
                    <option value="percentage">%</option>
                    <option value="fixed">บาท</option>
                </select>
            </div>
        </div>

        <div class="col-sm-6">
    <label for="nail_names" class="form-label">เลือกลายเล็บที่ต้องการลด</label>
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            เลือกลายเล็บ
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="max-height: 400px; overflow-y: auto; padding: 10px;">
            <!-- Dropdown  -->
            <div class="dropdown-item-1">
                <label>ประเภท</label>
                <select id="designTypeFilter" class="form-select">
                    <option value="">ทั้งหมด</option>
                    <option value="พื้น">พื้น</option>
                    <option value="กริตเตอร์">กริตเตอร์</option>
                    <option value="แมท">แมท</option>
                    <option value="มาร์เบิล">มาร์เบิล</option>
                    <option value="เฟรนช์">เฟรนช์</option>
                    <option value="ออมเบร">ออมเบร</option>
                    <option value="เพ้นท์ลาย">เพ้นท์ลาย</option>
                    <option value="3D">3D</option>
                    <option value="แม่เหล็ก">แม่เหล็ก</option>
                </select>
            </div>
            <hr>
            <!-- Checkbox เลือกทั้งหมด -->
            <div class="dropdown-item-1">
                <input type="checkbox" id="selectAllCheckbox" /> เลือกทั้งหมด
            </div>
            <!-- รายการลายเล็บ -->
            <div id="nailDesignList">
                @foreach($naildesigns as $naildesign)
                    <div class="dropdown-item" data-design-type="{{ $naildesign->design_type }}">
                        <input type="checkbox" class="nail-design-checkbox" name="nail_names[]" value="{{ $naildesign->nail_design_id }}">
                        <img src="naildesingimage/{{$naildesign->image}}" alt="{{ $naildesign->nail_design_id }}" class="nail-design-image">
                        <div class="nail-design-name">{{ $naildesign->nailname }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    </div>
        <div class="col-sm-3">
            <label for="start_time" class="form-label">เริ่ม</label>
            <input type="date" class="form-control" name="start_time" required>
        </div>
        <div class="col-sm-3">
            <label for="end_time" class="form-label">สิ้นสุด</label>
            <input type="date" class="form-control" name="end_time" required>
        </div>

        <!-- แสดงรายการลายเล็บที่เลือก -->
        <div class="mt-3" id="selectedNailDesigns" style="display: none;">
            <label>ลายเล็บที่เข้าร่วมโปรโมชั่น</label>
        <div class="d-flex flex-wrap" id="nailDesignPreview"></div>
    </div>

    <hr class="my-4">
        <button class="btn btn-primary btn-lg w-25 d-block mx-auto" type="submit">บันทึก</button>

             @if (session('success'))
                  <div id="successToast" class="toast align-items-center text-white bg-success border-0 position-fixed top-50 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                      <div class="toast-body">
                          {{ session('success') }}
                      </div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                @endif
</form>

        </section>

        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-1">
                <h4 class="fw-bold">รายการโปรโมชัน</h4>
                <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped">
                    <thead style="position: sticky; top: 0; background-color: #fff; z-index: 10;">
                        <tr>
                            <th scope="col">ชื่อโปรโมชัน</th>
                            <th scope="col">รหัสโปรโมชัน</th>
                            <th scope="col">ส่วนลด</th>
                            <th scope="col">เริ่ม</th>
                            <th scope="col">สิ้นสุด</th>
                            <th scope="col">สถานะ</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($promotions as $promotion)
                            <tr>
                                <td> {{ $promotion->promotion_name }} </td>
                                <td> {{ $promotion->promotion_code }} </td>
                                <td>    @if($promotion->discount_type == 'percentage')
                                            {{ $promotion->discount_value }}%
                                        @else
                                            {{ $promotion->discount_value }} บาท
                                        @endif
                                </td>
                                <td>{{ $promotion->start_time->format('d/m/Y') }} </td>
                                <td>{{ $promotion->end_time ? $promotion->end_time->format('d/m/Y') : 'ไม่ระบุ' }}</td>
                                <td class="{{ $promotion->status == 'A' ? 'text-success' : ($promotion->status == 'D' ? 'text-danger' : '') }}">
                                    @if($promotion->status == 'A')
                                        ใช้ได้
                                    @elseif($promotion->status == 'D')
                                        ใช้ไม่ได้
                                    @else
                                        ไม่ระบุสถานะ
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-warning editBtn" data-id="{{$promotion->promotion_id}}" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ url('delete_promotion', $promotion->promotion_id) }}" class="btn btn-danger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
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

<!--  Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
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
        var promotionId  = $(this).data('id');
        $.get('{{ url("/edit_promotion") }}/' + promotionId, function(data){
            $('#editModalBody').html(data);
        });
    });
});
</script>



<script>
   document.addEventListener('DOMContentLoaded', () => {
    const designTypeFilter = document.getElementById('designTypeFilter');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const nailDesignCheckboxes = document.querySelectorAll('.nail-design-checkbox');
    const nailDesignItems = document.querySelectorAll('#nailDesignList .dropdown-item');
    const nailDesignPreview = document.getElementById('nailDesignPreview');

    // ฟังก์ชันกรองตามประเภท
    designTypeFilter.addEventListener('change', () => {
        const selectedType = designTypeFilter.value;
        nailDesignItems.forEach(item => {
            if (!selectedType || item.dataset.designType === selectedType) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ฟังก์ชันเลือกทั้งหมด
    selectAllCheckbox.addEventListener('change', () => {
        const selectedType = designTypeFilter.value;
        nailDesignCheckboxes.forEach(checkbox => {
            const parentItem = checkbox.closest('.dropdown-item');
            if (!selectedType || parentItem.dataset.designType === selectedType) {
                checkbox.checked = selectAllCheckbox.checked;
                updateSelectedNailDesigns();
            }
        });
    });

    // ฟังก์ชันอัปเดตการแสดงผลลายเล็บที่เลือก
    const updateSelectedNailDesigns = () => {
    nailDesignPreview.innerHTML = ''; // ล้างข้อมูลเดิม
    let hasSelected = false; // ตัวแปรตรวจสอบว่ามีการเลือกหรือไม่
    nailDesignCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            hasSelected = true; // เป็น true หากมี checkbox ถูกติ๊ก
            const parentItem = checkbox.closest('.dropdown-item');
            const img = parentItem.querySelector('img');
            const imgClone = img.cloneNode(true);
            imgClone.style.margin = '5px';
            imgClone.style.position = 'relative';

            // สร้าง container สำหรับรูปและปุ่มกากบาท
            const imgContainer = document.createElement('div');
            imgContainer.style.position = 'relative';
            imgContainer.style.display = 'inline-block';

            // สร้างปุ่มกากบาท
            const closeButton = document.createElement('button');
            closeButton.textContent = '×';
            closeButton.classList.add('close-button'); // เพิ่มคลาส
            document.body.appendChild(closeButton);

            // เพิ่มฟังก์ชันการคลิกปุ่มกากบาท
            closeButton.addEventListener('click', () => {
                checkbox.checked = false; // ยกเลิกการติ๊ก checkbox
                updateSelectedNailDesigns(); // อัปเดตการแสดงผล
            });

            // ใส่รูปและปุ่มกากบาทใน container
            imgContainer.appendChild(imgClone);
            imgContainer.appendChild(closeButton);
            nailDesignPreview.appendChild(imgContainer);
        }
    });

    // ซ่อนหรือแสดงส่วน "ลายเล็บที่เลือก"
    const selectedNailDesignsDiv = document.getElementById('selectedNailDesigns');
    if (hasSelected) {
        selectedNailDesignsDiv.style.display = 'block';
    } else {
        selectedNailDesignsDiv.style.display = 'none';
    }
};

    // ติดตามการเปลี่ยนสถานะของ checkbox
    nailDesignCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedNailDesigns);
    });
});
</script>

<script>
    $(document).ready(function() {
        // แสดง Toast เมื่อมี session success
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
            var result = confirm("คุณต้องการลบโปรโมชันนี้ ?");
            if (!result) {
                event.preventDefault();  // ถ้าผู้ใช้ไม่กดยืนยัน, ให้หยุดการกระทำ
            }
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
