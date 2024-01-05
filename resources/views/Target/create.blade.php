<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" @if(Config::get('app.locale')=='ar' ) style="direction: rtl" @else style="direction: ltr" @endif>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('main.new_target') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bannerForm" method="POST" action="{{ route('targetStore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">


                        <label for="order" class="col-form-label">{{ __('main.order') }}:</label>
                        <input type="text" class="form-control" id="order"  name="order" required>
                        <input type="hidden" class="form-control" id="id" name="id">

                    </div>
                    <div class="mb-3">


                        <label for="order" class="col-form-label">{{ __('main.points') }}:</label>
                        <input type="number" class="form-control" id="gold"  name="gold" required>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="order" class="col-form-label">{{ __('main.amount') }}:</label>
                            <input type="number" class="form-control" id="dollar_amount"  name="dollar_amount" required>
                        </div>
                        <div class="col-6">
                        <label for="order" class="col-form-label">{{ __('main.agent_amount') }}:</label>
                        <input type="number" class="form-control" id="agent_amount"  name="agent_amount" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="img" class="col-form-label">{{ __('main.img') }}:</label>
                        <div class="row" style="display: flex;
                align-items: center;">
                            <div class="col-6">
                                <div class="custom-file">

                                    <input class="form-control" type="file" id="icon" name="icon" accept="*">
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <img src="{{ asset('assets/icons/picture.png') }}" id="profile-img-tag" width="80px" class="profile-img" />
                            </div>
                        </div>
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#profile-img-tag').attr('src', e.target.result);

            }
            reader.readAsDataURL(input.files[0]);

        }
    }



    $("#icon").change(function() {
        readURL(this);
    });

</script>
