
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Chat Rooms'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 11 , 'subSlag' => 111 + $state])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.charRooms')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">
                    @if($state == 0)
                    <h6>{{ __('main.inActiveChatRooms') }}</h6>
                    @else
                    <h6>{{ __('main.activeChatRooms') }}</h6>
                    @endif

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.tag') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.name') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.lock_State') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.password') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.subject') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.room_owner') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.talkers') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.miccount') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.isBlock') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.created_at') }}</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($rooms as $room )
                        <tr>
                          <td  class="text-center"> {{ $room -> tag }}</td>
                          <td  class="text-center"> {{ $room -> name }}</td>
                          <td class="text-center"> <img src="{{ asset('images/Rooms/' . $room->img) }}" width="80"/>  </td>
                          <td class="text-center">
                            <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($room -> state == 1 ) checked  @endif/>
                         </td>
                          <td  class="text-center"> {{ $room -> password }}</td>
                          <td  class="text-center"> {{ $room -> subject }}</td>
                          <td  class="text-center"> {{ $room -> room_owner }}</td>
                          <td  class="text-center"> {{ $room -> talkers_count }}</td>
                          <td  class="text-center"> {{ $room -> micCount }}</td>
                          <td  class="text-center"> {{ $room -> micCount }}</td>
                          <td class="text-center">
                            <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($room -> isBlocked == 1 ) checked  @endif/>
                         </td>
                         <td  class="text-center"> {{ $room -> createdDate }}</td>
                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $room -> id }}"><i class="fas fa-edit"></i></button>
                          </td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
      @include('layouts.fixedPlugin')

      @include('layouts.footer')



    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
