<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.view_post') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="mb-3">
                    <label for="name" class="col-form-label">{{ __('main.content') }}:</label>
                    <textarea name="content" id="content"  rows="4" readonly class="form-control"></textarea>
                    <input type="hidden" class="form-control" id="id" name="id" >
            </div>
            <div class="mb-3">
                        <label for="user_id" class="col-form-label">{{ __('main.user') }}:</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" readonly>
            </div>

            <div class="mb-3">
                <div class="col-6 text-right">
                    <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag"
                          class="profile-img" width="100"/>
                </div>
              </div>
              <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <select name="auth" id="auth" disabled class="form-select">
                            <option value="0">{{ __('main.public') }}</option>
                            <option value="1">{{ __('main.friends_only') }}</option>
                            <option value="2">{{ __('main.only_me') }}</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="accepted" id="accepted" disabled class="form-select">
                            <option value="0">{{ __('main.refused') }}</option>
                            <option value="1"><{{ __('main.accepted') }}</option>
                        </select>
                    </div>
                </div>

              </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
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
