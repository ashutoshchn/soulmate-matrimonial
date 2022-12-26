@extends('frontend.layouts.app')
@section('content')
	<!-- Homepage Slider Section -->
	@if( get_setting('show_homepage_slider') == 'on' && get_setting('home_slider_images') != null )
		<section class="position-relative overflow-hidden min-vh-100 d-flex home-slider-area">
      	@php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
	    	<div class="absolute-full">
				<div class="aiz-carousel aiz-carousel-full h-100" data-fade='true' data-infinite='true' data-autoplay='true'>
					@foreach ($slider_images as $key => $slider_image)
            			<img class="img-fit" src="{{ uploaded_asset($slider_image) }}">
					@endforeach
				</div>
				<div class="absolute-full bg-white opacity-20 d-md-none"></div>
	    	</div>
	    	<div class="container position-relative d-flex flex-column">
	    		<div class="row pt-11 my-auto align-items-center" style="margin-bottom: 0!important;">
	    			<div class="col-xl-5 col-lg-6 my-4">
	    				<div class="text-dark">
	    					{!! get_setting('home_slider_text') !!}
	    				</div>
	    			</div>
    				@if(!Auth::check() && get_setting('show_homepage_slider_registration') == 'on')
    				<div class="offset-xxl-2 offset-xl-1 col-lg-6 col-xxl-5">
	    				<div class="card">
		    				<div class="card-body">
		    					<div class="mb-4 text-center">
									<h2 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h2>
									<p>{{ translate('Fill out the form to get started') }}.</p>
								</div>
		    					<form class="form-default" id="reg-form" role="form" action="{{ route('register') }}" method="POST">
									@csrf
									<!-- <div class="row">
										<div class="col-lg-12">
											<div class="form-group mb-3">
												<label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
												@php $on_behalves = \App\Models\OnBehalf::all(); @endphp
												<select class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror" name="on_behalf" required>
													@foreach ($on_behalves as $on_behalf)
														<option value="{{$on_behalf->id}}">{{$on_behalf->name}}</option>
													@endforeach
												</select>
												@error('on_behalf')
												<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
											</div>
										</div>
									</div> -->
									<div class="row">
								        <div class="col-lg-6">
								            <div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('First Name') }}</label>
												<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="{{translate('First Name')}}"  required>
												@error('first_name')
													<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
								            </div>
								        </div>
										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('Last Name') }}</label>
												<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="{{ translate('Last Name') }}"  required>
												@error('last_name')
												<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
											</div>
										</div>
		    						</div>
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="form-label" for="gender">{{ translate('Gender') }}</label>
												<select class="form-control aiz-selectpicker @error('gender') is-invalid @enderror" name="gender" required>
													<option value="1">{{translate('Male')}}</option>
													<option value="2">{{translate('Female')}}</option>
												</select>
												@error('gender')
												<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('Date Of Birth') }}</label>
												<input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true"  required>
												@error('date_of_birth')
												<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
											</div>
										</div>
									</div>
									@if(addon_activation('otp_system'))
									<div>
											<div class="d-flex justify-content-between align-items-start">
												<label class="form-label" for="email">{{ translate('Phone') }}</label>
												<!-- <button class="btn btn-link p-0 opacity-50 text-reset fs-12" type="button" onclick="toggleEmailPhone(this)">{{ translate('Use Email Instead') }}</button> -->
											</div>
											<div class="form-group phone-form-group mb-1">
									            <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
									        </div>

									        <input type="hidden" name="country_code" value="">

									        <div class="form-group email-form-group mb-1 d-none">
									            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"  autocomplete="off">
									            @if ($errors->has('email'))
									                <span class="invalid-feedback" role="alert">
									                    <strong>{{ $errors->first('email') }}</strong>
									                </span>
									            @endif
									        </div>
									    </div>
										@else
										<div class="row">
											<div class="col-lg-12">
											  <div class="form-group mb-3">
													<label class="form-label" for="email">{{ translate('Email address') }}</label>
													<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" >
											        @error('email')
											            <span class="invalid-feedback" role="alert">{{ $message }}</span>
											        @enderror
											  </div>
											</div>
										</div>
									@endif
										
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="form-label" for="password">{{ translate('Password') }}</label>
												<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" aria-label="********" required>
												<small>{{ translate('Minimun 8 characters') }}</small>
												@error('password')
												<span class="invalid-feedback" role="alert">{{ $message }}</span>
												@enderror
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group mb-3">
												<label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
												<input type="password" class="form-control" name="password_confirmation" placeholder="********" required>
												<small>{{ translate('Minimun 8 characters') }}</small>
											</div>
										</div>
									</div>
									@if(addon_activation('referral_system'))
									<div class="row">
										<div class="col-lg-12">
											<div class="form-group mb-3">
												<label class="form-label" for="email">{{ translate('Referral Code') }}</label>
												<input type="text" class="form-control{{ $errors->has('referral_code') ? ' is-invalid' : '' }}" value="{{ old('referral_code') }}" placeholder="{{  translate('Referral Code') }}" name="referral_code">
		                      @if ($errors->has('referral_code'))
		                          <span class="invalid-feedback" role="alert">
		                              <strong>{{ $errors->first('referral_code') }}</strong>
		                          </span>
		                      @endif
											</div>
										</div>
									</div>
									@endif
									@if(get_setting('google_recaptcha_activation') == 1)
									<div class="form-group">
										<div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
									</div>
									@endif

									<div class="mb-3">
										<label class="aiz-checkbox">
										<input type="checkbox" name="checkbox_example_1" required>
											<span class=opacity-60>{{ translate('By signing up you agree to our')}}
												<a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
											</span>
											<span class="aiz-square-check"></span>
										</label>
									</div>

									<div class="">
										<button type="submit" class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
									</div>
									@if(get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1)
					                <div class="mt-4">
					                    <div class="separator mb-3">
					                        <span class="bg-white px-3">{{ translate('Or Join With') }}</span>
					                    </div>
			                    		<ul class="list-inline social colored text-center">
											@if(get_setting('facebook_login_activation') == 1)
					                        <li class="list-inline-item">
					                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook" title="{{ translate('Facebook') }}"><i class="lab la-facebook-f"></i></a>
					                        </li>
											@endif
											@if(get_setting('google_login_activation') == 1)
											<li class="list-inline-item">
												<a href="{{ route('social.login', ['provider' => 'google']) }}" class="google" title="{{ translate('Google') }}"><i class="lab la-google"></i></a>
											</li>
											@endif
											@if(get_setting('twitter_login_activation') == 1)
					                        <li class="list-inline-item">
					                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter" title="{{ translate('Twitter') }}"><i class="lab la-twitter"></i></a>
					                        </li>
											@endif
										</ul>
									</div>
									@endif
								</form>
		    				</div>
	    				</div>
    				</div>
    				@endif
	    		</div>

				<!-- search  -->
				@if(Auth::check() && Auth::user()->user_type == 'member')
					<div class="p-4 bg-white rounded-top border-bottom" style="box-shadow: 0 -25px 50px -12px rgb(0 0 0 / 25%);">
						<div class="row">
							<div class="col-xl-10 mx-auto">
								<form action="{{ route('member.listing') }}" method="get">
									<div class="row gutters-5">
										<div class="col-lg">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('Age From') }}</label>
												<input type="number" name="age_from"  class="form-control">
											</div>
										</div>
										<div class="col-lg">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('To') }}</label>
												<input type="number" name="age_to" class="form-control">
											</div>
										</div>
										<div class="col-lg">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('Religion') }}</label>
												@php $religions = \App\Models\Religion::all(); @endphp
												<select name="religion_id" id="religion_id" class="form-control aiz-selectpicker"  data-live-search="true"  data-container="body">
													<option value="">{{translate('Choose One')}}</option>
													@foreach ($religions as $religion)
															<option value="{{ $religion->id }}"> {{ $religion->name }} </option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-lg">
											<div class="form-group mb-3">
												<label class="form-label" for="name">{{ translate('Mother Tongue') }}</label>
												@php $mother_tongues = \App\Models\MemberLanguage::all(); @endphp
												<select name="mother_tongue" class="form-control aiz-selectpicker" data-live-search="true" data-container="body">
													<option value="">{{translate('Select One')}}</option>
													@foreach ($mother_tongues as $mother_tongue_select)
														<option value="{{$mother_tongue_select->id}}"> {{ $mother_tongue_select->name }} </option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-lg">
											<button type="submit" class="btn btn-block btn-primary mt-4">{{ translate('Search') }}</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				@endif

	    	</div>
	    </section>
	@endif
	

		<!-- photo section -->
		<div class="container">
			<div class="row" id="reversecol">
				<div class="col-md-8 text-dark" id="pcol">
