<aside class="sidenav navbar  navbar-vertical navbar-expand-xs @if(Config::get('app.locale')=='ar' ) fixed-end @else fixed-start @endif  border-0 border-radius-xl my-3  ms-3 bg-white"
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html "
      target="_blank">
      <img src="{{ asset('assets/icons/chat.png') }}" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">Chat Dashboard</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main" style="height: 100%">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a @if($slag==1) class="nav-link  active" @else class="nav-link" @endif href="{{ route('home') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/dashboard.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.dashboard') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==10) class="nav-link dropdown active" @else class="nav-link" @endif href="javascript:;"
          data-bs-toggle="dropdown" aria-expanded="false">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/teamwork.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{__('main.appusers')}}</span>
          <button class="Arrowbutton" value="dropdown-menu-2" id="dropdown-button-2"><i
              class="fas fa-chevron-down"></i></button>
        </a>
        <ul class="dropdown-menu text-small subM" aria-labelledby="dropdown" id="dropdown-menu-2">
          <li><a @if($subSlag==101) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('appUsers' , 1)}}">{{__('main.allUsers')}}</a></li>
          <li><a @if($subSlag==102) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('appUsers' , 0)}}">{{__('main.blockedUsers')}}</a></li>
          <li><a @if($subSlag==103) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('chargeAppUserBalance')}}">{{__('main.chargeUsersBalance')}}</a></li>
          <li><a @if($subSlag==104) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('userNotifications')}}">{{__('main.sendUserAlert')}}</a></li>

        </ul>
      </li>

      <li class="nav-item">
        <a @if($slag==11) class="nav-link dropdown active" @else class="nav-link" @endif href="javascript:;"
          data-bs-toggle="dropdown" aria-expanded="false">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/rooms.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{__('main.charRooms')}}</span>
          <button class="Arrowbutton" value="dropdown-menu-2" id="dropdown-button-2"><i
              class="fas fa-chevron-down"></i></button>
        </a>
        <ul class="dropdown-menu text-small subM" aria-labelledby="dropdown" id="dropdown-menu-2">
          <li><a @if($subSlag==112) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('chatRooms' , 1)}}">{{__('main.activeChatRooms')}}</a></li>
          <li><a @if($subSlag==111) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('chatRooms' , 0)}}">{{__('main.inActiveChatRooms')}}</a></li>

        </ul>
      </li>

      <li class="nav-item">
        <a @if($slag==7) class="nav-link dropdown active" @else class="nav-link" @endif href="javascript:;"
          data-bs-toggle="dropdown" aria-expanded="false">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/store.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{__('main.store')}}</span>
          <button class="Arrowbutton" value="dropdown-menu-2" id="dropdown-button-2"><i
              class="fas fa-chevron-down"></i></button>
        </a>
        <ul class="dropdown-menu text-small subM" aria-labelledby="dropdown" id="dropdown-menu-2">
          <li><a @if($subSlag==71) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('categories')}}">{{__('main.categories')}}</a></li>
          <li><a @if($subSlag==72) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('giftCategories')}}">{{__('main.gift_categories')}}</a></li>
          <li><a @if($subSlag==73) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('designs')}}">{{__('main.designs')}}</a></li>
          <li><a @if($subSlag==74) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('themes')}}">{{__('main.themes')}}</a></li>
          <li><a @if($subSlag==75) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('emotions')}}">{{__('main.emossions')}}</a></li>
          <li><a @if($subSlag==76) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('specialUID')}}">{{__('main.uid')}}</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a @if($slag==6) class="nav-link  active" @else class="nav-link" @endif href="{{ route('vip') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/crown.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.vip') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==2) class="nav-link dropdown active" @else class="nav-link" @endif href="javascript:;"
          data-bs-toggle="dropdown" aria-expanded="false">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/levels.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{__('main.levels')}}</span>
          <button class="Arrowbutton" value="dropdown-menu-2" id="dropdown-button-2"><i
              class="fas fa-chevron-down"></i></button>
        </a>
        <ul class="dropdown-menu text-small subM" aria-labelledby="dropdown" id="dropdown-menu-2">
          <li><a @if($subSlag==21) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('levels' , 0)}}">{{__('main.levels_share')}}</a></li>
          <li><a @if($subSlag==22) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('levels' , 1)}}">{{__('main.level_karizma')}}</a></li>
          <li><a @if($subSlag==23) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('levels' , 2)}}">{{__('main.level_charge')}}</a></li>

        </ul>
      </li>

      <li class="nav-item">
        <a @if($slag==3) class="nav-link  active" @else class="nav-link" @endif href="{{ route('badges') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/medal.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.badges') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==12) class="nav-link  active" @else class="nav-link" @endif href="{{ route('festival_banners') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/party.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.fesival_banners') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==5) class="nav-link  active" @else class="nav-link" @endif href="{{ route('banners') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/img/banners.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.banners') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==4) class="nav-link  active" @else class="nav-link" @endif href="{{ route('countries') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/countries.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.countries') }}</span>
        </a>
      </li>

      <li class="nav-item">
        <a @if($slag==9) class="nav-link  active" @else class="nav-link" @endif href="{{ route('designPurchases') }}">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/goods.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{ __('main.design_purchases') }}</span>
        </a>
      </li>


      <li class="nav-item">
        <a @if($slag==8) class="nav-link dropdown active" @else class="nav-link" @endif href="javascript:;"
          data-bs-toggle="dropdown" aria-expanded="false">
          <div
            class="icon icon-shape icon-md shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <img src="{{ asset('assets/icons/admins.png') }}" style="width: 20px ">
          </div>
          <span class="nav-link-text ms-1">{{__('main.admins')}}</span>
          <button class="Arrowbutton" value="dropdown-menu-2" id="dropdown-button-2"><i
              class="fas fa-chevron-down"></i></button>
        </a>
        <ul class="dropdown-menu text-small subM" aria-labelledby="dropdown" id="dropdown-menu-2">
          <li><a @if($subSlag==81) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('admins')}}">{{__('main.admins')}}</a></li>
          <li><a @if($subSlag==82) class="dropdown-item active-drop" @else class="dropdown-item" @endif
              href="{{route('roles')}}">{{__('main.roles')}}</a></li>

        </ul>
      </li>






    </ul>
  </div>

</aside>
