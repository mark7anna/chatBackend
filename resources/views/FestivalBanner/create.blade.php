<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_Festival_banner') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="countryForm" method="POST" action="{{ route('festivalBannerStore') }}" enctype="multipart/form-data">
                @csrf
            <div class="mb-3">
                    <label for="title" class="col-form-label">{{ __('main.title') }}:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                    <input type="hidden" class="form-control" id="id" name="id" >
            </div>
            <div class="mb-3">
                <label for="type" class="col-form-label">{{ __('main.event_type') }}:</label>
                 <select name="type" id="type" class="form-select">
                    <option value="0"> {{ __('main.party_type1') }} </option>
                    <option value="1"> {{ __('main.party_type2') }} </option>
                    <option value="2"> {{ __('main.party_type3') }} </option>
                    <option value="3"> {{ __('main.party_type4') }} </option>

                 </select>
            </div>
            <div class="mb-3">
                <label for="description" class="col-form-label">{{ __('main.details') }}:</label>
                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label for="points" class="col-form-label">{{ __('main.img') }}:</label>
                <div class="row" style="display: flex;
                align-items: center;">
                    <div class="col-6">
                        <div class="custom-file">

                                   <input class="form-control" type="file" id="img" name="img"
                                   accept="*">
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag" width="80px"
                              class="profile-img"/>
                    </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="room_id" class="col-form-label">{{ __('main.room') }}:</label>
                <input type="text" class="form-control" id="room_id" name="room_id" required>
             </div>

              <div class="mb-3">
                        <label for="start_date" class="col-form-label">{{ __('main.start_date') }}:</label>
                        <input type="datetime" class="form-control" id="start_date" name="start_date" required
                        value="{{\Carbon\Carbon::now()}}" >
              </div>

              <div class="mb-3">
                <label for="duration_in_hour" class="col-form-label">{{ __('main.duration') }}:</label>
                <input type="number" class="form-control" id="duration_in_hour" name="duration_in_hour" required>
             </div>

             <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="title" class="col-form-label">{{ __('main.accepted') }}:</label>
                        <select name="accepted" id="accepted" class="form-select">
                           <option value="0"> {{ __('main.refused') }} </option>
                           <option value="1"> {{ __('main.accepted') }} </option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="enable" class="col-form-label">{{ __('main.enable') }}:</label>
                        <select name="enable" id="enable" class="form-select">
                           <option value="0"> {{ __('main.disabled') }} </option>
                           <option value="1"> {{ __('main.enabled') }} </option>
                        </select>
                    </div>
                </div>

            </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
          <button type="submit" class="btn btn-primary" form="countryForm">{{ __('main.save') }}</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

  <script type="text/javascript">
   $( document ).ready(function() {

});
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
</script>
