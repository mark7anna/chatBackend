
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Festival Banners'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 12 , 'subSlag' => 0 ])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.fesival_banners')])
    <!-- End Navbar -->
    <div class="container-fluid py-4" s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">
                    <h6>{{ __('main.fesival_banners') }}</h6>

                    <button class="btn btn-primary" style="margin-left: auto " id="createButton"> <i class="fa fa-plus"
                        style="margin-right: 10px"></i> Add New</button>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.title') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.room') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.event_type') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.start_date') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.duration') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.enable') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.accepted') }}</th>


                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($banners as $banner )
                        <tr>
                          <td  class="text-center"> {{ $banners -> title }}</td>
                          <td  class="text-center"> {{ $banners -> room_name }}</td>
                          <td  class="text-center">
                            @if($banners -> type == 0)
                               {{ __('main.party_type1') }}
                               @elseif($banner -> type == 1)
                               {{ __('main.party_type2') }}
                               @elseif($banner -> type == 2)
                               {{ __('main.party_type3') }}
                               @elseif($banner -> type == 3)
                               {{ __('main.party_type4') }}
                            @endif


                        </td>
                          <td class="text-center"> <img src="{{ asset('images/FestivalBanner/' . $banners->img) }}" width="80"/>  </td>
                          <td  class="text-center"> {{ $banner -> start_date }}</td>
                          <td  class="text-center"> {{ $banner -> duration_in_hour }}</td>
                          <td class="text-center">
                            <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($banner -> enable == 1 ) checked  @endif/>
                         </td>
                         <td class="text-center">
                            <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($banner -> accepted == 1 ) checked  @endif/>
                         </td>

                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $banner -> id }}"><i class="fas fa-edit"></i></button>
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

       @include('FestivalBanner.create')
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
                $(".modal-body #name").val("");
                $(".modal-body #code").val("");
                $(".modal-body #order").val("");
                $(".modal-body #dial_code").val("");
                $(".modal-body #id").val(0);
                $(".modal-body #enable").prop( "checked", false );
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

        </script>

    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
