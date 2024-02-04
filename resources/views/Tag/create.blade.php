<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_tag') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="badgeForm" method="POST" action="{{ route('tagStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
              <label for="order" class="col-form-label">{{ __('main.name') }}:</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <input type="hidden" class="form-control" id="id" name="id" >
            </div>

            <div class="mb-3">
                <label for="type" class="col-form-label">{{ __('main.type') }}:</label>
                <select name="type" id="type" class="form-select">
                    <option value="1">{{ __('main.tag1') }}</option>
                    <option value="2">{{ __('main.tag2') }}</option>
                </select>
              </div>


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
          <button type="submit" class="btn btn-primary" form="badgeForm">{{ __('main.save') }}</button>
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
