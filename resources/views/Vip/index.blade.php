
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'VIP'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 6 , 'subSlag' => 0])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.vip')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">
                    <h6>{{ __('main.vip') }}</h6>


                    {{-- <button class="btn btn-primary" @if(Config::get('app.locale')=='ar' )
style="margin-right: auto "
@else style="margin-left: auto "
@endif
id="createButton" > <i class="fa fa-plus" style="margin-right: 10px"></i>  Add New</button> --}}

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.name') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.tag') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.motion_img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.price') }}</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($vips as $vip )
                        <tr>
                          <td  class="text-center"> {{ $vip -> name }}</td>
                          <td  class="text-center"> {{ $vip -> tag }}</td>
                          <td class="text-center">  @if($vip->icon)
                            <img src="{{ asset('images/VIP/' . $vip->icon) }}" width="80"/>
                          @endif </td>
                          <td class="text-center"> @if ($vip->motion_icon)
                            <img src="{{ asset('images/VIPMotion/' . $vip->motion_icon) }}" width="80"/>
                          @endif </td>
                          <td class="text-center">
                            <span class="text-xs font-weight-bold">{{ $vip -> price }}</span>
                          </td>

                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $vip -> id }}"><i class="fas fa-edit"></i></button>
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

      @include('Vip.create')
      <script type="text/javascript">

    $(document).on('click', '.editBtn', function(event) {
        let id = event.currentTarget.value ;
        console.log(id);
        event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            type:'get',
            url:'/getVip' + '/' + id,
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

                            // var img =  response.icon ;
                             var img =  '/../images/VIP/' + response.icon ;
                             var img2 =  '/../images/VIPMotion/' + response.motion_icon ;
                            $(".modal-body #profile-img-tag").attr('src' , response.icon ? img : '{{ asset('assets/icons/picture.png') }}'  );
                            $(".modal-body #profile-img-tag2").attr('src' , response.motion_icon ? img2 : '{{ asset('assets/icons/picture.png') }}' );
                            $(".modal-body #name").val( response.name );
                            $(".modal-body #tag").val( response.tag );
                            $(".modal-body #price").val(response.price);
                            $(".modal-body #id").val(response.id);
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
      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
