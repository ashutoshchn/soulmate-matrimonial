@extends('frontend.layouts.member_panel')
<link rel="stylesheet" href="{{ static_asset('assets/css/tab.css') }}">
@section('panel_content')
    @php $member = \App\User::find(Auth::user()->id); @endphp

    @if(Auth::user()->approved == 0)
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Admin Approval')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('member.send_admin_approval', $member->member->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="badge-soft-primary fs-22"><strong>
                         {{translate('Your account is pending approval, Please complete below form, click send button and await admin decision. Once sent, please wait for the decision and do not send repeated notifications.')}}
                    </strong>
                    </div>
                </div>
            </form>
        </div>
      </div>
    @endif
<div class="accordion">

    
<div class="tab">
    <div class="card" id="introduction">
        <div class="card-header" class="col-3">
            <h5 class="mb-0 h6">{{translate('Tell us about yourself')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('member.introduction.update', $member->member->id) }}" id="regForm" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">{{translate('Introduction')}}</label>
                    <div class="col-md-10">
                        <textarea type="text" name="introduction" class="form-control" rows="4" placeholder="{{translate('Introduction')}}" required>{{ $member->member->introduction }}</textarea>
                    </div>
                </div>
               
                    <button type="submit"  class="btn btn-primary btn-sm" onclick="nextPrev(1)">{{translate('Update and next')}}</button>
                </div> 
            </form>
        </div>
    </div>
</div>
    <!-- Email Change -->
    <div class="tab">
    <div class="card" id="email">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Your Email Address')}}</h5>
        </div>
        <div class="card-body">
            @if(Auth::user()->email_verified_at1 == null)

            <form action="{{ route('user.change.email') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Your Email Address') }}</label>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group mb-3">
                          <input type="email" class="form-control" placeholder="{{ translate('Your Email')}}" name="email" value="{{ Auth::user()->email }}" />
                          <div class="input-group-append">
                             <button type="button" class="btn btn-outline-secondary new-email-verification">
                                 <span class="d-none loading">
                                     <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                     {{ translate('Sending Email...') }}
                                 </span>
                                 <span class="default">{{ translate('Verify') }}</span>
                             </button>
                          </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Update')}}</button>
                        </div>
                    </div>
                </div>
            </form>
            @else
            <div class="row">
                    <div class="col-md-2">
                        <label>{{ translate('Your Email Address') }}</label>
                    </div>
                    <div class="col-md-10">
                        <div class="input-group mb-3">
                          <label>{{ Auth::user()->email }}</label>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>

    <!-- Basic Information -->
    <div class="tab">
    <div id="basic">
    </div>
    @include('frontend.member.profile.basic_info')
    </div>
    <!-- Present Address -->
    <div class="tab">
    @php
        $present_address      = \App\Models\Address::where('type','present')->where('user_id',$member->id)->first();
        $present_country_id   = !empty($present_address->country_id) ? $present_address->country_id : "";
        $present_state_id     = !empty($present_address->state_id) ? $present_address->state_id : "";
        $present_city_id      = !empty($present_address->city_id) ? $present_address->city_id : "";
        $present_postal_code  = !empty($present_address->postal_code) ? $present_address->postal_code : "";
    @endphp
    @if(get_setting('member_present_address_section') == 'on')
    <div id="present">
    </div>
      @include('frontend.member.profile.present_address')
    @endif
</div>
    
<!-- Residency Information -->
<div class="tab">
    @if(get_setting('member_residency_information_section') == 'on')
    <div id="residency">
    </div>
      @include('frontend.member.profile.residency_information')
    @endif
</div>

    <!-- Permanent Address -->
    <div class="tab">
    @php
        $permanent_address      = \App\Models\Address::where('type','permanent')->where('user_id',$member->id)->first();
        $permanent_country_id   = !empty($permanent_address->country_id) ? $permanent_address->country_id : "";
        $permanent_state_id     = !empty($permanent_address->state_id) ? $permanent_address->state_id : "";
        $permanent_city_id      = !empty($permanent_address->city_id) ? $permanent_address->city_id : "";
        $permanent_postal_code  = !empty($permanent_address->postal_code) ? $permanent_address->postal_code : "";
    @endphp
    @if(get_setting('member_permanent_address_section') == 'on')
    <div id="permanent" >
    </div>
      @include('frontend.member.profile.permanent_address')
    @endif
</div>


    <!-- Education -->
    <div class="tab">
    @if(get_setting('member_education_section') == 'on')
    <div id="edu">
    </div>
        @include('frontend.member.profile.education.index')
    @endif
</div>

    <!-- Career -->
    <div class="tab">
    @if(get_setting('member_career_section') == 'on')
    <div id="career">
    </div>
      @include('frontend.member.profile.career.index')
    @endif
