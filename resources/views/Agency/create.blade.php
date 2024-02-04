<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_agency') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="badgeForm" method="POST" action="{{ route('agencyStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="user_id" class="col-form-label">{{ __('main.agent') }}:</label>
                    <input type="text" class="form-control" id="user_id" name="user_id" required>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="col-form-label">{{ __('main.name') }}:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <input type="hidden" class="form-control" id="id" name="id" >
                        </div>
                        <div class="col-6">
                            <label for="tag" class="col-form-label">{{ __('main.tag') }}:</label>
                            <input type="text" class="form-control" id="tag" name="tag" required readonly>
                        </div>
                    </div>

            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="name" class="col-form-label">{{ __('main.gold_target') }}:</label>
                        <input type="number" class="form-control" id="monthly_gold_target" name="monthly_gold_target" required>
                    </div>
                    <div class="col-6">
                        <label for="tag" class="col-form-label">{{ __('main.details') }}:</label>
                         <textarea name="details" id="details"  rows="3" class="form-control"></textarea>
                    </div>
                </div>

        </div>

              <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="active" name="active">
                    <label class="form-check-label" for="active">
                        {{ __('main.agency_state') }}
                    </label>
                  </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="allow_new_joiners" name="allow_new_joiners">
                    <label class="form-check-label" for="allow_new_joiners">
                        {{ __('main.accept_hosters') }}
                    </label>
                  </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="automatic_accept_joiners" name="automatic_accept_joiners">
                    <label class="form-check-label" for="automatic_accept_joiners">
                        {{ __('main.auto_join_accept') }}
                    </label>
                  </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="automatic_accept_exit" name="automatic_accept_exit">
                    <label class="form-check-label" for="automatic_accept_exit">
                        {{ __('main.auto_exit_accept') }}
                    </label>
                  </div>
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
