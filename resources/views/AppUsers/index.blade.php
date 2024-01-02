<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'All Members'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 10 , 'subSlag' => 101])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.allUsers')])
        <!-- End Navbar -->
        <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.allUsers') }}</h6>


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

            @include('AppUsers.Profile')

            <script type="text/javascript">
                $(document).on('click', '.editBtn', function (event) {
                    let id = event.currentTarget.value ;
                    $.ajax({
                        type:'get',
                        url:'/getAppUserById' + '/' + id,
                        dataType: 'json',

                        success:function(response){

                            if(response.length > 0){
                                 console.log(response[0]);
                                event.preventDefault();
                                    let href = $(this).attr('data-attr');
                                    $.ajax({
                                        url: href,
                                        beforeSend: function () {
                                            $('#loader').show();
                                        },
                                        // return the result
                                        success: function (result) {

                                            var img =  '/../images/AppUsers/' + response[0].img ;
                                            $('#profileModal').modal("show");
                                            $("#userImg").attr('src' ,  img  );
                                            $("#userName").html(response[0].name);
                                            $("#userTag").html(response[0].tag);
                                            if(response[0].isChargingAgent == 1){
                                                $("#charge_agent").html($('<div>{{trans('main.yes')}}</div>').text());
                                            }else{
                                                $("#charge_agent").html($('<div>{{trans('main.no')}}</div>').text());
                                            }
                                            if(response[0].isHostingAgent == 1){
                                                $("#host_agent").html($('<div>{{trans('main.yes')}}</div>').text());
                                            }else{
                                                $("#host_agent").html($('<div>{{trans('main.no')}}</div>').text());
                                            }
                                            if(response[0].isOnline == 1){
                                                $('#offline').hide();
                                                $('#online').show();
                                            } else {
                                                $('#offline').show();
                                                $('#online').hide();
                                            }
                                            $("#diamond").html(response[0].diamond);
                                            $("#gold").html(response[0].gold);
                                            $("#register_date").html(response[0].registered_at);
                                            $("#last_login").html(response[0].last_login);
                                            $(".modal-body #name").val(response[0].name);
                                            $(".modal-body #tag").val(response[0].tag);
                                            $(".modal-body #email").val(response[0].email);
                                            $(".modal-body #birth_date").val(response[0].birth_date );
                                            $(".modal-body #macAddress").val(response[0].macAddress);
                                            $(".modal-body #deviceId").val(response[0].deviceId);
                                            $(".modal-body #password").val(response[0].password);
                                            $(".modal-body #USERID").val(response[0].id);
                                            $("#share_level_order").html(response[0].share_level_name);
                                            $("#karizma_level_order").html(response[0].karizma_level_name);
                                            $("#charrg_level_order").html(response[0].charging_level_name);
                                            var share_level_icon =  '/../images/Levels/' + response[0].share_level_img ;
                                            $("#share_level_icon").attr('src' ,  share_level_icon  );
                                            var charge_level_icon =  '/../images/Levels/' + response[0].charging_level_img ;
                                            $("#charge_level_icon").attr('src' ,  charge_level_icon  );

                                            var karizma_level_icon =  '/../images/Levels/' + response[0].karizma_level_img ;
                                            $("#karizma_level_icon").attr('src' ,  karizma_level_icon  );





                                        },
                                        complete: function () {
                                            $('#loader').hide();
                                        },
                                        error: function (jqXHR, testStatus, error) {
                                            console.log(error);
                                            alert("Page " + href + " cannot open. Error:" + error);
                                            $('#loader').hide();
                                        },
                                        timeout: 8000
                                    });
                            } else {

                            }
                        }
                    });





            });

            </script>

        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>
