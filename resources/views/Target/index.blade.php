<!DOCTYPE html>
<html lang="en">

@include('layouts.head' , ['pageTitle' => 'Targets'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar' , ['slag' => 16 , 'subSlag' => 161])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav' , ['pageTitle' => __('main.targets')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0" style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.targets') }}</h6>


                            <button class="btn btn-primary" @if(Config::get('app.locale')=='ar' ) style="margin-right: auto " @else style="margin-left: auto " @endif id="createButton"> <i class="fa fa-plus" style="margin-right: 10px"></i> Add New</button>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">{{ __('main.order') }}</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.img') }}</th>

                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.points') }}</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.amount') }}</th>
                                            <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('main.agent_amount') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($targets as $target )
                                        <tr>
                                            <td class="text-center"> {{ $target -> order }}</td>
                                            <td class="text-center"> <img src="{{ asset('images/Target/' . $target->icon) }}" width="80" /> </td>
                                            <td class="align-middle text-center"> {{ $target -> gold }} </td>
                                            <td class="align-middle text-center"> {{ $target -> dollar_amount }} </td>
                                            <td class="align-middle text-center"> {{ $target -> agent_amount }} </td>
                                            <td class="align-middle text-center">
                                                <button type="button" class="btn btn-success editBtn" value="{{ $target -> id }}"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger deleteBtn" value="{{ $target -> id }}"><i class="far fa-trash-alt"></i></button>
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

            @include('Target.create')
            @include('Target.deleteModal')
            <script type="text/javascript">
                $(document).on('click', '#createButton', function(event) {

                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        url: href
                        , beforeSend: function() {
                            $('#loader').show();
                        },
                        // return the result
                        success: function(result) {
                            $('#createModal').modal("show");
                            $(".modal-body #order").val("");
                            $(".modal-body #gold").val("");
                            $(".modal-body #dollar_amount").val("");
                            $(".modal-body #agent_amount").val("");
                            $(".modal-body #id").val(0);

                            $(".modal-body #profile-img-tag").attr('src', '{{ asset('assets/icons/picture.png') }}');

                        }
                        , complete: function() {
                            $('#loader').hide();
                        }
                        , error: function(jqXHR, testStatus, error) {
                            console.log(error);
                            alert("Page " + href + " cannot open. Error:" + error);
                            $('#loader').hide();
                        }
                        , timeout: 8000
                    })

                });

                $(document).on('click', '.editBtn', function(event) {
                    let id = event.currentTarget.value;
                    console.log(id);
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        type: 'get'
                        , url: '/getTarget' + '/' + id
                        , dataType: 'json',

                        success: function(response) {
                            console.log(response);
                            if (response) {
                                let href = $(this).attr('data-attr');
                                $.ajax({
                                    url: href
                                    , beforeSend: function() {
                                        $('#loader').show();
                                    },
                                    // return the result
                                    success: function(result) {
                                        $('#createModal').modal("show");
                                        var img = '/../images/Target/' + response.icon;
                                        $(".modal-body #profile-img-tag").attr('src', img);
                                        $(".modal-body #order").val(response.order);
                                        $(".modal-body #gold").val(response.gold);
                                        $(".modal-body #dollar_amount").val(response.dollar_amount);
                                        $(".modal-body #agent_amount").val(response.agent_amount);
                                        $(".modal-body #id").val(response.id);

                                    }
                                    , complete: function() {
                                        $('#loader').hide();
                                    }
                                    , error: function(jqXHR, testStatus, error) {
                                        console.log(error);
                                        alert("Page " + href + " cannot open. Error:" + error);
                                        $('#loader').hide();
                                    }
                                    , timeout: 8000
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
                        url: href
                        , beforeSend: function() {
                            $('#loader').show();
                        },
                        // return the result
                        success: function(result) {
                            $('#deleteModal').modal("show");
                        }
                        , complete: function() {
                            $('#loader').hide();
                        }
                        , error: function(jqXHR, testStatus, error) {
                            console.log(error);
                            alert("Page " + href + " cannot open. Error:" + error);
                            $('#loader').hide();
                        }
                        , timeout: 8000
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
                    let url = "{{ route('deleteTarget', ':id') }}";
                    url = url.replace(':id', id);
                    document.location.href = url;
                }

            </script>
        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>
