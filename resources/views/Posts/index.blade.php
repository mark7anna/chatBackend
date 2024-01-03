
<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Posts'])

<body class="g-sidenav-show  bg-gray-100" >
  @include('layouts.sidebar' , ['slag' => 15 , 'subSlag' => 0])
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
  @include('layouts.nav' , ['pageTitle' => __('main.posts')])
    <!-- End Navbar -->
    <div class="container-fluid py-4"  @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
        <div class="row">
            <div class="col-12">
                @include('flash-message')
              <div class="card mb-4">
                <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                    <h6>{{ __('main.posts') }}</h6>


                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.content') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.user') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.auth') }}</th>
                          <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.accepted') }}</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($posts as $post )
                        <tr>
                          <td  class="text-center"> {{ $post -> content }}</td>
                          <td  class="text-center"> {{ $post -> user_name }}</td>
                          @if($post->img)
                          <td class="text-center"> <img src="{{ asset('images/Posts/' . $post->img) }}" width="80"/>  </td>
                           @else
                           <td class="text-center">NO IMAGE</td>
                          @endif
                          <td class="text-center">
                            @if($post -> auth == 0)
                            <span class="text-xs font-weight-bold">{{ __('main.public') }}</span>
                            @elseif($post -> auth == 1)
                            <span class="text-xs font-weight-bold">{{ __('main.friends_only') }}</span>
                            @elseif($post -> auth == 2)
                            <span class="text-xs font-weight-bold">{{ __('main.only_me') }}</span>
                            @endif
                          </td>
                          <td class="text-center">
                            @if($post -> accepted == 1)
                            <span class="text-xs font-weight-bold">{{ __('main.accepte') }}</span>
                              @else
                              <span class="text-xs font-weight-bold">{{ __('main.refused') }}</span>
                              @endif
                          </td>
                          <td class="align-middle text-center">
                          <button type="button" class="btn btn-danger deleteBtn" value="{{ $post -> id }}"><i class="far fa-trash-alt"></i></button>
                          <button type="button" class="btn btn-info editBtn" value="{{ $post -> id }}"><i class="far fa-eye"></i></button>
                          <a type="button" class="btn btn-primary "  href="{{ route('acceptPost' , $post -> id) }}"><i class="fa fa-check"></i></a>
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

      @include('Posts.create')
      @include('Posts.deleteModal')
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
                $(".modal-body #content").val("");
                $(".modal-body #user_id").val("");
                $(".modal-body #auth").val("");
                $(".modal-body #accepted").val("");
                $(".modal-body #id").val(0);
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
            url:'/getPost' + '/' + id,
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
                             var img =  '/../images/Posts/' + response[0].img ;
                            $(".modal-body #profile-img-tag").attr('src' ,response[0].img ?  img : '{{ asset('assets/icons/picture.png') }}' );
                            $(".modal-body #content").val( response[0].content );
                            $(".modal-body #user_id").val( response[0].user_name );
                            $(".modal-body #auth").val(response[0].auth);
                            $(".modal-body #accepted").val(response[0].accepted);
                            $(".modal-body #id").val(response[0].id);


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
        let url = "{{ route('deletePost', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

      </script>
    </div>
  </main>

  <!--   Core JS Files   -->


</body>

</html>
