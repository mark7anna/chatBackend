<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Gift Transactions'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 13 , 'subSlag' => 0])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.gift_transactions')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.gift_transactions') }}</h6>



                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('main.gift') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.sender') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.reciever') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.room') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.count') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.price') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.total') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.send_date') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction )
                                        <tr>
                                            <td class="text-center">
                                                <div style="display: flex ; justify-content: center">
                                                    <img src="{{ asset('images/Designs/' . $transaction->gift_img) }}"
                                                        width="80" />
                                                    <span>{{ $transaction -> gift_name }} ({{ $transaction ->
                                                        gift_tag}})</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="display: flex ; justify-content: center">
                                                    <img src="{{ asset('images/AppUsers/' . $transaction->sender_img) }}"
                                                        width="60" height="60" style="border-radius: 50%" />
                                                    <span>{{ $transaction -> sender_name }} ({{ $transaction ->
                                                        sender_tag }})</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="display: flex ; justify-content: center">
                                                    @if ($transaction->receiver_img != "")
                                                    <img src="{{ asset('images/AppUsers/' . $transaction->receiver_img) }}"
                                                        width="60" height="60" style="border-radius: 50%" />
                                                    @endif

                                                    <span>{{ $transaction -> receiver_name }} ({{ $transaction ->
                                                        receiver_tag }})</span>
                                                </div>
                                            </td>

                                            <td class="text-center"> {{ $transaction -> room_name}}</td>
                                            <td class="text-center"> {{ $transaction -> count }}</td>
                                            <td class="text-center"> {{ $transaction -> price }}</td>

                                            <td class="text-center"> {{ $transaction -> total}}</td>
                                            <td class="text-center"> {{ $transaction -> sendDate}}</td>


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