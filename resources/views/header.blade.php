
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
              <li class="nav-item"><a class="nav-link px-2 link-secondary" href="{{ url('/home') }}">หน้าหลัก</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('/showreserv') }}">การจอง</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('/showtimeavailable') }}">วันเวลาว่าง</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('/showpromotion') }}">โปรโมชัน</a></li>
              <li class="nav-item"><a class="nav-link px-2" href="{{ url('showlikes') }}">ถูกใจ</a></li>
            </ul>
            <div class="text-center text-md-end mt-2 mt-md-0">
              @if(Auth::check())
                <!-- แสดงชื่อผู้ใช้งาน -->
                <div class="text-center text-md-end mt-2 mt-md-0">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        {{ __('แก้ไขข้อมูลส่วนตัว') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('ออกจากระบบ') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                </div>

              </div>
              @else
                <!-- แสดงปุ่มเข้าสู่ระบบ / ลงทะเบียน -->
                <div class="text-center text-md-end mt-2 mt-md-0">
                    <a href="{{url('/login')}}" class="btn btn-light rounded-pill px-3 me-2">เข้าสู่ระบบ</a>
                    <a href="{{url('/register')}}" class="btn btn-dark rounded-pill px-3">ลงทะเบียน</a>
                </div>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

@if(Auth::check())
 <!-- Edit Profile Modal -->
 <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">แก้ไขข้อมูลส่วนตัว</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('edit_profile') <!-- นำเข้าหน้า edit_profile.blade.php ภายใน modal -->
            </div>
        </div>
    </div>
</div>
@endif
