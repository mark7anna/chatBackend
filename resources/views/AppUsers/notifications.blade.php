<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'All Notifications'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 10 , 'subSlag' => 104])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.user_notifications')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.user_notifications') }}</h6>

                            <button class="btn btn-primary" style="margin-left: auto " id="createButton"> <i
                                    class="fa fa-plus" style="margin-right: 10px"></i> Add New</button>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('main.title') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.details') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.img') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.link') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.member') }}</th>


                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($notifications as $notification )
                                        <tr>
                                            <td class="text-center">{{ $notification -> title }}</td>
                                            <td class="text-center">{{ $notification -> message }}</td>
                                            <td class="text-center"> <img
                                                    src="{{ asset('images/Notifications/' . $notification->img) }}"
                                                    width="80" /> </td>
                                            <td class="text-center"> {{ $notification -> link }}</td>
                                            <td class="text-center"> {{ $notification -> type == 1 ?
                                                __('main.allUsers'): __('main.user') }}</td>


                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-danger deleteBtn"
                                                    value="{{ $notification -> id }}"><i
                                                        class="far fa-trash-alt"></i></button>
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

            @include('AppUsers.SendNotifications')
            @include('AppUsers.deleteModal')

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
                        $(".modal-body #title").val("");
                        $(".modal-body #message").val("");
                        $(".modal-body #link").val("");
                        $(".modal-body #role").val("");
                        $(".modal-body #id").val(0);
                        $(".modal-body #type").val("1");
                        $(".modal-body #user_id").val("");
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
        let url = "{{ route('deleteNotification', ':id') }}";
        url = url.replace(':id', id);
        document.location.href=url;
    }

            </script>
        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>