<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_banner') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="bannerForm" method="POST" action="{{ route('bannerStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">

                    <div class="row">
                        <div class="col-6">
                            <label for="type" class="col-form-label">{{ __('main.type') }}:</label>
                            <select class="form-select" name="type" id="type" required>
                              <option value="0">{{ __('main.banner_home') }}</option>
                              <option value="1">{{ __('main.banner_room') }}</option>
                              <option value="2">{{ __('main.banner_landing') }}</option>
                              <option value="3">{{ __('main.banner_games') }}</option>
                              <option value="4">{{ __('main.banner_event') }}</option>

                            </select>
                            <input type="hidden" class="form-control" id="id" name="id" >
                        </div>
                        <div class="col-6">
                            <label for="name" class="col-form-label">{{ __('main.name') }}:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>

            </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">{{ __('main.img') }}:</label>
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
                <div class="row">
                    <div class="col-6">
                        <label for="order" class="col-form-label">{{ __('main.order') }}:</label>
                        <input type="number" class="form-control" id="order" name="order" required>
                    </div>
                    <div class="col-6">
                        <label for="action" class="col-form-label">{{ __('main.banner_action') }}:</label>
                        <select class="form-select" name="action" id="action" required onchange="actionChange()">
                            <option value=""></option>
                          <option value="0">{{ __('main.banner_action_wv') }}</option>
                          <option value="1">{{ __('main.banner_action_room') }}</option>
                          <option value="2">{{ __('main.banner_action_user') }}</option>
                          <option value="3">{{ __('main.banner_action_img') }}</option>

                        </select>
                    </div>
                </div>

            </div>
            <div class="mb-3" id="url_div">
                <label for="url" class="col-form-label">{{ __('main.banner_action_wv') }}:</label>
                <input type="text" class="form-control" id="url" name="url" >
              </div>
              <div class="mb-3" id="user_id_div">
                <label for="user_id" class="col-form-label">{{ __('main.banner_action_user') }}:</label>
                <input type="text" class="form-control" id="user_id" name="user_id" >
              </div>
              <div class="mb-3" id="room_id_div">
                <label for="room_id" class="col-form-label">{{ __('main.banner_action_room') }}:</label>
                <input type="text" class="form-control" id="room_id" name="room_id" >
              </div>



          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
          <button type="submit" class="btn btn-primary" form="bannerForm">{{ __('main.save') }}</button>
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

    function actionChange(){
       const val = $('#action').val();

       switch(val){
        case "0" :
        console.log(val);
         $('#url_div').show();
         $('#user_id_div').hide();
         $('#room_id_div').hide();
         break;
         case "1" :
         $('#room_id_div').show();
         $('#url_div').hide();
         $('#user_id_div').hide();
         break;
         case "2" :
         $('#user_id_div').show();
         $('#url_div').hide();
         $('#room_id_div').hide();
         break;
         case "3" :
         $('#url_div').hide();
         $('#user_id_div').hide();
         $('#room_id_div').hide();
         break;
         default:
         $('#url_div').hide();
         $('#user_id_div').hide();
         $('#room_id_div').hide();
         break;

       }
    }

    $("#img").change(function () {
        readURL(this);
    });
</script>
