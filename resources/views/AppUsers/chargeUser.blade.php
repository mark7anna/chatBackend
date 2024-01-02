<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Charge Balance'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 10 , 'subSlag' => 101])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.chargeUsersBalance')])
        <!-- End Navbar -->
        <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.chargeUsersBalance') }}</h6>


                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="card-title">{{ __('main.user_tag') }}</h3>
                                    <input id="tag" type="text" placeholder="{{ __('main.user_tag') }}"
                                        class="form-control" onkeyup="getUserByTag()">
                                </div>
                                <div class="col-lg-8 usercard">
                                    <div class="card mb-5 mb-xl-10">

                                        <div class="card-body d-flex flex-center flex-column "
                                            style="background: rgb(250, 250, 250); border-radius: 20px; border: 0.2px solid rgb(221, 223, 225);">
                                            <!---->
                                            <div class="symbol symbol-65px symbol-circle mb-5 "><img alt="image"
                                                    id="userImg" width="50" height="50" style="border-radius: 50%">
                                                <div
                                                    class="bg-danger position-absolute border border-4 border-white h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3">
                                                </div>
                                            </div> <a href="#"
                                                class="fs-4 text-gray-800 text-hover-primary fw-bolder mb-0"
                                                id="userName"></a>
                                            <div class="fw-bold text-gray-400 mb-6" id="userId"></div>
                                            <div class="d-flex flex-center flex-wrap">
                                                <div
                                                    class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                    <div class="fs-6 fw-bolder text-gray-700" id="userDiamond"></div>
                                                    <div class="fw-bold text-gray-400">{{ __('main.diamond') }}</div>
                                                </div>
                                                <div
                                                    class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                                    <div class="fs-6 fw-bolder text-gray-700" id="userGold"></div>
                                                    <div class="fw-bold text-gray-400">{{ __('main.gold')}}</div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 usercard">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="card-title">{{ __('main.diamond_charge_discharge') }}</h2>
                                        </div>
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('updateDiamondWallet') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group mb-5">
                                                    <div class="row">
                                                        <input type="hidden" name="userId" id="UserId">
                                                        <div class="col-lg-4"><select class="form-control"
                                                                name="chargeType">
                                                                <option value="1">{{ __('main.charge') }}</option>
                                                                <option value="0">{{ __('main.discharge') }}</option>
                                                            </select></div>
                                                        <div class="col-lg-8"><input type="number"
                                                                placeholder="{{ __('main.diamond') }}" min="0"
                                                                class="form-control form-control-solid" name="diamond">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group"><button type="submit"
                                                        class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success">
                                                        {{ __('main.charge') }}
                                                    </button>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.fixedPlugin')

            @include('layouts.footer')
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

            <script type="text/javascript">
                $(document).ready(function() {
                $('.usercard').hide();
                $('#tag').val("");
             });
                function getUserByTag(){
                let tag =  $('#tag').val() ;
                if(tag){
                         $.ajax({
                        type:'get',
                        url:'/getAppUserByTag' + '/' + tag,
                        dataType: 'json',

                        success:function(response){

                            if(response.length > 0){
                                var img =  '/../images/AppUsers/' + response[0].img ;
                                 $('.usercard').show();
                                 $("#userImg").attr('src' ,  img  );
                                 $('#userName').html(response[0].name);
                                 $('#userId').html(response[0].tag);
                                 $('#userDiamond').html(response[0].diamond);
                                 $('#userGold').html(response[0].gold);
                                 $('#UserId').val(response[0].id);
                            } else {
                                $('.usercard').hide();
                                $("#userImg").attr('src' ,  "" );
                                 $('#userName').html('');
                                 $('#userId').html('');
                                 $('#userDiamond').html('');
                                 $('#userGold').html('');
                                 $('#UserId').val(0);
                            }
                        }
                    });
                }

              }


            </script>

        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>
