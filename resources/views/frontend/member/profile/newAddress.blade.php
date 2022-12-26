@extends('frontend.layouts.member_panel')
<link rel="stylesheet" href="{{ static_asset('assets/css/tab.css') }}">
@section('panel_content')
@php $member = \App\User::find(Auth::user()->id); @endphp

{{-- admin approval banner starts here --}}

@if(Auth::user()->approved == 0)
<div class="card">
   <div class="card-header">
      <h5 class="mb-0 h6">{{translate('Admin Approval')}}</h5>
   </div>
   <div class="card-body">
      <form action="{{ route('member.send_admin_approval_new', $member->member->id) }}" method="POST">
         @csrf
         <div class="form-group row">
            <div class="badge-soft-primary fs-22"><strong>
               {{translate('Your account is pending approval, Please complete below form, click send button and await admin decision. Once sent, please wait for the decision and do not send repeated notifications.')}}
               </strong>
            </div>
         </div>
      </form>
   </div>
   <div class="card-footer">
    <div class="badge-soft-primary fs-12">
        <strong>
            Before you proceed, please make sure to consider updating “Gallery” with at least two photographs with one close up/face photo and one full size photo from <b><a target="_blank" href="{!! url('/gallery-image'); !!}">here</a>
        </strong>
    </div>
</div>
</div>
@endif

{{-- admin approval banner ends here --}}

{{-- present address card --}}

<div class="card ">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Present Address')}}</h5>
    </div>
    <div class="card-body ">
        <form action="{{ route('address.update_new', $member->id) }}" method="POST" id="regForm-4">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <input type="hidden" name="address_type" value="present">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="present_country_id">{{translate('Country')}}</label>
                    <span class="text-danger">*</span>
                    <select class="form-control aiz-selectpicker " name="present_country_id" id="present_country_id" data-live-search="true" required>
                        <option value="">{{translate('Select One')}}</option>
                        <?php $countries = \App\Models\Country::where('status',1)->get(); ?>
                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" @if($country->id == $presentAddress[0]->country_id) selected @endif>{{$country->name}}</option>
                        @endforeach
                    </select>
                    @error('present_country_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="present_state_id">{{translate('State')}}</label>
                    <span class="text-danger">*</span>
                    <select class="form-control aiz-selectpicker" name="present_state_id" id="present_state_id" data-live-search="true" required>

                    </select>
                    @error('present_state_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="present_city_id">{{translate('City')}}</label>
                    <span class="text-danger">*</span>
                    <select class="form-control aiz-selectpicker" name="present_city_id" id="present_city_id" data-live-search="true" required>

                    </select>
                    @error('present_city_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="present_postal_code">{{translate('Postal Code')}}</label>
                    <span class="text-danger">*</span>
                    <input type="number" name="present_postal_code" value="{{ $presentAddress[0]->postal_code }}" class="form-control" placeholder="{{translate('Postal Code')}}" required>
                    @error('present_postal_code')
                        <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>


            <!-- <div class="text-right">
                <button type="submit" class="btn btn-primary btn-sm">{{translate('Update')}}</button>
            </div> -->
        
        
        
    </div>
</div>
<div class="d-flex justify-content-end">
    @if (Request::path() != 'profile-settings/basic')
        <a href="{{ url()->previous() }}">
            <button class="btn btn-primary mr-2" type="submit">Previous</button>
        </a>
    @endif
    <button class="btn btn-primary" type="submit">Next</button>
</form>
</div>
            
@endsection
@section('script')

<script>
    function get_states_by_country_for_present_address(){
       var present_country_id = $('#present_country_id').val();
           $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:present_country_id}, function(data){
               $('#present_state_id').html(null);
               for (var i = 0; i < data.length; i++) {
                   $('#present_state_id').append($('<option>', {
                       value: data[i].id,
                       text: data[i].name
                   }));
               }
               $("#present_state_id > option").each(function() {
                   if(this.value == '{{ $presentAddress[0]->state_id }}'){
                       $("#present_state_id").val(this.value).change();
                   }
               });
   
               AIZ.plugins.bootstrapSelect('refresh');
   
               get_cities_by_state_for_present_address();
           });
       }


       function get_cities_by_state_for_present_address(){
   var present_state_id = $('#present_state_id').val();
   		$.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:present_state_id}, function(data){
   		    $('#present_city_id').html(null);
   		    for (var i = 0; i < data.length; i++) {
   		        $('#present_city_id').append($('<option>', {
   		            value: data[i].id,
   		            text: data[i].name
   		        }));
   		    }
   		    $("#present_city_id > option").each(function() {
   		        if(this.value == '{{ $presentAddress[0]->city_id }}'){
   		            $("#present_city_id").val(this.value).change();
   		        }
   		    });
   
   		    // AIZ.plugins.bootstrapSelect('refresh');
            //    $("#nextBtn").removeAttr("disabled");
   		});
   	}


// <!-- Hotjar Tracking Code for https://soulmatematrimonial.com.au/ -->
    
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2938310,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');

</script>

@endsection