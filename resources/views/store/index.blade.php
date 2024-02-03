
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Designs Store'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 7 , 'subSlag' => 73])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.designs')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">
                    <h6>{{ __('main.designs') }}</h6>
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
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.tag') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.category') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.type') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.order') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.behaviour') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.fixed_icon') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.price') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.day_count') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.is_store') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.subject') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.vip') }}</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($designs as $design )
                        <tr>
                          <td  class="text-center"> {{ $design -> name }}</td>
                          <td  class="text-center"> {{ $design -> tag }}</td>
                          <td  class="text-center"> {{ $design -> gift_category_name ?? "--" }}</td>
                          <td  class="text-center"> {{ $design -> category_name  ?? "--"}}</td>
                          <td  class="text-center"> {{ $design -> order }}</td>
                          <td  class="text-center"> {{ $design -> behaviour == 0 ? __('main.behaviour1') : __('main.behaviour2') }}</td>

                          <td class="text-center"> <img src="{{ asset('images/Designs/' . $design->icon) }}" width="80"/>  </td>
                          <td class="text-center">
                            <span class="text-xs font-weight-bold">{{ $design -> price }}</span>
                          </td>
                          <td class="align-middle text-center"> {{ $design -> days }} </td>
                          <td class="align-middle text-center">
                            <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($design -> is_store == 1 ) checked  @endif/>

                        </td>
                        <td  class="text-center">
                            @if($design -> subject == 0)
                               ---
                            @elseif($design -> subject == 1)
                              {{ __('main.subject1') }}
                              @elseif ($design -> subject == 2)
                              {{ __('main.subject2') }}
                              @else
                              {{ __('main.subject3') }}

                            @endif


                            </td>
                        <td  class="text-center"> {{ $design -> vip_tag }}</td>
                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $design -> id }}"><i class="fas fa-edit"></i></button>
                          <button type="button" class="btn btn-danger deleteBtn" value="{{ $design -> id }}"><i class="far fa-trash-alt"></i></button>
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

      @include('store.create')
      @include('store.deleteModal')
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
                $(".modal-body #is_store").prop( "checked", false );
                $(".modal-body #name").val("");
                $(".modal-body #tag").val("");
                $(".modal-body #order").val("");
                $(".modal-body #category_id").val(0);
                $(".modal-body #gift_category_id").val(0);
                $(".modal-body #price").val("");
                $(".modal-body #days").val("");
                $(".modal-body #behaviour").val("");
                $(".modal-body #subject").val("");
                $(".modal-body #vip_id").val("");
                $(".modal-body #id").val(0);
                $(".modal-body #profile-img-tag").attr('src', '{{ asset('assets/icons/picture.png') }}');
                $(".modal-body #profile-img-tag2").attr('src', '{{ asset('assets/icons/picture.png') }}');

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
            url:'/getDesign' + '/' + id,
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

                             var img =  '/../images/Designs/' + response.icon ;
                             var img3 =  '/../images/Designs/' + response.dark_icon ;
                            $(".modal-body #profile-img-tag").attr('src' ,  img );
                            $(".modal-body #profile-img-tag2").attr('src' , response.dark_icon ? img3 :  '{{ asset('assets/icons/picture.png') }}');
                            $(".modal-body #name").val( response.name );
                            $(".modal-body #tag").val( response.tag );
                            $(".modal-body #category_id").val(response.category_id);
                            $(".modal-body #gift_category_id").val(response.gift_category_id);
                            $(".modal-body #id").val(response.id);
                            $(".modal-body #price").val(response.price);
                            $(".modal-body #days").val(response.days);
                            $(".modal-body #order").val(response.order);
                            $(".modal-body #behaviour").val(response.behaviour);
                            $(".modal-body #subject").val(response.subject);
                            $(".modal-body #vip_id").val(response.vip_id);
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
        let url = "{{ route('deleteDesign', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
