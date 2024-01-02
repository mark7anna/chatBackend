<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Blocked Members'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 10 , 'subSlag' => 102])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.blockedUsers')])
        <!-- End Navbar -->
        <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.blockedUsers') }}</h6>


                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('main.tag') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.name') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.img') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.level') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.diamond') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.gold') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.online') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.charge_agent') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.host_agent') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.enable') }}</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user )
                                        <tr>
                                            <td class="text-center">{{ $user -> tag }}</td>
                                            <td class="text-center">{{ $user -> name }}</td>
                                            <td class="text-center"> <img
                                                    src="{{ asset('images/AppUsers/' . $user->img) }}" width="50"
                                                    height="50" style="border-radius: 50%" /> </td>
                                            <td class="text-center"> <img
                                                    src="{{ asset('images/Levels/' . $user->level_img) }}" width="50" />
                                            </td>
                                            <td class="text-center"> {{ $user -> diamond }}</td>
                                            <td class="text-center"> {{ $user -> gold }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check" onclick="return false;"
                                                    style="display: block ; margin:auto" @if($user -> isOnline ==
                                                1 )
                                                checked @endif/>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check" onclick="return false;"
                                                    style="display: block ; margin:auto" @if($user -> isChargingAgent ==
                                                1 )
                                                checked @endif/>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check" onclick="return false;"
                                                    style="display: block ; margin:auto" @if($user -> isHostingAgent ==
                                                1 )
                                                checked @endif/>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" class="form-check" onclick="return false;"
                                                    style="display: block ; margin:auto" @if($user -> enable ==
                                                1 )
                                                checked @endif/>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-success editBtn"
                                                    value="{{ $user -> id }}"><i class="fas fa-edit"></i></button>
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
