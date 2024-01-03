<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_emotion') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="countryForm" method="POST" action="{{ route('emotionStore') }}" enctype="multipart/form-data">
                @csrf

             <input type="hidden" id="id" name="id">
            <div class="mb-3">
                <label for="points" class="col-form-label">{{ __('main.motion_img') }}:</label>
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
                <label for="points" class="col-form-label">{{ __('main.fixed_icon') }}:</label>
                <div class="row" style="display: flex;
                align-items: center;">
                    <div class="col-6">
                        <div class="custom-file">

                                   <input class="form-control" type="file" id="icon" name="icon"
                                   accept="*">
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag2" width="80px"
                              class="profile-img"/>
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

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-img-tag2').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);

        }
    }
    $("#img").change(function () {
        readURL(this);
    });
    $("#icon").change(function () {
        readURL2(this);
    });
</script>