<h1 id="head"> Best Indian Match-making in Australia
</h1>
<p id="pictx" >Soulmate Matrimonial Services is one of the trusted Indian match-making service provider based in Sydney with continued commitment to work closely with Indian community and provide personalised service to their members. It endeavours to make tailored matches to suite candidate’s preferences with family background for singles living in Australia, New Zealand, India and other countries.  Soulmate Matrimonial Services is an attempt to strengthen the matrimonial bond among the Indian community all over the world.
</p>
 <h4 class="bmt">Why Choose Soulmate Matrimonial?
</h4>
 <ul id="list">
	<li id="l1">Matchmaking services which maintains privacy and confidentiality.</li>
						
						<li id="l2">Dedication and continuous commitment to the community
                        </li>
						<li id="l3">Verified and authenticated profiles </li>
						<li id="l4">Highly personalised and trusted services</li>
                        <li id="l5">User friendly and technology savvy website with advanced features
                        </li>
                        
                        

 </ul>
 <button class="btn btn-primary" id="scroll1"><a class="regfreebtn"  href="{{ url('register') }}">Free Registration</a> </button>

					
				</div>
				<div class="col-md-4">
					<img class="img-fluid" src="{{  url('public/img/soul.jpg')  }}" alt="img">
					<div class="lf-txt">
					