</div>

    <!-- Physical Attributes -->
    <div class="tab">
    @if(get_setting('member_physical_attributes_section') == 'on')
    <div id="physical" class="tab">
</div>
        @include('frontend.member.profile.physical_attributes')
    @endif
</div>

    <!-- Language -->
    <div class="tab">
    @if(get_setting('member_language_section') == 'on')
    <div id="lang" >
    </div>
      @include('frontend.member.profile.language')
    @endif
</div>

    <!-- Hobbies  -->
    
    @if(get_setting('member_hobbies_and_interests_section') == 'on')
    <div class="tab">
    <div id="hobbies" >
    </div>
        @include('frontend.member.profile.hobbies_interest')
    </div>
    @endif


    <!-- Personal Attitude & Behavior -->
    <div class="tab">
    @if(get_setting('member_personal_attitude_and_behavior_section') == 'on')
    <div id="attitude">
    </div>
        @include('frontend.member.profile.attitudes_behavior')
    @endif
</div>

    <!-- Spiritual & Social Background -->
    <div class="tab">
    @php
        $member_religion_id   = !empty($member->spiritual_backgrounds->religion_id) ? $member->spiritual_backgrounds->religion_id : "";
        $member_caste_id      = !empty($member->spiritual_backgrounds->caste_id) ? $member->spiritual_backgrounds->caste_id : "";
        $member_sub_caste_id  = !empty($member->spiritual_backgrounds->sub_caste_id) ? $member->spiritual_backgrounds->sub_caste_id : "";
    @endphp
    @if(get_setting('member_spiritual_and_social_background_section') == 'on')
    <div id="spiritual" >
    </div>
        @include('frontend.member.profile.spiritual_backgrounds')
    @endif
</div> 

    <!-- Life Style -->
    <div class="tab">
    @if(get_setting('member_life_style_section') == 'on')
    <div id="lifestyle" >
    </div>
        @include('frontend.member.profile.lifestyle')
    @endif
</div> 

    <!-- Astronomic Information  -->
    <div class="tab">
    @if(get_setting('member_astronomic_information_section') == 'on')
    <div id="astro" >
    </div>
        @include('frontend.member.profile.astronomic_information')
    @endif
</div> 

    <!-- Family Information -->
    <div class="tab">
    @if(get_setting('member_family_information_section') == 'on')
    <div id="family">
    </div>
        @include('frontend.member.profile.family_information')
    @endif
</div> 

    <!-- Partner Expectation -->
    <div class="tab">
    @php
        $partner_religion_id   = !empty($member->partner_expectations->religion_id) ? $member->partner_expectations->religion_id : "";
        $partner_caste_id      = !empty($member->partner_expectations->caste_id) ? $member->partner_expectations->caste_id : "";
        $partner_sub_caste_id  = !empty($member->partner_expectations->sub_caste_id) ? $member->partner_expectations->sub_caste_id : "";
        $partner_country_id    = !empty($member->partner_expectations->preferred_country_id) ? $member->partner_expectations->preferred_country_id : "";
        $partner_state_id      = !empty($member->partner_expectations->preferred_state_id) ? $member->partner_expectations->preferred_state_id : "";
    @endphp
    @if(get_setting('member_partner_expectation_section') == 'on')
    <div id="partner">
    </div>
        @include('frontend.member.profile.partner_expectation')
    @endif
</div>

<div class="tab">
    @if(Auth::user()->approved == 0)
        <div class="card" id="last">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Admin Approval')}}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('member.send_admin_approval', $member->member->id) }}" method="POST">
                @csrf
                <div class="form-group row">
                    <div class="badge-soft-primary fs-22">
                        {{translate('Please remember to upload photo for your profile and consider updating “Gallery” with at least two photographs with one close up/face photo and one full size photo.')}}
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-sm">{{translate('Send For Admin Approval')}}</button>
                </div>
            </form>
            
        </div>
      </div>
    
     @endif
</div> 

<!-- Circles which indicates the steps of the form: -->
<div style="text-align:center;margin-top:40px;">
@for($i=0;$i<15;$i++)
  <span class="step"></span>
  @endfor
  
</div>

 <div style="overflow:auto;">
  <div style="float:right;">
    <button type="button" id="prevBtn" class="btn btn-primary btn-sm" onclick="nextPrev(-1)">Previous</button>
    <button type="button" id="nextBtn" class="btn btn-primary btn-sm" onclick="nextPrev(1)"> next</button>
    
  </div>
</div> 



</form>
</div>
@endsection

@section('modal')
    @include('modals.create_edit_modal')
    @include('modals.delete_modal')
