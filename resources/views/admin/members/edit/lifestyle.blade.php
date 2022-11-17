<div class="card-header bg-dark text-white">
    <h5 class="mb-0 h6">{{translate('Lifestyle')}}</h5>
</div>
<div class="card-body">
    <form action="{{ route('lifestyles.update', $member->id) }}" method="POST">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
                <label for="diet">{{translate('Diet')}}</label>
                <select class="form-control aiz-selectpicker" name="diet" data-live-search="true" required>
                <option value="">{{translate('Select One')}}</option>
                    @foreach ($diet_types as $diet_type)
                        <option value="{{$diet_type->id}}" @if(isset($member->lifestyles->diet) && $member->lifestyles->diet == $diet_type->id) selected @endif>{{$diet_type->name}}</option>
                    @endforeach
                    </select>
                <!-- <input type="text" name="diet" value="{{ !empty($member->lifestyles->diet) ? $member->lifestyles->diet : "" }}" class="form-control" placeholder="{{translate('Diet')}}" required> -->
                @error('diet')
                    <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
            <label for="drink">{{translate('Drink')}}</label>
            @php $user_drink = !empty($member->lifestyles->drink) ? $member->lifestyles->drink : ""; @endphp
                   <select class="form-control aiz-selectpicker" name="drink" required>
                   <option value="">{{translate('Select One')}}</option>
                        <option value="yes" @if($user_drink ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($user_drink ==  'no') selected @endif >{{translate('No')}}</option>
                        <option value="occ" @if($user_drink ==  'occ') selected @endif >{{translate('Occasionally')}}</option>
                        @error('drink')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="smoke">{{translate('Smoke')}}</label>
                @php $user_smoke = !empty($member->lifestyles->smoke) ? $member->lifestyles->smoke : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="smoke" required>
                    <option value="">{{translate('Select One')}}</option>

                        <option value="yes" @if($user_smoke ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($user_smoke ==  'no') selected @endif >{{translate('No')}}</option>
                        @error('smoke')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
            </div>
            <div class="col-md-6">
            <label for="living_with">{{translate('Do you have pet')}}</label>
                    @php $user_living =  !empty($member->lifestyles->living_with) ? $member->lifestyles->living_with : "" ; @endphp
                    <select class="form-control aiz-selectpicker" name="living_with" required>
                    <option value="">{{translate('Select One')}}</option>
                    <option value="no" @if($user_living ==  'no') selected @endif >{{translate('No')}}</option>
                    <option value="yes" @if($user_living ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        @error('living_with')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                    </select>
            </div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-info btn-sm">{{translate('Update')}}</button>
        </div>
    </form>
</div>