</div>
						
				</div>
			</div>
		</div>

	<!-- premium member Section -->
	@if( get_setting('show_premium_member_section') == 'on' )
    <section class="py-9 bg-white">
    	<div class="container">
    		<div class="row">
    			<div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
    				<div class="text-center section-title mb-5">
    					<h2 class="fw-600 mb-3 text-dark">{{ get_setting('premium_member_section_title') }}</h2>
    					<p class="fw-400 fs-16 opacity-60">{{ get_setting('premium_member_section_sub_title') }}</p>
    				</div>
    			</div>
    		</div>
    		<div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
					@foreach ($premium_members as $key => $member)
	            <div class="carousel-box">
	                @include('frontend.inc.member_box_1',['member'=>$member])
	            </div>
	        @endforeach
    		</div>
    	</div>
    </section>
	@endif
	

    <!-- Success Story/Video Section -->
	<section class="py-7 bg-dark text-white" id="pss">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                    <div class="text-center section-title mb-5">
                        <h2 class="fw-600 mb-3" id="ss">Success Stories</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg">
                  <div style="padding:125% 0 0 0;position:relative;">
                    <iframe src="https://player.vimeo.com/video/698478270?h=443de7e952&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:40%;" title="#">
                      </iframe>
                  </div>
                  <script src="https://player.vimeo.com/api/player.js"></script>
          </div>
            </div>
        </div>
    </section>

   
	<!-- Banner section 1 -->
    @if ( get_setting('show_home_banner1_section') == 'on' && get_setting('home_banner1_images') != null)
    <section class="bg-white">
        <div class="container">
            <div class="row gutters-10">
						@php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
            @foreach ($banner_1_imags as $key => $value)
                <div class="col-xl col-md-6">
                    <div class="mb-3">
                        <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }}" class="img-fluid lazyload w-100">
                        </a>
                    </div>
                </div>
						@endforeach
            </div>
        </div>
    </section>
	@endif
	

    


     <!-- packages section   -->

     <section class="py-7 bg-white">

        <div class="container">
        <div class="row">
            <div class="col-xl-8 col-xxl-6 mx-auto">
                <div class="text-center pb-6">
                    <h2 class="fw-600 text-dark">Packages</h2>
                    <div class="fs-16 fw-400">To make your search more discreet &amp; confidential you can opt for premium membership where your profile is kept private during the whole process. Premium members will have the first access to potential matches. However our service and commitment will always be the same for all our members.</div>
                </div>
            </div>
        </div>
          <div class="aiz-carousel" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1" data-dots='true' data-infinite='true' data-autoplay='true'>
                                  <div class="carousel-box">
                      <div class="overflow-hidden shadow-none mb-3 border-right">
                          <div class="card-body">
                              <div class="text-center mb-4 mt-3">
                                  {{-- <img class="mw-100 mx-auto mb-4" src="https://soulmatematrimonial.com.au/public/uploads/all/MOPKqRU0vtcuEIRilD0b4oTGb51EDVmQy3ajt5ZD.png" height="130"> --}}
                                  <img class="mw-100 mx-auto mb-4" src=" {{ url('public/uploads/all/MOPKqRU0vtcuEIRilD0b4oTGb51EDVmQy3ajt5ZD.png') }}" height="130">
                                  <h5 class="mb-3 h5 fw-600">Starter (Free)</h5>
                              </div>
                              <ul class="list-group list-group-raw fs-15 mb-5">
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Register and create profile with photos
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                              Initial phone / video consultation
                                                                        </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      View profiles without any restrictions
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Receive expression of interest
                                  </li>
                                  <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-times text-danger mr-2"></i>
                                          <del class="opacity-60">Send expression of interest</del>
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-times text-danger mr-2"></i>
                                          <del class="opacity-60">Advance &amp; Auto Match finder</del>
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-times text-danger mr-2"></i>
                                          <del class="opacity-60">Number of credits</del>
                                      
                                </li>

                               

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Confidential advertisement on social media</del>
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Will get to see potential matches first</del>
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">We design your structure profile</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Exclusive personalised service</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Photo shoot &amp; Advertisement in Local newspaper at your cost</del>
                                                                        </li>
                                 <!--  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  0 Express Interests
                                                                          </li> -->
                            <!--       <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  15 Galley Photo Upload
                                      
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  0 Contact Info view
                                                                          </li>
                                  <li class="list-group-item py-2 text-line-through">
                                                                                  <i class="las la-times text-danger mr-2"></i>
                                          <del class="opacity-60">Show Auto Profile Match</del>
                                                                          </li> -->
                              </ul>
                              <div class="mb-5 text-dark text-center">
                                                                          <span class="display-4 fw-600 lh-1 mb-0">Free</span>
                                                                      <span class="text-secondary d-block">
                                                                      365 Days
                                                                  </span>
                              </div>
                                    <div class="text-center mb-3">
                                       <button type="submit" onclick="loginModal()" class="btn btn-primary" >Free Registration</button>
                                    </div>
                          </div>
                      </div>
                  </div>
                                  <div class="carousel-box">
                      <div class="overflow-hidden shadow-none mb-3 border-right">
                          <div class="card-body">
                              <div class="text-center mb-4 mt-3">
                                  <img class="mw-100 mx-auto mb-4" src="{{ url('public/uploads/all/WVp4tnmZuwzmUY0DyUQYygrR9t3RYnCQhLCZB0QJ.png') }}" height="130">
                                  <h5 class="mb-3 h5 fw-600">Basic</h5>
                              </div>
                              <ul class="list-group list-group-raw fs-15 mb-5">
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Register and create profile with photos
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                              Initial phone / video consultation
                                                                        </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      View profiles without any restrictions
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Receive expression of interest
                                  </li>
                                  <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Send expression of interest to Free and Basic members
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Advance &amp; Auto Match finder
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      15 Number of credits
                                      
                                </li>

                               

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Confidential advertisement on social media</del>
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Will get to see potential matches first</del>
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">We design your structure profile</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Exclusive personalised service</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Photo shoot &amp; Advertisement in Local newspaper at your cost</del>
                                                                        </li>
                                 <!--  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  15 Express Interests
                                                                          </li> -->
                            <!--       <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  15 Galley Photo Upload
                                      
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  15 Contact Info view
                                                                          </li>
                                  <li class="list-group-item py-2 text-line-through">
                                                                                  <i class="las la-check text-success mr-2"></i>
                                          Show Auto Profile Match
                                                                          </li> -->
                              </ul>
                              <div class="mb-5 text-dark text-center">
                                                                          <span class="display-4 fw-600 lh-1 mb-0">$100</span>
                                                                      <span class="text-secondary d-block">
                                                                      180 Days
                                                                  </span>
                              </div>
                              <div class="text-center mb-3">
                            <button type="submit" onclick="loginModal()" class="btn btn-primary" >Purchase This Package</button>
                                                                                                          </div>
                          </div>
                      </div>
                  </div>
                                  <div class="carousel-box">
                      <div class="overflow-hidden shadow-none mb-3 border-right">
                          <div class="card-body">
                              <div class="text-center mb-4 mt-3">
                                  <img class="mw-100 mx-auto mb-4" src="{{ url('public/uploads/all/3kFhOqwNV61YFwNylNOLodRCXQeZeuv4sU77Ynle.png') }}" height="130">
                                  <h5 class="mb-3 h5 fw-600">Ruby</h5>
                              </div>
                              <ul class="list-group list-group-raw fs-15 mb-5">
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Register and create profile with photos
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                              Initial phone / video consultation
                                                                        </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      View profiles without any restrictions
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Receive expression of interest
                                  </li>
                                  <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Send expression of interest to Free, basic and Ruby members 
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Advance &amp; Auto Match finder
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      75 number of credits
                                      
                                </li>

                               

                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Confidential advertisement on social media
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Will get to see potential matches first
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">We design your structure profile</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Exclusive personalised service</del>
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-times text-danger mr-2"></i>
                                      <del class="opacity-60">Photo shoot &amp; Advertisement in Local newspaper at your cost</del>
                                                                        </li>
                                 <!--  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  75 Express Interests
                                                                          </li> -->
                            <!--       <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  15 Galley Photo Upload
                                      
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  75 Contact Info view
                                                                          </li>
                                  <li class="list-group-item py-2 text-line-through">
                                                                                  <i class="las la-check text-success mr-2"></i>
                                          Show Auto Profile Match
                                                                          </li> -->
                              </ul>
                              <div class="mb-5 text-dark text-center">
                                                                          <span class="display-4 fw-600 lh-1 mb-0">$299</span>
                                                                      <span class="text-secondary d-block">
                                                                      730 Days
                                                                  </span>
                              </div>
                              <div class="text-center mb-3">
                        <button type="submit" onclick="loginModal()" class="btn btn-primary" >Purchase This Package</button>
                                                                                                          </div>
                          </div>
                      </div>
                  </div>
                                  <div class="carousel-box">
                      <div class="overflow-hidden shadow-none mb-3 border-right">
                          <div class="card-body">
                              <div class="text-center mb-4 mt-3">
                                  <img class="mw-100 mx-auto mb-4" src="{{ url('public/uploads/all/3ziR0dmKC4Eq1PXj8uFZEo4RewWmbC0YAuY4wLAj.png') }}" height="130">
                                  <h5 class="mb-3 h5 fw-600">Sterling</h5>
                              </div>
                              <ul class="list-group list-group-raw fs-15 mb-5">
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Register and create profile with photos
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  personalised expert consultation
                                                                        </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      View profiles without any restrictions
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                      Receive expression of interest
                                  </li>
                                  <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Send expression of interest to all members
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Highly discrete &amp; confidential match making
                                      
                                </li>
                                <li class="list-group-item py-2">
                                      
                                                                              <i class="las la-check text-success mr-2"></i>
                                      Unlimited credits
                                      
                                </li>

                               

                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Confidential advertisement on social media
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Will get to see potential matches first
                                                                        </li>

                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      We design your structure profile
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Exclusive personalised service
                                                                        </li>
                                <li class="list-group-item py-2">
                                                                            <i class="las la-check text-success mr-2"></i>
                                      Photo shoot &amp; Advertisement in Local newspaper at your cost
                                                                        </li>
                                 <!--  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  9999 Express Interests
                                                                          </li> -->
                            <!--       <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  20 Galley Photo Upload
                                      
                                  </li>
                                  <li class="list-group-item py-2">
                                      <i class="las la-check text-success mr-2"></i>
                                                                                  9999 Contact Info view
                                                                          </li>
                                  <li class="list-group-item py-2 text-line-through">
                                                                                  <i class="las la-check text-success mr-2"></i>
                                          Show Auto Profile Match
                                                                          </li> -->
                              </ul>
                              <div class="mb-5 text-dark text-center">
                                                                          <span class="display-4 fw-600 lh-1 mb-0">$499</span>
                                                                      <span class="text-secondary d-block">
                                   Valid until we find your partner	
                                                                  </span>
                              </div>
                              <div class="text-center mb-3">
                                                                                                                      <button type="submit" onclick="loginModal()" class="btn btn-primary" >Purchase This Package</button>
                                                                                                          </div>
                          </div>
                      </div>
                  </div>
                          </div>
        </div>
    </section>

   <!-- How It Works Section -->
   @if(get_setting('show_how_it_works_section') == 'on' && get_setting('how_it_works_steps_titles') != null)
    <section class="py-8 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                    <div class="text-center section-title mb-5">
                        <h2 class="fw-600 mb-3">{{ get_setting('how_it_works_title') }}</h2>
                        <p class="fw-400 fs-16 opacity-60">{{ get_setting('how_it_works_sub_title') }}</p>
                    </div>
                </div>
            </div>
            <div class="row gutters-10">
				@php
					$how_it_works_steps_titles = json_decode(get_setting('how_it_works_steps_titles'));
					$step = 1;
				@endphp
	            @foreach ($how_it_works_steps_titles as $key => $how_it_works_steps_title)
	               <div class="col-lg">
	                    <div class="border p-3 mb-3">
							<div class=" row align-items-center">
								<div class="col-7">
									<div class="text-primary fw-600 h1">{{ $step++ }}</div>
									<div class="text-secondary fs-20 mb-2 fw-600">{{ $how_it_works_steps_title }}</div>
									<div class="fs-15 opacity-60">{{ json_decode(get_setting('how_it_works_steps_sub_titles'), true)[$key] }}</div>
								</div>
								<div class="mt-3 col-5 text-right">
									<img src="{{ uploaded_asset(json_decode(get_setting('how_it_works_steps_icons'), true)[$key]) }}" class="img-fluid h-80px">
								</div>
							</div>
	                    </div>
	                </div>
				@endforeach
            </div>
        </div>
    </section>
	@endif


	
	
	<!-- Trusted by Millions Section -->
    @if(get_setting('show_trusted_by_millions_section') == 'on')
    <section class="bg-center bg-cover min-vh-100 py-8 text-white d-flex align-items-center bg-fixed" style="background-image: url('{{ uploaded_asset(get_setting('trusted_by_millions_background_image')) }}')">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="text-center pb-12">
                        <h2 class="fw-600">{{ get_setting('trusted_by_millions_title') }}</h2>
                        <div class="fs-16 fw-400">{{ get_setting('trusted_by_millions_sub_title') }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
				@php
					$homepage_best_features = json_decode(get_setting('homepage_best_features'));
				@endphp
				@if(!empty($homepage_best_features))
					@foreach ($homepage_best_features as $key => $homepage_best_feature)
		                <div class="col-lg">
		                    <div class="border rounded position-relative z-1 border-gray-600 overflow-hidden mt-4">
		                        <div class="absolute-full bg-dark opacity-60 z--1"></div>
		                        <div class="px-4 py-5 d-flex align-items-center justify-content-center">
		                            <img src="{{ uploaded_asset(json_decode(get_setting('homepage_best_features_icons'), true)[$key]) }}" class="img-fluid h-20px">
		                            <span class="fs-17 ml-2">{{ $homepage_best_feature }}</span>
		                        </div>
		                    </div>
		                </div>
					@endforeach
				@endif
            </div>
        </div>
    </section>
	@endif
		
	


	<!-- New Member Section -->
			<section class="py-2 bg-white">
	        </section>
	
	<!-- happy Story Section -->
    @if(get_setting('show_happy_story_section') == 'on')
    <section class="py-7 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                    <div class="text-center section-title mb-5">
                        <h2 class="fw-600 mb-3">{{ translate('Happy stories') }}</h2>
                    </div>
                </div>
            </div>
            <div class="card-columns column-gap-10 card-columns-xxl-4 card-columns-lg-3 card-columns-md-2 card-columns-1">
              @php $happy_stories = \App\Models\HappyStory::where('approved', '1')->latest()->limit(get_setting('max_happy_story_show_homepage'))->get(); @endphp
                @foreach ($happy_stories as $key => $happy_story)
                  @php
                      $photo = explode(',',$happy_story->photos);
                  @endphp
                  <div class="card border-gray-800 overflow-hidden mb-2">
                      <a href="{{ route('story_details', $happy_story->id) }}" class="text-reset d-block position-relative">
                          <img src="{{ uploaded_asset($photo[0]) }}" class="img-fluid">
                          <div class="absolute-bottom-left p-3">
                              <div class="position-relative z-1 p-3">
                                  <div class="absolute-full z--1 bg-dark opacity-60"></div>
                                  <div class="text-primary text-truncate">{{ $happy_story->user->first_name.' & '.$happy_story->partner_name }}</div>
                                  <h2 class="h5 mb-0 fs-14 fw-400 lh-1-5 text-truncate-3">
                                          {{ $happy_story->title }}
                                  </h2>
                              </div>
                          </div>
                      </a>
                  </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('happy_stories') }}" class="btn btn-primary">{{ translate('View More') }}</a>
            </div>
        </div>
    </section>
        @endif
	

	 
      @section('modal')
      @include('modals.login_modal')
      @include('modals.package_update_alert_modal')
      @endsection  
