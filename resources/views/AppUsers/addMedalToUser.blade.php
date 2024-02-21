<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'User Medal'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 10 , 'subSlag' => 105])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.addMedalTouser')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.addMedalTouser') }}</h6>


                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h3 class="card-title">{{ __('main.user_tag') }}</h3>
                                    <input id="tag" type="text" placeholder="{{ __('main.user_tag') }}"
                                        class="form-control" onkeyup="getUserByTag()">
                                </div>
                                <div class="row" style="margin-top: 30px">
                                    <div class="col-lg-6 usercard">
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
                                                <input type="hidden" name="userIdd" id="userIdd" />

                                                <div class="fw-bold text-gray-400 mb-6" id="userId"></div>
                                                <div class="d-flex flex-center flex-wrap">
                                                    <div class="table-responsive p-0">
                                                        <table
                                                            class="table align-items-center justify-content-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th
                                                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                                        {{ __('main.name') }}</th>
                                                                    <th
                                                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                        {{ __('main.badge_icon') }}</th>


                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="my_badges">


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 usercard">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="card-title">{{ __('main.addMedalTouser') }}</h2>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center justify-content-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th
                                                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                                    {{ __('main.name') }}</th>
                                                                <th
                                                                    class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                    {{ __('main.badge_icon') }}</th>


                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($medals as $badge )
                                                            <tr>
                                                                <td class="text-center"> {{ $badge -> name }}</td>
                                                                <td class="text-center"> <img
                                                                        src="{{ asset('images/Badges/' . $badge->icon) }}"
                                                                        width="40" /> </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-info editBtn"
                                                                        value="{{ $badge -> id }}"><i
                                                                            class="fas fa-check"></i></button>

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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.fixedPlugin')

            @include('layouts.footer')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
                                 $('#userIdd').val(response[0].id);
                                 $('#userDiamond').html(response[0].diamond);
                                 $('#userGold').html(response[0].gold);
                                 $('#UserId').val(response[0].id);

                                 getUserMedals(response[0].id);
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
              function getUserMedals(id){
                $.ajax({
                        type:'get',
                        url:'/getuserMedals' + '/' + id,
                        dataType: 'json',

                        success:function(response){
                              console.log(response);
                              //my_badges
                              var table = document.getElementById("my_badges");
                              $("#my_badges tr").remove(); 
                              for(var i = 0 ; i < response.length ; i++){
                                var row = table.insertRow(-1);
                                var cell1 = row.insertCell(0);
                                var cell2 = row.insertCell(1);
                                var cell3 = row.insertCell(2);

                               

                                cell1.innerHTML = response[i].name;
                                cell2.innerHTML = '<img   src=" '+ '{{asset('images/Badges')}}' + '/'  + response[i].icon +' "  width="40" /> ';
                                cell3.innerHTML = ' <button type="button" class="btn btn-danger deleteBtn" value="' + response[i].id + '" "><i class="fas fa-trash"></i></button>';
                              }
                        }
                    });
              }

              $(document).on('click', '.editBtn', function(event) {
                let id = event.currentTarget.value ;
                event.preventDefault();
                let user_id = $('#userIdd').val();
                 console.log(user_id , id);
 
                let url = "{{ route('AddMedalToUserPost', [':user_id' , ':medal_id'] ) }}";
                        url = url.replace(':user_id', user_id);
                        url = url.replace(':medal_id', id);
                        document.location.href=url;
              });

              $(document).on('click', '.deleteBtn', function(event) {
                let id = event.currentTarget.value ;
                event.preventDefault();
                let user_id = $('#userIdd').val();
                 console.log(user_id , id);
              
                let url = "{{ route('deleteMedalToUserPost', [':user_id' , ':medal_id'] ) }}";
                        url = url.replace(':user_id', user_id);
                        url = url.replace(':medal_id', id);
                        document.location.href=url;
              });

              


            </script>

        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>