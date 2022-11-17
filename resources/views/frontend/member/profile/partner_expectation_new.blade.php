<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Partner Expectation')}}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('partner_expectations.update_new', $member->id) }}" method="POST" id="regForm-16">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="general">{{translate('General Requirement')}}</label>
                    <input type="text" name="general" value="{{ !empty($member->partner_expectations->general) ? $member->partner_expectations->general : "" }}" class="form-control" placeholder="{{translate('Please provide General')}}" required>
                </div>
                <div class="col-md-6">
                    <label for="residence_country_id">{{translate('Residence Country')}}</label>
                    @php $partner_residence_country = !empty($member->partner_expectations->residence_country_id) ? $member->partner_expectations->residence_country_id : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="residence_country_id" data-live-search="true" required>
                    <option value="">{{ translate('Choose One') }}</option>
                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" @if($country->id == $partner_residence_country) selected @endif >{{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('residence_country_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="partner_height">{{translate('Min Height')}}  ({{ translate('In Feet') }})</label>
                    @php $partner_height =  !empty($member->partner_expectations->height) ? $member->partner_expectations->height : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_height" required >
                   <option value="0">{{ translate('Choose One') }}</option>
                   <!-- @for($i=4; $i<=7; $i++)
                        @for($j=0; $j<=11; $j++)
                            @php $k="$i.$j"; @endphp
                            <option value={{$k}} @if($partner_height ==$k ) selected @endif >{{$k}}</option>
                        @endfor
                    @endfor -->
                    @for($i=4; $i<=7; $i++)
                        @for($j=0; $j<=11; $j++)
                            @php $l = sprintf("%02d",$j); $k="$i.$l"; @endphp
                                <option value={{$k}} @if($partner_height ==$k ) selected @endif >{{$k}}</option>
                        @endfor
                    @endfor
 
                </select>

                    <!-- <input type="number" name="partner_height" value="{{ !empty($member->partner_expectations->height) ? $member->partner_expectations->height : "" }}" step="any"  placeholder="{{ translate('Height') }}" class="form-control" required> -->
                    @error('partner_height')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <!-- <div class="col-md-6">
                    <label for="partner_weight">{{translate('Max Weight')}}  ({{ translate('In Kg') }})</label>
                    <input type="number" name="partner_weight" value="{{ !empty($member->partner_expectations->weight) ? $member->partner_expectations->weight : "" }}" step="any" class="form-control" placeholder="{{translate('Weight')}}" required>
                    @error('partner_weight')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div> -->
                <div class="col-md-6">
                    <label for="partner_manglik">{{translate('Manglik')}}</label>
                    @php $partner_manglik = !empty($member->partner_expectations->manglik) ? $member->partner_expectations->manglik : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_manglik" required>
                        <option value="">{{ translate('Choose One') }}</option>
                        <option value="yes" @if($partner_manglik ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($partner_manglik ==  'no') selected @endif >{{translate('No')}}</option>
                        <option value="dose_not_matter" @if($partner_manglik ==  'dose_not_matter') selected @endif >{{translate('Dose not matter')}}</option>
                    </select>
                    @error('partner_manglik')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="partner_marital_status">{{translate('Marital Status')}}</label>
                    @php $partner_marital_status_id = !empty($member->partner_expectations->marital_status_id) ? $member->partner_expectations->marital_status_id : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_marital_status" data-live-search="true" required>
                        <option value="">{{ translate('Choose One') }}</option>
                        @foreach ($marital_statuses as $marital_status)
                        <option value="{{$marital_status->id}}" @if($partner_marital_status_id == $marital_status->id) selected @endif>{{$marital_status->name}}</option>
                        @endforeach
                    </select>
                    @error('partner_marital_status')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                 <div class="col-md-6">
                 <label for="diet">{{translate('Diet')}}</label>
                    @php $user_diet = !empty($member->lifestyles->diet) ? $member->lifestyles->diet : ""; @endphp
                    @php $diet_t = App\Models\DietType::where('status',1) ->get(); @endphp
                    <select class="form-control aiz-selectpicker" name="diet" required>
                    <option value="">{{ translate('Choose One') }}</option>
                    @foreach ($diet_t as $diets)
                            <option value="{{$diets->id}}" @if($diets->id == $user_diet) selected @endif> {{$diets->name}} </option>
                        @endforeach
                       <!--  <option value="1" @if($user_diet ==  '1') selected @endif >{{translate('Yes')}}</option>
                        <option value="2" @if($user_diet ==  '2') selected @endif >{{translate('No')}}</option> 
                    -->
                        @error('diet')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
                    @error('partner_diet')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                   <!--  <label for="partner_children_acceptable">{{translate('Children Acceptable')}}</label>
                    @php $children_acceptable = !empty($member->partner_expectations->children_acceptable) ? $member->partner_expectations->children_acceptable : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_children_acceptable" >
                        
                        <option value="yes" @if($children_acceptable ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($children_acceptable ==  'no') selected @endif >{{translate('No')}}</option>
                        <option value="dose_not_matter" @if($children_acceptable ==  'dose_not_matter') selected @endif >{{translate('Dose not matter')}}</option>
                    </select>
                    @error('partner_children_acceptable')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror -->
                </div> 
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="partner_religion_id">{{translate('Religion')}}</label>
                    <select class="form-control aiz-selectpicker" name="partner_religion_id" id="partner_religion_id" data-livfame-search="true" required>
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($religions as $religion)
                            <option value="{{$religion->id}}" @if($religion->id == $partner_religion_id) selected @endif> {{ $religion->name }} </option>
                        @endforeach
                    </select>
                    @error('partner_religion_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="partner_caste_id">{{translate('Caste')}}</label>
                    <select class="form-control aiz-selectpicker" name="partner_caste_id" id="partner_caste_id" data-live-search="true">

                    </select>
                    @error('partner_caste_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="partner_sub_caste_id">{{translate('Sub Caste')}}</label>
                    <select class="form-control aiz-selectpicker" name="partner_sub_caste_id" id="partner_sub_caste_id" data-live-search="true">
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="language_id">{{translate('Language')}}</label>
                    @php $partner_language = !empty($member->partner_expectations->language_id) ? $member->partner_expectations->language_id : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="language_id" data-live-search="true" required>
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($languages as $language)
                            <option value="{{$language->id}}" @if($language->id == $partner_language) selected @endif> {{ $language->name }} </option>
                        @endforeach
                    </select>
                    @error('language_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="pertner_education">{{translate('Education')}}</label>
                    <input type="text" name="pertner_education" value="{{ !empty($member->partner_expectations->education) ? $member->partner_expectations->education : "" }}" class="form-control" placeholder="{{translate('Please provide Education')}}">
                    @error('pertner_education')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="partner_profession">{{translate('Profession')}}</label>
                    <input type="text" name="partner_profession" value="{{ !empty($member->partner_expectations->profession) ? $member->partner_expectations->profession : "" }}" class="form-control" placeholder="{{translate('Please provide Profession')}}">
                    @error('partner_profession')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="smoking_acceptable">{{translate('Smoking Acceptable')}}</label>
                    @php $partner_smoking_acceptable = !empty($member->partner_expectations->smoking_acceptable) ? $member->partner_expectations->smoking_acceptable : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="smoking_acceptable" required>
                    <option value="">{{translate('Select One')}}</option>
                    <option value="yes" @if($partner_smoking_acceptable ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($partner_smoking_acceptable ==  'no') selected @endif >{{translate('No')}}</option>
                        <option value="dose_not_matter" @if($partner_smoking_acceptable ==  'dose_not_matter') selected @endif >{{translate('Dose not matter')}}</option>
                    </select>
                    @error('smoking_acceptable')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="drinking_acceptable">{{translate('Drinking Acceptable')}}</label>
                    @php $partner_drinking_acceptable = !empty($member->partner_expectations->drinking_acceptable) ? $member->partner_expectations->drinking_acceptable : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="drinking_acceptable" required>
                    <option value="">{{translate('Select One')}}</option>
                    <option value="yes" @if($partner_drinking_acceptable ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($partner_drinking_acceptable ==  'no') selected @endif >{{translate('No')}}</option>
                        <option value="dose_not_matter" @if($partner_drinking_acceptable ==  'dose_not_matter') selected @endif >{{translate('Dose not matter')}}</option>
                    </select>
                    @error('drinking_acceptable')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
              <!--  <div class="col-md-6">
                    
                   
                </div>
                 <div class="col-md-6">
                    <label for="partner_body_type">{{translate('Body Type')}}</label>
                    <input type="text" name="partner_body_type" value="{{ !empty($member->partner_expectations->body_type) ? $member->partner_expectations->body_type : "" }}" class="form-control" placeholder="{{translate('Body Type')}}">
                    @error('partner_body_type')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div> -->
                <div class="col-md-6">
                  <!--   <label for="family_value_id">{{translate('Family Value')}}</label>
                    <input type="text" name="family_value_id" value="{{!empty($member->partner_expectations->family_value_id) ? $member->partner_expectations->family_value_id : "" }}" class="form-control" placeholder="{{translate('Family Value')}}">
                    <select class="form-control aiz-selectpicker" name="family_value_id" >
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($family_values as $family_value)
                            <option value="{{$family_value->id}}" @if($family_value->id == !empty($member->partner_expectations->family_value_id) ? $member->partner_expectations->family_value_id : "") selected @endif> {{ $family_value->name }} </option>
                        @endforeach
                    </select>
                    @error('family_value_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror  -->
                </div>
            </div>

          <!--  <div class="form-group row">
                 <div class="col-md-6">
                    <label for="partner_personal_value">{{translate('Personal Value')}}</label>
                    <input type="text" name="partner_personal_value" value="{{ !empty($member->partner_expectations->personal_value) ? $member->partner_expectations->personal_value : "" }}" class="form-control" placeholder="{{translate('Personal Value')}}">
                    @error('partner_personal_value')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div> 
                <div class="col-md-6">
                    <label for="pertner_complexion">{{translate('Complexion')}}</label>
                    <input type="text" name="pertner_complexion" value="{{ !empty($member->partner_expectations->complexion) ? $member->partner_expectations->complexion : "" }}" class="form-control" placeholder="{{translate('Complexion')}}" required>
                    @error('pertner_complexion')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div> 

                
            </div>-->

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="partner_country_id">{{translate('Preferred Country')}}</label>
                    <select class="form-control aiz-selectpicker" name="partner_country_id" id="partner_country_id" data-live-search="true" required>
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" @if($country->id == $partner_country_id) selected @endif>{{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('partner_country_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="partner_state_id">{{translate('Preferred State')}}</label>
                    <select class="form-control aiz-selectpicker" name="partner_state_id" id="partner_state_id" data-live-search="true">

                    </select>
                    @error('partner_state_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

         <!--  <div class="form-group row">
                <div class="col-md-6">
                    <label for="family_value_id">{{translate('Family Value')}}</label>
                    <select class="form-control aiz-selectpicker" name="family_value_id" >
                        <option value="">{{translate('Select One')}}</option>
                        @foreach ($family_values as $family_value)
                            <option value="{{$family_value->id}}" @if($family_value->id == !empty($member->partner_expectations->family_value_id) ? $member->partner_expectations->family_value_id : "") selected @endif> {{ $family_value->name }} </option>
                        @endforeach
                    </select>
                    @error('family_value_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>  -->

             <div class="form-group row">
            <div class="col-md-6">
               <label for="partner_age_from">{{translate('Prefered age from')}}</label>
                    @php $partner_age_from = !empty($member->partner_expectations->partner_age_from) ? $member->partner_expectations->partner_age_from : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_age_from" >
                   <option value="0">{{ translate('Choose One') }}</option>
                    @for ($i = 18; $i < 61; $i++)
                    <option value={{$i}} @if($partner_age_from == $i) selected @endif >{{$i}}</option>
                    @endfor   
                     
                    </select>  
                    @error('partner_age_from')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
               <label for="partner_age_to">{{translate('Prefered age to')}}</label>
                    @php $partner_age_to = !empty($member->partner_expectations->partner_age_to) ? $member->partner_expectations->partner_age_to : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="partner_age_to" >
                   <option value="0">{{ translate('Choose One') }}</option>
                    @for ($j = 19; $j < 81; $j++)
                    <option value={{$j}} @if($partner_age_to ==  $j) selected @endif >{{$j}}</option>
                    @endfor   
                    <option value="81" @if($partner_age_to ==  '81') selected @endif >81+</option>
                    </select>  
                    @error('partner_age_to')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div> 

            <!-- <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
            </div> -->
        </form>
    </div>
</div>
