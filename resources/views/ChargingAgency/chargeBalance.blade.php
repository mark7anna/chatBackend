<div class="modal fade" id="chargeModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" @if(Config::get('app.locale') == 'ar') style="direction: rtl"  @else style="direction: ltr" @endif >
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ __('main.charging_agency_balance') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form  id="chargeForm" method="POST" action="{{ route('addchargingBalance') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="name" class="col-form-label">{{ __('main.name') }}:</label>
                            <input type="text" class="form-control" id="name" name="name"  readonly>
                            <input type="hidden" class="form-control" id="id" name="id" >
                        </div>
                        <div class="col-6">
                            <label for="name" class="col-form-label">{{ __('main.current_balance') }}:</label>
                            <input type="text" class="form-control" id="current_balance" name="current_balance"  readonly>
                        </div>
                    
                    </div>

            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12">
                        <label for="name" class="col-form-label">{{ __('main.charging_value') }}:</label>
                        <input type="number" class="form-control" id="charging_value" name="charging_value"  required >
                     
                    </div>
                
                </div>

        </div>


         
    


          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('main.close') }}</button>
          <button type="submit" class="btn btn-primary" form="chargeForm">{{ __('main.save') }}</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

