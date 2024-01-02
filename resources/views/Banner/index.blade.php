
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Banners'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 5 , 'subSlag' => 0])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.banners')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                    <h6>{{ __('main.banners') }}</h6>


                    <button class="btn btn-primary" @if(Config::get('app.locale')=='ar' )
style="margin-right: auto "
@else style="margin-left: auto "
@endif
id="createButton" > <i class="fa fa-plus" style="margin-right: 10px"></i>  Add New</button>

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.name') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>

                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.type') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.link') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.order') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.created_at') }}</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($banners as $banner )
                        <tr>
                          <td  class="text-center"> {{ $banner -> name }}</td>
                          <td class="text-center"> <img src="{{ asset('images/Banners/' . $banner->img) }}" width="80"/>  </td>
                          <td class="text-center">
                            @if($banner -> type == 0)
                            <span class="text-xs font-weight-bold">{{ __('main.banner_home') }}</span>
                            @elseif($banner -> type == 1)
                            <span class="text-xs font-weight-bold">{{ __('main.banner_room') }}</span>
                            @elseif($banner -> type == 2)
                            <span class="text-xs font-weight-bold">{{ __('main.banner_landing') }}</span>
                            @elseif($banner -> type == 3)
                            <span class="text-xs font-weight-bold">{{ __('main.banner_games') }}</span>
                            @elseif($banner -> type == 4)
                            <span class="text-xs font-weight-bold">{{ __('main.banner_event') }}</span>
                            @endif
                          </td>
                          <td class="align-middle text-center">
                            @if($banner -> url)
                              <a href="{{ $banner -> url }}"> Click To View </a>
                              @else
                              <span>No Link</span>
                            @endif
                          </td>
                          <td class="align-middle text-center"> {{ $banner -> order }} </td>
                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $banner -> id }}"><i class="fas fa-edit"></i></button>
                          <button type="button" class="btn btn-danger deleteBtn" value="{{ $banner -> id }}"><i class="far fa-trash-alt"></i></button>
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

      @include('Banner.create')
      @include('Banner.deleteModal')
      <script type="text/javascript">
          $(document).on('click', '#createButton', function (event) {

        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function () {
                $('#loader').show();
            },
            // return the result
            success: function (result) {
                $('#createModal').modal("show");
                $(".modal-body #type").val("");
                $(".modal-body #name").val("");
                $(".modal-body #order").val("");
                $(".modal-body #action").val("");
                $(".modal-body #id").val(0);
                $(".modal-body #url").val("");
                $(".modal-body #user_id").val("");
                $(".modal-body #room_id").val("");

                $(".modal-body #url_div").hide();
                $(".modal-body #room_id_div").hide();
                $(".modal-body #user_id_div").hide();

                $(".modal-body #profile-img-tag").attr('src', '{{ asset('assets/icons/picture.png') }}');

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
        })

    });

    $(document).on('click', '.editBtn', function(event) {
        let id = event.currentTarget.value ;
        console.log(id);
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            type:'get',
            url:'/getBanner' + '/' + id,
            dataType: 'json',

            success:function(response){
                console.log(response);
                if(response){
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href,
                        beforeSend: function() {
                            $('#loader').show();
                        },
                        // return the result
                        success: function(result) {
                            $('#createModal').modal("show");
                             var img =  '/../images/Banners/' + response.img ;
                            $(".modal-body #profile-img-tag").attr('src' , img );
                            $(".modal-body #name").val( response.name );
                            $(".modal-body #type").val( response.type );
                            $(".modal-body #order").val(response.order);
                            $(".modal-body #action").val(response.action);
                            $(".modal-body #id").val(response.id);
                            $(".modal-body #url").val(response.url);
                            $(".modal-body #user_id").val(response.user_id);
                            $(".modal-body #room_id").val(response.room_id);

                            switch(response.action){
                            case 0:
                            $('.modal-body #url_div').show();
                            $('.modal-body #user_id_div').hide();
                            $('.modal-body #room_id_div').hide();
                            break;
                            case 1 :
                            $('.modal-body #room_id_div').show();
                            $('.modal-body #url_div').hide();
                            $('.modal-body #user_id_div').hide();
                            break;
                            case 2 :
                            $('.modal-body #user_id_div').show();
                            $('.modal-body #url_div').hide();
                            $('.modal-body #room_id_div').hide();
                            break;
                            case 3 :
                            $('.modal-body #url_div').hide();
                            $('.modal-body #user_id_div').hide();
                            $('.modal-body #room_id_div').hide();
                            break;
                            default:
                            $('.modal-body #url_div').hide();
                            $('.modal-body #user_id_div').hide();
                            $('.modal-body #room_id_div').hide();
                            break;

                            }

                        },
                        complete: function() {
                            $('#loader').hide();
                        },
                        error: function(jqXHR, testStatus, error) {
                            console.log(error);
                            alert("Page " + href + " cannot open. Error:" + error);
                            $('#loader').hide();
                        },
                        timeout: 8000
                    })
                } else {

                }
            }
        });
    });
    $(document).on('click', '.deleteBtn', function(event) {
        id = event.currentTarget.value ;
        console.log(id);
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href,
            beforeSend: function() {
                $('#loader').show();
            },
            // return the result
            success: function(result) {
                $('#deleteModal').modal("show");
            },
            complete: function() {
                $('#loader').hide();
            },
            error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            },
            timeout: 8000
        })
    });
    $(document).on('click', '.btnConfirmDelete', function(event) {

        confirmDelete(id);
    });
    $(document).on('click', '.cancel-modal', function(event) {
        $('#deleteModal').modal("hide");
        console.log()
        id = 0 ;
    });

    function confirmDelete(id){
        let url = "{{ route('deleteBanner', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
