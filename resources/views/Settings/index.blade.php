<!DOCTYPE html>
<html lang="en">

@include('layouts.head', ['pageTitle' => 'Settings'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar', ['slag' => 15, 'subSlag' => 0])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav', ['pageTitle' => __('main.settings')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if (Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.settings') }}</h6>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="col-9" style="display: block ; margin: auto">
                                <form id="roleForm" method="POST" action="{{ route('settingsStore') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">{{ __('main.diamond_to_gold_ratio')
                                            }}:</label>
                                        <input type="number" class="form-control" id="diamond_to_gold_ratio"
                                            name="diamond_to_gold_ratio" required
                                            value="{{$setting  ? $setting -> diamond_to_gold_ratio : 0}}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">{{ __('main.gift_sender_diamond_back')
                                            }}:</label>
                                        <input type="number" class="form-control" id="gift_sender_diamond_back"
                                            name="gift_sender_diamond_back" required
                                            value="{{$setting  ? $setting -> gift_sender_diamond_back : 0}}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">{{
                                            __('main.gift_room_owner_diamond_back') }}:</label>
                                        <input type="number" class="form-control" id="gift_room_owner_diamond_back"
                                            name="gift_room_owner_diamond_back" required
                                            value="{{$setting  ? $setting -> gift_room_owner_diamond_back : 0}}">
                                        <input type="hidden" class="form-control" id="id" name="id"
                                            value="{{$setting  ? $setting -> id : 0}}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="col-form-label">{{
                                            __('main.gift_receiver_diamond_back') }}:</label>
                                        <input type="number" class="form-control" id="gift_receiver_diamond_back"
                                            name="gift_receiver_diamond_back" required
                                            value="{{$setting  ? $setting -> gift_receiver_diamond_back : 0}}">
                                    </div>

                                    <button type="submit" class="btn btn-primary" form="roleForm">{{ __('main.save')
                                        }}</button>





                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.fixedPlugin')

            @include('layouts.footer')

            @include('Roles.create')
            @include('Roles.deleteModal')
            <script type="text/javascript">
                $(document).on('click', '#createButton', function(event) {

                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href,
                        beforeSend: function() {
                            $('#loader').show();
                        },
                        // return the result
                        success: function(result) {
                            $('#createModal').modal("show");
                            $(".modal-body #role").val("");
                            $(".modal-body #description").val("");
                            $(".modal-body #id").val(0);


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

                $(document).on('click', '.editBtn', function(event) {
                    let id = event.currentTarget.value;
                    console.log(id);
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        type: 'get',
                        url: '/getRole' + '/' + id,
                        dataType: 'json',

                        success: function(response) {
                            console.log(response);
                            if (response) {
                                let href = $(this).attr('data-attr');
                                $.ajax({
                                    url: href,
                                    beforeSend: function() {
                                        $('#loader').show();
                                    },
                                    // return the result
                                    success: function(result) {
                                        $('#createModal').modal("show");
                                        $(".modal-body #role").val(response.role);
                                        $(".modal-body #description").val(response.description);
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
                $(document).on('click', '.deleteBtn', function(event) {
                    id = event.currentTarget.value;
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
                    id = 0;
                });

                function confirmDelete(id) {
                    let url = "{{ route('deleteRole', ':id') }}";
                    url = url.replace(':id', id);
                    document.location.href = url;
                }
            </script>
        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>