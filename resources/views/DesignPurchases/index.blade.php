<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Designs Purchases'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 9 , 'subSlag' => 0])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.design_purchases')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.design_purchases') }}</h6>



                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('main.design') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.user') }}</th>
                                            {{-- <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.available') }}</th> --}}
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.purchase_date') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.available_until') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.price') }}</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchases as $purchase )
                                        <tr>
                                            <td class="text-center">
                                                <div style="display: flex ; justify-content: center">
                                                    <img src="{{ asset('images/Designs/' . $purchase->design_iocn) }}"
                                                        width="80" />
                                                    <span>{{ $purchase -> design_name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="display: flex ; justify-content: center">
                                                    @if ($purchase->user_img != "")
                                                    <img src="{{ asset('images/AppUsers/' . $purchase->user_img) }}"
                                                        width="60" height="60" style="border-radius: 50%" />
                                                    @endif

                                                    <span>{{ $purchase -> user_name }}</span>
                                                </div>
                                            </td>

                                            {{-- <td class="text-center">
                                                <input type="checkbox" class="form-check" onclick="return false;"
                                                    style="display: block ; margin:auto" @if() checked @endif />
                                            </td> --}}
                                            <td class="text-center"> {{ $purchase -> purchase_date }}</td>
                                            <td class="text-center"> {{ $purchase -> available_until }}</td>
                                            <td class="text-center"> {{ $purchase -> price }}</td>

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