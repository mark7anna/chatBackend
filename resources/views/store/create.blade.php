<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_design') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="levelForm" method="POST" action="{{ route('designStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_store" name="is_store">
                        <label class="form-check-label" for="is_store">
                            {{ __('main.is_store') }}
                        </label>
                      </div>
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
                        <input type="text" class="form-control" id="tag" name="tag" required>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="category_id" class="col-form-label">{{ __('main.type') }}:</label>
                        <select name="category_id" id="category_id" class="form-select" style="direction: ltr" required>
                            @foreach ($cats as $cat )
                             <option value="{{ $cat -> id }}"> {{ $cat -> name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="gift_category_id" class="col-form-label">{{ __('main.category') }}:</label>
                        <select name="gift_category_id" id="gift_category_id" class="form-select" style="direction: ltr">
                            <option value="0"></option>
                            @foreach ($giftCats as $cat )
                            <option value="{{ $cat -> id }}"> {{ $cat -> name }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="price" class="col-form-label">{{ __('main.price') }}:</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="col-6">
                        <label for="days" class="col-form-label">{{ __('main.day_count') }}:</label>
                        <input type="number" class="form-control" id="days" name="days" required>
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
                        <label for="days" class="col-form-label">{{ __('main.behaviour') }}:</label>
                        <select name="behaviour" id="behaviour" class="form-select" style="direction: ltr">
                            <option value="0">{{ __('main.behaviour1') }}</option>
                            <option value="1">{{ __('main.behaviour2') }}</option>
                        </select>
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
                        <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag" width="80px"
                              class="profile-img"/>
                    </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="points" class="col-form-label">{{ __('main.motion_img') }}:</label>
                <input class="form-control" type="file" id="motion_icon" name="motion_icon"
                accept="*">
              </div>
              <div class="mb-3">
                <label for="points" class="col-form-label">{{ __('main.dark_img') }}:</label>
                <div class="row" style="display: flex;
                align-items: center;">
                    <div class="col-6">
                        <div class="custom-file">

                                   <input class="form-control" type="file" id="dark_icon" name="dark_icon"
                                   accept="*">
                        </div>
                    </div>
                    <div class="col-6 text-right">
                        <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag2" width="80px"
                              class="profile-img"/>
                    </div>
                </div>
              </div>


              <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="subject" class="col-form-label">{{ __('main.subject') }}:</label>
                         <select class="form-select" id="subject" name="subject" style="direction: ltr">
                            <option value="0"></option>
                            <option value="1">{{ __('main.subject1') }}</option>
                            <option value="2">{{ __('main.subject2') }}</option>
                            <option value="3">{{ __('main.subject3') }}</option>
                         </select>
                    </div>
                    <div class="col-6">
                        <label for="vip_id" class="col-form-label">{{ __('main.vip') }}:</label>
                        <select class="form-select" id="vip_id" name="vip_id" style="direction: ltr">
                            <option value="0"></option>
                            @foreach ($vips as $vip )
                            <option value="{{ $vip -> id }}"> {{ $vip -> tag }}</option>
                            @endforeach
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
    function readURL(input , i) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if(i == 1){

                    $('#profile-img-tag').attr('src', e.target.result);
                } else {
                    $('#profile-img-tag2').attr('src', e.target.result);
                }

            }
            reader.readAsDataURL(input.files[0]);

        }
    }


    $("#dark_icon").change(function () {
        readURL(this , 2);
    });

    $("#icon").change(function () {
        readURL(this , 1);
    });
</script>
