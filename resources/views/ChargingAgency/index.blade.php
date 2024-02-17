<!DOCTYPE html>
<html lang="en">

@include('layouts.head', ['pageTitle' => 'Charging Agency'])

<body class="g-sidenav-show  bg-gray-100">
    @include('layouts.sidebar', ['slag' => 17, 'subSlag' => 171])
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.nav', ['pageTitle' => __('main.charging_agency')])
        <!-- End Navbar -->
        <div class="container-fluid py-4" @if (Config::get('app.locale') == 'ar') style="direction: rtl" @endif s>
            <div class="row">
                <div class="col-12">
                    @include('flash-message')
                    <div class="card mb-4">
                        <div class="card-header pb-0"
                            style="display: flex;
                justify-content: left;
                align-items: center;">

                            <h6>{{ __('main.charging_agency') }}</h6>

                            <button class="btn btn-primary"
                                @if (Config::get('app.locale') == 'ar') style="margin-right: auto "
                            @else style="margin-left: auto " @endif
                                id="createButton"> <i class="fa fa-plus" style="margin-right: 10px"></i> Add
                                New</button>

                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead>
                                        <tr>

                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ __('main.name') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.agent') }}</th>
                                            <th
                                                class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                {{ __('main.agency_state') }}</th>


                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($agencies as $agency)
                                            <tr>
                                                <td class="text-center"> {{ $agency->name }}</td>
                                                <td class="text-center"> {{ $agency->user_name }}</td>
                                                <td class="text-center">
                                                    @if ($agency->active == 1)
                                                        <span class="badge badge-success">{{ __('main.active') }}</span>
                                                    @else
                                                        <span
                                                            class="badge badge-danger">{{ __('main.inActive') }}</span>
                                                    @endif

                                                </td>

                                                <td class="text-center">
                                                    <button type="button" class="btn btn-success editBtn"
                                                        value="{{ $agency->id }}"><i class="fas fa-edit"></i></button>
                                                    <button type="button" class="btn btn-danger deleteBtn"
                                                        value="{{ $agency->id }}"><i
                                                            class="far fa-trash-alt"></i></button>
                                                    <br>
                                                    <button type="button" class="btn btn-info chargeBtn"
                                                        value="{{ $agency->id }}">{{ __('main.charging_agency_balance') }}</button>

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
            @include('ChargingAgency.create')
            @include('ChargingAgency.deleteModal')
            @include('ChargingAgency.chargeBalance')
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
                            $(".modal-body #name").val("");
                            $(".modal-body #user_id").val("");
                            $(".modal-body #notes").val("");
                            $(".modal-body #active").prop("checked", false);
              
                            $(".modal-body #id").val(0);
                            $(".modal-body #user_id").prop("readonly", false);
                        

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
                        url: '/getChargingAgency' + '/' + id,
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

                                        // var img =  response.icon ;
                                        $(".modal-body #name").val(response.name);
                                        $(".modal-body #user_id").val(response.user_tag);
                             
                                        $(".modal-body #notes").val(response.notes);
                                        $(".modal-body #active").prop("checked", response.active ==
                                            1);
                                
                                        $(".modal-body #id").val(response.id);
                                        $(".modal-body #user_id").prop("readonly", true);

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
                $(document).on('click', '.chargeBtn', function(event) {
                    let id = event.currentTarget.value;
                    console.log(id);
                    event.preventDefault();
                    let href = $(this).attr('data-attr');
                    $.ajax({
                        type: 'get',
                        url: '/getchargingBalance' + '/' + id,
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
                                        $('#chargeModal').modal("show");

                                        // var img =  response.icon ;
                                        $(".modal-body #name").val(response.name);
                                        $(".modal-body #id").val(response.id);
                                        $(".modal-body #current_balance").val(response.current_balance);
                             
                                        $(".modal-body #charging_value").val(0);

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
                    let url = "{{ route('deletechargingAgency', ':id') }}";
                    url = url.replace(':id', id);
                    document.location.href = url;
                }
            </script>
        </div>
    </main>

    <!--   Core JS Files   -->


</body>

</html>
