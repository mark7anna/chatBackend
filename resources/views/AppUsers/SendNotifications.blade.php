<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @else
            style="direction: ltr" @endif>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_notification') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="myForm" method="POST" action="{{ route('sendNotification') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="col-form-label">{{ __('main.title') }}:</label>
                        <input type="text" class="form-control" id="title" name="title" required>

                    </div>
                    <div class="mb-3">
                        <label for="message" class="col-form-label">{{ __('main.details') }}:</label>
                        <input type="text" class="form-control" id="message" name="message" required>

                    </div>
                    <div class="mb-3">
                        <label for="link" class="col-form-label">{{ __('main.link') }}:</label>
                        <input type="text" class="form-control" id="link" name="link">

                    </div>
                    <div class="mb-3">
                        <label for="points" class="col-form-label">{{ __('main.img') }}:</label>
                        <div class="row" style="display: flex;
                        align-items: center;">
                            <div class="col-6">
                                <div class="custom-file">

                                    <input class="form-control" type="file" id="img" name="img" accept="*">
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag" width="80px"
                                    class="profile-img" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="col-form-label">{{ __('main.public') }}:</label>
                        <select name="type" id="type" class="form-select" onchange="TypeChange()" required>
                            <option value="1">{{ __('main.allUsers') }}</option>
                            <option value="2">{{ __('main.member') }}</option>
                        </select>

                    </div>
                    <div class="mb-3" style="display: none ;" id="user_id_div">
                        <label for="user_id" class="col-form-label">{{ __('main.user_tag') }}:</label>
                        <input type="text" class="form-control" id="user_id" name="user_id">

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
                <button type="submit" class="btn btn-primary" form="myForm">{{ __('main.save') }}</button>
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