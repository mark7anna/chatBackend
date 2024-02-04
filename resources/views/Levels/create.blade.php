<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_level') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="levelForm" method="POST" action="{{ route('levelStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
              <label for="order" class="col-form-label">{{ __('main.order') }}:</label>
              <input type="text" class="form-control" id="order" name="order" required>
              <input type="hidden" class="form-control" id="id" name="id" >
              <input type="hidden" class="form-control" id="type" name="type" >
            </div>
            <div class="mb-3">
              <label for="points" class="col-form-label">{{ __('main.points') }}:</label>
              <input type="text" class="form-control" id="points" name="points" required>
            </div>
            <div class="mb-3">
                <label for="points" class="col-form-label">{{ __('main.icon') }}:</label>
                <div class="row" style="display: flex;
                align-items: center;">
                    <div class="col-6">
                        <div class="custom-file">

                                   <input class="form-control" type="file" id="icon" name="icon"
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
                <div class="row">
                    <div class="col-6">
                        <label for="frame_id" class="col-form-label">{{ __('main.level_frame') }}:</label>
                         <select class="form-select" id="frame_id" name="frame_id" style="direction: ltr">
                            <option value="0">No Frame</option>
                         </select>
                    </div>
                    <div class="col-6">
                        <label for="enter_id" class="col-form-label">{{ __('main.level_enter') }}:</label>
                        <select class="form-select" id="enter_id" name="enter_id" style="direction: ltr">
                            <option value="0">No Enter</option>
                         </select>
                    </div>
                </div>

              </div>

          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
          <button type="submit" class="btn btn-primary" form="levelForm">{{ __('main.save') }}</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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


    $("#icon").change(function () {
        readURL(this);
    });
</script>
