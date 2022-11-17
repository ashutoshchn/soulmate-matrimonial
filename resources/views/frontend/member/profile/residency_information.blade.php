<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Residency Information')}}</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('recidencies.update', $member->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          @php
              $birth_country_id = !empty($member->recidency->birth_country_id) ? $member->recidency->birth_country_id : "";
              $recidency_country_id = !empty($member->recidency->recidency_country_id) ? $member->recidency->recidency_country_id : "";
              $growup_country_id = !empty($member->recidency->growup_country_id) ? $member->recidency->growup_country_id : "";
          @endphp
          <div class="form-group row"> 
              <div class="col-md-6">
                  <label for="birth_country_id">{{translate('Birth Country')}}</label>
                  <select class="form-control aiz-selectpicker" name="birth_country_id" data-live-search="true">
                  <option value="">{{translate('Select One')}}</option>
                      @foreach ($countries as $country)
                          <option value="{{$country->id}}" @if($country->id == $birth_country_id) selected @endif >{{$country->name}}</option>
                      @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="recidency_country_id">{{translate('Recidency Country')}}</label>
                  <select class="form-control aiz-selectpicker" name="recidency_country_id" data-live-search="true">
                  <option value="">{{translate('Select One')}}</option>
                      @foreach ($countries as $country)
                          <option value="{{$country->id}}" @if($country->id == $recidency_country_id) selected @endif >{{$country->name}}</option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="form-group row">
              <div class="col-md-6">
                  <label for="growup_country_id">{{translate('Growup Country')}}</label>
                  <select class="form-control aiz-selectpicker" name="growup_country_id" data-live-search="true">
                  <option value="">{{translate('Select One')}}</option>
                      @foreach ($countries as $country)
                          <option value="{{$country->id}}" @if($country->id == $growup_country_id) selected @endif >{{$country->name}}</option>
                      @endforeach
                  </select>
              </div>
              
              <div class="col-md-6">
                  <label for="immigration_status">{{translate('Immigration Status')}}</label>
                  @if(!empty($member->recidency->immigration_status))
                  <select class="form-control aiz-selectpicker" name="immigration_status" data-live-search="true" required>
                        <option value="" @if($member->recidency->immigration_status == "") selected @endif> {{translate('Select One')}}</option>
                        <option value="Bridging Visa" @if($member->recidency->immigration_status == "Bridging Visa") selected @endif> {{translate('Bridging Visa')}}</option>
                        <option value="pr" @if($member->recidency->immigration_status == "pr") selected @endif> {{translate('Permanent Residence')}}</option>
                        <option value="citizen" @if($member->recidency->immigration_status == "citizen") selected @endif> {{translate('Citizen')}}</option>
                        <option value="wv" @if($member->recidency->immigration_status == "wv") selected @endif> {{translate('Work Visa')}}</option>
                        <option value="visitor" @if($member->recidency->immigration_status == "visitor") selected @endif> {{translate('Visitor')}}</option>
                        <option value="sv" @if($member->recidency->immigration_status == "sv") selected @endif> {{translate('Student Visa')}}</option>
                        <option value="nv" @if($member->recidency->immigration_status == "nv") selected @endif> {{translate('No Visa')}}</option>
                    </select> 
                    @else
                    <select class="form-control aiz-selectpicker" name="immigration_status" data-live-search="true" required>
                    <option value="" selected>{{translate('Select One')}}</option>
                    <option value="Bridging Visa" > {{translate('Bridging Visa')}}</option>
                    <option value="pr"  > {{translate('Permanent Residence')}}</option>
                        <option value="citizen" > {{translate('Citizen')}}</option>
                        <option value="wv" > {{translate('Work Visa')}}</option>
                        <option value="visitor" > {{translate('Visitor')}}</option>
                        <option value="sv" > {{translate('Student Visa')}}</option>
                        <option value="nv"> {{translate('No Visa')}}</option>
                    </select> 
                    @endif
                  <!-- <input type="text" name="immigration_status" value="{{ !empty($member->recidency->immigration_status) ? $member->recidency->immigration_status : "" }}" placeholder="{{ translate('Immigration Status') }}" class="form-control"> -->
                  <!-- @error('immigration_status')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror -->
              </div>
             
          </div>

          <div class="text-right">
              <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
          </div>
      </form>
    </div>
  </div>