<!-- footer section -->

@section('script')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
		function loginModal(){
			$('#LoginModal').modal();
		}

        function package_update_alert(){
          $('.package_update_alert_modal').modal('show');
        }
		// making the CAPTCHA  a required field for form submission
		@if(get_setting('google_recaptcha_activation') == 1)
				$(document).ready(function(){
				$("#reg-form").on("submit", function(evt)
				{
					var response = grecaptcha.getResponse();
					if(response.length == 0)
					{
						//reCaptcha not verified
						alert("please verify you are humann!");
						evt.preventDefault();
						return false;
					}
					//captcha verified
					//do the rest of your validations here
					$("#reg-form").submit();
				});
		});
		@endif


    var isPhoneShown = true,
        countryData = window.intlTelInputGlobals.getCountryData(),
        input = document.querySelector("#phone-code");

    for (var i = 0; i < countryData.length; i++) {
        var country = countryData[i];
        if(country.iso2 == 'bd'){
            country.dialCode = '88';
        }
    }

    var iti = intlTelInput(input, {
    	initialCountry: "auto",
		geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				var countryCode = (resp && resp.country) ? resp.country : "us";
				callback(countryCode);
			});
		},
        separateDialCode: true,
        utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
        onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            if(selectedCountryData.iso2 == 'bd'){
                return "01xxxxxxxxx";
            }
            return selectedCountryPlaceholder;
        }
    });

    var country = iti.getSelectedCountryData();
    $('input[name=country_code]').val(country.dialCode);

    input.addEventListener("countrychange", function(e) {
        // var currentMask = e.currentTarget.placeholder;

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

    });

	// function toggleEmailPhone(el){
	//     if(isPhoneShown){
	//         $('.phone-form-group').addClass('d-none');
	//         $('.email-form-group').removeClass('d-none');
	//         isPhoneShown = false;
	//         $(el).html('{{ translate('Use Phone Instead') }}');
	//     }
	//     else{
	//         $('.phone-form-group').removeClass('d-none');
	//         $('.email-form-group').addClass('d-none');
	//         isPhoneShown = true;
	//         $(el).html('{{ translate('Use Email Instead') }}');
	//     }
	// }
</script>
@endsection


