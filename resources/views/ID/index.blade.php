
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'UID'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 7 , 'subSlag' => 76])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.uid')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                    <h6>{{ __('main.uid') }}</h6>


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
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.uid') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.price') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.available') }}</th>


                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($ids as $uid )
                        <tr>
                          <td  class="text-center"> {{ $uid -> uid }}</td>
                          <td class="text-center"> <img src="{{ asset('images/UID/' . $uid->img) }}" width="80"/>  </td>
                          <td  class="text-center"> {{ $uid -> price }}</td>
                          <td class="text-center">
                             <input type="checkbox" class="form-check"  onclick="return false;" style="display: block ; margin:auto"  @if($uid -> isAvailable == 1 ) checked  @endif/>
                          </td>

                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $uid -> id }}"><i class="fas fa-edit"></i></button>
                          <button type="button" class="btn btn-danger deleteBtn" value="{{ $uid -> id }}"><i class="far fa-trash-alt"></i></button>
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

      @include('ID.create')
      @include('ID.deleteModal')
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
                $(".modal-body #uid").val("");
                $(".modal-body #price").val("");
                $(".modal-body #id").val(0);
                $(".modal-body #isAvailable").prop( "checked", false );
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
            url:'/getSpecialUID' + '/' + id,
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
                             var img =  '/../images/UID/' + response.img ;
                            $(".modal-body #profile-img-tag").attr('src' , img );
                            $(".modal-body #uid").val( response.uid );
                            $(".modal-body #price").val( response.price );
                            $(".modal-body #id").val(response.id);
                            $(".modal-body #isAvailable").prop( "checked", response.isAvailable == 1 );
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
        let url = "{{ route('deleteSpecialUID', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
