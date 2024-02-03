<div class="card">
    <form id="countryForm" method="POST" action="{{ route('updateAppUser') }}" enctype="multipart/form-data">
        @csrf
        <div class="row alert">
            <div class="col-md-6">
                <ul class="list-group" style="list-style-type: none;">
                    <li class="mb-2">
                        <div class="form-group"><label><small style="font-size: 11px;">{{ __('main.name') }}</small>
                            </label>
                            <input type="text" class="form-control" style="padding: 3px;" id="name" name="name">
                            <input type="hidden" id="USERID" name="USERID">
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label>
                                {{ __('main.tag') }}
                            </label>
                            <input type="text" class="form-control" style="padding: 3px;" id="tag" name="tag">
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label>macAddress
                                {{ __('main.email') }}
                            </label>
                            <input type="text" readonly="readonly" class="form-control" style="padding: 3px;" id="email"
                                name="email">
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label>
                                {{ __('main.birth_date') }}
                            </label>
                            <input type="text" class="form-control" style="padding: 3px;" id="birth_date"
                                name="birth_date" disabled>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label>
                                {{ __('main.hoppies') }}
                            </label>
                            <input disabled="disabled" class="form-control" style="padding: 3px;" id="hoppies"
                                name="hoppies">
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group" style="list-style-type: none;">
                    <li class="mb-2">
                        <div class="form-group">
                            <!---->
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label><small style="font-size: 11px;">DeviceToken</small> </label>
                            <input type="text" disabled="disabled" class="form-control form-control-solid"
                                style="padding: 3px;" id="macAddress" name="macAddress">
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label><small style="font-size: 11px;">DeviceID</small> </label>
                            <input type="text" disabled="disabled" class="form-control form-control-solid"
                                style="padding: 3px;" id="deviceId" name="deviceId">
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="form-group"><label><small style="font-size: 11px;"> {{ __('main.password')
                                    }}</small>
                            </label>
                            <input type="password" class="form-control form-control-solid" style="padding: 3px;"
                                id="password" name="password" disabled="disabled">
                        </div>
                    </li>
                    <li class="mb-2"><small style="font-size: 11px;"> {{ __('main.img') }} </small> <input
                            data-v-32c7e3bf="" type="file" enctype="multipart/form-data" class="form-control"></li>
                </ul>
            </div>

            <div class="col-md-12">
                <div class="form-group mt-5"><button class="btn btn-sm btn-primary" type="submit"><i
                            class="fa fa-edit"></i>
                        {{ __('main.update') }}
                    </button></div>
            </div>
        </div>
    </form>

</div>