@endsection

@section('script')

<script type="text/javascript">

    $(document).ready(function(){
         get_states_by_country_for_present_address();
         get_cities_by_state_for_present_address();
         get_states_by_country_for_permanent_address();
         get_cities_by_state_for_permanent_address();
         get_castes_by_religion_for_member();
         get_sub_castes_by_caste_for_member();
         get_castes_by_religion_for_partner();
         get_sub_castes_by_caste_for_partner();
         get_states_by_country_for_partner();
    });

    // For Present address
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
                    if(this.value == '{{$present_state_id}}'){
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
    		        if(this.value == '{{$present_city_id}}'){
    		            $("#present_city_id").val(this.value).change();
    		        }
    		    });

    		    AIZ.plugins.bootstrapSelect('refresh');
    		});
    	}

    $('#present_country_id').on('change', function() {
  	    get_states_by_country_for_present_address();
  	});

    $('#present_state_id').on('change', function() {
  	    get_cities_by_state_for_present_address();
  	});

    // For permanent address
    function get_states_by_country_for_permanent_address(){
        var permanent_country_id = $('#permanent_country_id').val();
            $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:permanent_country_id}, function(data){
                $('#permanent_state_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#permanent_state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#permanent_state_id > option").each(function() {
                    if(this.value == '{{$permanent_state_id}}'){
                        $("#permanent_state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');

                get_cities_by_state_for_permanent_address();
            });
    }

    function get_cities_by_state_for_permanent_address(){
        var permanent_state_id = $('#permanent_state_id').val();
            $.post('{{ route('cities.get_cities_by_state') }}',{_token:'{{ csrf_token() }}', state_id:permanent_state_id}, function(data){
                $('#permanent_city_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#permanent_city_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#permanent_city_id > option").each(function() {
                    if(this.value == '{{$permanent_city_id}}'){
                        $("#permanent_city_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');
            });
    }

    $('#permanent_country_id').on('change', function() {
        get_states_by_country_for_permanent_address();
    });

    $('#permanent_state_id').on('change', function() {
        get_cities_by_state_for_permanent_address();
    });

    // get castes and subcastes For member
    function get_castes_by_religion_for_member(){
        var member_religion_id = $('#member_religion_id').val();
            $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:member_religion_id}, function(data){
                $('#member_caste_id').html(null);
                $('#member_caste_id').append($('<option>', {
                        value: '',
                        text: 'Select One'
                    }));
                for (var i = 0; i < data.length; i++) {
                    $('#member_caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#member_caste_id > option").each(function() {
                    if(this.value == '{{$member_caste_id}}'){
                        $("#member_caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');

                get_sub_castes_by_caste_for_member();
            });
        }

    function get_sub_castes_by_caste_for_member(){
        var member_caste_id = $('#member_caste_id').val();
            $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:member_caste_id}, function(data){
                $('#member_sub_caste_id').html(null);
                $('#member_sub_caste_id').append($('<option>', {
                        value: '',
                        text: 'Select One'
                    }));
                for (var i = 0; i < data.length; i++) {
                    $('#member_sub_caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#member_sub_caste_id > option").each(function() {
                    if(this.value == '{{$member_sub_caste_id}}'){
                        $("#member_sub_caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

    // $('#member_religion_id').on('change', function() {
    //     get_castes_by_religion_for_member();
    // });

    // $('#member_caste_id').on('change', function() {
    //     get_sub_castes_by_caste_for_member();
    // });

    // get castes and subcastes For partner
    function get_castes_by_religion_for_partner(){
        var partner_religion_id = $('#partner_religion_id').val();
            $.post('{{ route('castes.get_caste_by_religion') }}',{_token:'{{ csrf_token() }}', religion_id:partner_religion_id}, function(data){
                //$('#partner_caste_id').html(null);
                $('#partner_caste_id').append($('<option>', {
                        value: '',
                        text: 'Select One'
                    }));
                for (var i = 0; i < data.length; i++) { 
                    $('#partner_caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#partner_caste_id > option").each(function() {
                    if(this.value == '{{$partner_caste_id}}'){
                        $("#partner_caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');

                get_sub_castes_by_caste_for_partner();
            });
        }

    function get_sub_castes_by_caste_for_partner(){
        var partner_caste_id = $('#partner_caste_id').val();
            $.post('{{ route('sub_castes.get_sub_castes_by_religion') }}',{_token:'{{ csrf_token() }}', caste_id:partner_caste_id}, function(data){
                //$('#partner_sub_caste_id').html(null);
                $('#partner_sub_caste_id').append($('<option>', {
                        value: '',
                        text: 'Select One'
                    }));
                for (var i = 0; i < data.length; i++) {
                    $('#partner_sub_caste_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#partner_sub_caste_id > option").each(function() {
                    if(this.value == '{{$partner_sub_caste_id}}'){
                        $("#partner_sub_caste_id").val(this.value).change();
                    }
                });
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }

    // $('#partner_religion_id').on('change', function() {
    //     get_castes_by_religion_for_partner();
    // });

    // $('#partner_caste_id').on('change', function() {
    //     get_sub_castes_by_caste_for_partner();
    // });

    // For partner address
    function get_states_by_country_for_partner(){
        var partner_country_id = $('#partner_country_id').val();
            $.post('{{ route('states.get_state_by_country') }}',{_token:'{{ csrf_token() }}', country_id:partner_country_id}, function(data){
                $('#partner_state_id').html(null);
                for (var i = 0; i < data.length; i++) {
                    $('#partner_state_id').append($('<option>', {
                        value: data[i].id,
                        text: data[i].name
                    }));
                }
                $("#partner_state_id > option").each(function() {
                    if(this.value == '{{$partner_state_id}}'){
                        $("#partner_state_id").val(this.value).change();
                    }
                });

                AIZ.plugins.bootstrapSelect('refresh');
            });
    }

    $('#partner_country_id').on('change', function() {
        get_states_by_country_for_partner();
    });

    //  education Add edit , status change
    function education_add_modal(id){
       $.post('{{ route('education.create') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
           $('.create_edit_modal_content').html(data);
           $('.create_edit_modal').modal('show');
       });
    }

    function education_edit_modal(id){
        $.post('{{ route('education.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }

    function update_education_present_status(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('education.update_education_present_status') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function (data) {
            if (data == 1) {
                location.reload();
            } else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }


    //  Career Add edit , status change
    function career_add_modal(id){
       $.post('{{ route('career.create') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
           $('.create_edit_modal_content').html(data);
           $('.create_edit_modal').modal('show');
       });
    }

    function career_edit_modal(id){
        $.post('{{ route('career.edit') }}',{_token:'{{ @csrf_token() }}', id:id}, function(data){
            $('.create_edit_modal_content').html(data);
            $('.create_edit_modal').modal('show');
        });
    }

    function update_career_present_status(el) {
        if (el.checked) {
            var status = 1;
        } else {
            var status = 0;
        }
        $.post('{{ route('career.update_career_present_status') }}', {
            _token: '{{ csrf_token() }}',
            id: el.value,
            status: status
        }, function (data) {
            if (data == 1) {
                location.reload();
            } else {
                AIZ.plugins.notify('danger', 'Something went wrong');
            }
        });
    }

    $('.new-email-verification').on('click', function() {
        $(this).find('.loading').removeClass('d-none');
        $(this).find('.default').addClass('d-none');
        var email = $("input[name=email]").val();

        $.post('{{ route('user.new.verify') }}', {_token:'{{ csrf_token() }}', email: email}, function(data){
            data = JSON.parse(data);
            $('.default').removeClass('d-none');
            $('.loading').addClass('d-none');
            if(data.status == 2)
                AIZ.plugins.notify('warning', data.message);
            else if(data.status == 1)
                AIZ.plugins.notify('success', data.message);
            else
                AIZ.plugins.notify('danger', data.message);
        });
    });
    $(function(){
        if (location.hash === "introduction") {
            goto('#introduction', this);
        } else if (location.hash === "email") {
            goto('#email', this);
        } else if (location.hash === "basic") {
            goto('#basic', this);
        } else if (location.hash === "present") {
            goto('#present', this);
        } else if (location.hash === "residency") {
            goto('#residency', this);
        } else if (location.hash === "permanent") {
            goto('#permanent', this);
        } else if (location.hash === "edu") {
            goto('#edu', this);
        } else if (location.hash === "career") {
            goto('#career', this);
        } else if (location.hash === "physical") {
            goto('#physical', this);
        } else if (location.hash === "lang") {
            goto('#lang', this);
        } else if (location.hash === "hobbies") {
            goto('#hobbies', this);
        } else if (location.hash === "attitude") {
            goto('#attitude', this);
        } else if (location.hash === "spiritual") {
            goto('#spiritual', this);
        } else if (location.hash === "lifestyle") {
            goto('#lifestyle', this);
        } else if (location.hash === "astro") {
            goto('#astro', this);
        } else if (location.hash === "family") {
            goto('#family', this);
        } else if (location.hash === "partner") {
            goto('#partner', this);
        } else if (location.hash === "last") {
            goto('#last', this);
        }        
    });

    $(function(){
        // $("#accordion").accordion();
    });



    var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}

</script>

@endsection
