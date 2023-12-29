
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Levels'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 2 , 'subSlag' => $type + 21])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.levels')])
    <!-- End Navbar -->
    <div class="container-fluid py-4" s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">
                    @if($type == 0)
                    <h6>{{ __('main.levels_share') }}</h6>
                    @elseif($type == 1)
                    <h6>{{ __('main.level_karizma') }}</h6>
                    @else
                    <h6>{{ __('main.level_charge') }}</h6>
                    @endif

                    <button class="btn btn-primary" style="margin-left: auto " id="createButton" > <i class="fa fa-plus" style="margin-right: 10px"></i>  Add New</button>

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.order') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.icon') }}</th>
                          @if($type == 0)
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.share_val') }}</th>
                          @elseif($type == 1)
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.karizma_val') }}</th>
                          @else
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.charging_val') }}</th>
                          @endif
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.level_frame') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.level_enter') }}</th>

                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($levels as $level )
                        <tr>
                          <td  class="text-center"> {{ $level -> order }}</td>
                          <td class="text-center"> <img src="{{ asset('images/Levels/' . $level->icon) }}" width="80"/>  </td>
                          <td>
                            <span class="text-xs font-weight-bold">{{ $level -> points }}</span>
                          </td>
                          <td class="align-middle text-center"> No Frame </td>
                          <td class="align-middle text-center"> No Enter </td>
                          <td class="align-middle text-center">
                            <button type="button" class="btn btn-success editBtn" value="{{ $level -> id }}"><i class="fas fa-edit"></i></button>
                          <button type="button" class="btn btn-danger deleteBtn" value="{{ $level -> id }}"><i class="far fa-trash-alt"></i></button>
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
      <input type="hidden" value="{{ $type }}" id="type" name="type"/>
      @include('layouts.fixedPlugin')

      @include('layouts.footer')

      @include('Levels.create')
      @include('Levels.deleteModal')
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
                $(".modal-body #order").val("");
                $(".modal-body #points").val("");
                $(".modal-body #frame_id").val(0);
                $(".modal-body #enter_id").val(0);
                $(".modal-body #id").val(0);
                $(".modal-body #type").val($("#type").val());
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
            url:'/getLevel' + '/' + id,
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
                             var img =  '/../images/Levels/' + response.icon ;
                            $(".modal-body #profile-img-tag").attr('src' , img );
                            $(".modal-body #order").val( response.order );
                            $(".modal-body #points").val( response.points );
                            $(".modal-body #frame_id").val(response.frame_id);
                            $(".modal-body #enter_id").val(response.enter_id);
                            $(".modal-body #id").val(response.id);
                            $(".modal-body #type").val(response.type);
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
        let url = "{{ route('deleteLevel', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
