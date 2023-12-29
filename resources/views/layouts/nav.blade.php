<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $pageTitle }}</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">{{ $pageTitle }}</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          <div class="input-group">
            <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
            <input type="text" class="form-control" placeholder="Type here...">
          </div>
        </div>
        <ul class="navbar-nav  justify-content-end">


          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>
          <li class="nav-item dropdown px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-globe cursor-pointer"></i>
            </a>
            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
              <li class="">
                <a class="dropdown-item border-radius-md" hreflang="ar"
                href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="{{ asset('assets/icons/arabic.png') }}" class="avatar avatar-sm  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      Arabic | العربية
                    </div>
                  </div>
                </a>
              </li>
              <li class="">
                <a class="dropdown-item border-radius-md" hreflang="en"
                href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="{{ asset('assets/icons/english.png') }}" class="avatar avatar-sm  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      English | الإنجليزية
                    </div>
                  </div>
                </a>
              </li>

            </ul>
          </li>

          <li class="nav-item px-3 d-flex align-items-center" data-bs-target=".bs-example-modal-sm" data-bs-toggle="modal">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fa fa-power-off fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <div tabindex="-1" class="modal bs-example-modal-sm" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header"><h4>Logout <i class="fa fa-lock"></i></h4></div>
        <div class="modal-body"><i class="fa fa-question-circle"></i> Are you sure you want to log-off?</div>
        <div class="modal-footer"><a class="btn btn-primary btn-block" href="{{route('logout')}}"  onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Logout</a></div>
      </div>
    </div>
  </div>


  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
