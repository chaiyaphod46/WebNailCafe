
<div class="d-flex flex-column flex-shrink-0 p-3 sticky-top custom-navbar" style="width: 280px; height: 100vh;">

    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
      <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">NailCafe</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{url('admin/home')}}" class="nav-link link-body-emphasis {{ Request::is('admin/home*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
                การจองของลูกค้า
            </a>
        </li>
        <li>
            <a href="{{url('add_naildesign')}}" class="nav-link link-body-emphasis {{ Request::is('add_naildesign*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                จัดการรายละเอียดลายเล็บ
            </a>
        </li>
        <li>
            <a href="{{url('opening_hours')}}" class="nav-link link-body-emphasis {{ Request::is('opening_hours*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
                จัดการวัน-เวลาให้บริการ
            </a>
        </li>
        <li>
            <a href="{{url('add_otherservice')}}" class="nav-link link-body-emphasis {{ Request::is('add_otherservice*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
                จัดการบริการเสริม
            </a>
        </li>
        <li>
            <a href="{{url('add_promotion')}}" class="nav-link link-body-emphasis {{ Request::is('add_promotion*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"></use></svg>
                จัดโปรโมชัน
            </a>
        </li>

        <li>
        <a href="{{url('dashboard')}}" class="nav-link link-body-emphasis {{ Request::is('dashboard*') ? 'active' : '' }}">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#"></use></svg>
                เเดชบอร์ด
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
       <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
        </a>
       <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
         <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
         </a>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
         </form>
       </div>
     </div>
</div>
