<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Physical Attributes')}}</h5>
    </div>
    <div class="card-body">
      <form action="{{ route('physical-attribute.update', $member->id) }}" method="POST">
          <input name="_method" type="hidden" value="PATCH">
          @csrf
          <div class="form-group row">
          <div class="col-md-6">
                  <label for="height">{{translate('Height')}} ({{ translate('In Feet') }})</label>
                  @php $member_height = !empty($member->physical_attributes->height) ? number_format((float)$member->physical_attributes->height, 2, '.', '') : ""; @endphp
                    <select class="form-control aiz-selectpicker" name="height" >
                   <option value="0">{{ translate('Choose One') }}</option>
                   @for($i=4; $i<=7; $i++)
                        @for($j=0; $j<=11; $j++)
                            @php $l = sprintf("%02d",$j); $k="$i.$l"; @endphp
                                <option value={{$k}} @if($member_height ==$k ) selected @endif >{{$k}}</option>
                        @endfor
                    @endfor
                        <!-- <option value=4.0 @if($member_height ==4.0 ) selected @endif >4.0</option>
                        <option value=4.1 @if($member_height ==4.1 ) selected @endif >4.1</option>
                        <option value=4.2 @if($member_height ==4.2 ) selected @endif >4.2</option>
                        <option value=4.3 @if($member_height ==4.3 ) selected @endif >4.3</option>
                        <option value=4.4 @if($member_height ==4.4 ) selected @endif >4.4</option>
                        <option value=4.5 @if($member_height ==4.5 ) selected @endif >4.5</option>
                        <option value=4.6 @if($member_height ==4.6 ) selected @endif >4.6</option>
                        <option value=4.7 @if($member_height ==4.7 ) selected @endif >4.7</option>
                        <option value=4.8 @if($member_height ==4.8 ) selected @endif >4.8</option>
                        <option value=4.9 @if($member_height ==4.9 ) selected @endif >4.9</option>
                        <option value=4.10 @if($member_height ==4.10 ) selected @endif >4.10</option>
                        <option value=4.11 @if($member_height ==4.11 ) selected @endif >4.11</option> -->
                    </select>
                     @error('height')
                      <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="col-md-6">
                  <label for="disability">{{translate('Disability')}}</label>
                  <!-- <input type="text" name="disability" value="{{ !empty($member->physical_attributes->disability) ? $member->physical_attributes->disability : "" }}" class="form-control" placeholder="{{translate('Disability')}}"> -->
                  
                  @php $user_disability = !empty($member->physical_attributes->disability) ? $member->physical_attributes->disability : ""; @endphp
                   <select class="form-control aiz-selectpicker" name="disability" >
                       <option value="" @if($user_disability ==  '') selected @endif >{{translate('Select One')}}</option>
                        <option value="yes" @if($user_disability ==  'yes') selected @endif >{{translate('Yes')}}</option>
                        <option value="no" @if($user_disability ==  'no') selected @endif >{{translate('No')}}</option>
                        @error('disability')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </select>
              </div>
              
          </div>

    
          <div class="text-right">
              <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
          </div>
      </form>
    </div>
</div>
