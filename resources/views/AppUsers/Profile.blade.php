<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @else
            style="direction: ltr" @endif>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('main.user_profile') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"><img alt="image"
                                id="userImg" width="80px" height="80px" style="border-radius: 50%">
                            <div class="position-absolute translate-middle bottom-0 start-100  bg-danger rounded-circle border border-4 border-white h-20px w-20px"
                                style="min-width: 20px; min-height: 20px" id="offline">

                            </div>
                            <div class="position-absolute translate-middle bottom-0 start-100 bg-success rounded-circle border border-4 border-white h-20px w-20px"
                                style="min-width: 20px; min-height: 20px; background: green" id="online">

                            </div>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2"><a href=""
                                        class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1" id="userName">

                                    </a></div>
                                <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2"><a href="#"
                                        class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2"><i
                                            class="fa fa-paper"></i> <span id="userTag" class="badge badge-dark"
                                            style="font-size: 15px;">

                                        </span></a></div>
                            </div>
                            <div class="d-flex my-4"><button class="btn btn-sm btn-info me-3">
                                    ليس بداخل غرفة
                                </button> <a href="#" class="btn btn-sm btn-danger me-3"><i aria-hidden="true"
                                        class="fa fa-refresh"></i>
                                    تسجيل الخروج
                                </a></div>
                        </div>
                        <div class="row">
                            <div class="col-8 d-flex flex-column ">
                                <div class="d-flex flex-wrap">
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700" id="diamond">0</div>
                                        <div class="fw-bold text-gray-400">{{ __('main.diamond') }}</div>
                                    </div>
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700" id="gold">0</div>
                                        <div class="fw-bold text-gray-400">{{ __('main.gold') }}</div>
                                    </div>
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700"><span class="badge badge-danger"
                                                id="charge_agent"></span></div>
                                        <div class="fw-bold text-gray-400">{{ __('main.charge_agent') }}</div>
                                    </div>
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-80px py-3 px-4 mx-2 mb-3">
                                        <div class="fs-6 fw-bolder text-gray-700"><span class="badge badge-danger"
                                                id="host_agent"></span></div>
                                        <div class="fw-bold text-gray-400"> {{ __('main.host_agent') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center col-4" style="flex-direction: column">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2"><span
                                        class="fw-bold fs-9[px] text-gray-400"> {{ __('main.register_date')
                                        }}</span> <span class="fw-bolder fs-11[px]" id="register_date">

                                    </span></div>
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2"><span
                                        class="fw-bold fs-6 text-gray-400">{{ __('main.last_login') }}</span> <span
                                        class="fw-bolder fs-6" id="last_login"></span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">{{ __('main.general_info') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="level-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                            type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">{{
                            __('main.level') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                            aria-selected="false">Contact</button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                        aria-labelledby="general-tab" tabindex="0">
                        @include('AppUsers.GeneralInfo')
                    </div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="level-tab"
                        tabindex="0">
                        @include('AppUsers.level')
                    </div>
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                        tabindex="0">...</div>
                    <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                        tabindex="0">...</div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);

        }
    }
    $("#img").change(function () {
        readURL(this);
    });

   function TypeChange(){
    const val = $('#type').val();
     if(val == 2){
        $('#user_id_div').show();
     } else {
        $('#user_id_div').hide();
     }
   }
  
</script>