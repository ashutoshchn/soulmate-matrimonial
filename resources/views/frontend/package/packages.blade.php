@extends('frontend.layouts.app')
@section('content')
<section class="pt-6 pb-4 bg-white text-center">
    <div class="container">
        <h1 class="mb-0 fw-600 text-dark">{{ translate('Select Your Package') }}</h1>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <div class="aiz-carousel" data-arrows='true' data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1" data-dots='true' data-infinite='true' data-autoplay='true'>
            @foreach ($packages as $key => $package)
                <div class="carousel-box">
                    <div class="overflow-hidden shadow-none border-right">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                <img class="mw-100 mx-auto mb-4" src="{{ uploaded_asset($package->image) }}" height="130">
                                <h5 class="mb-3 h5 fw-600">{{$package->name}}</h5>
                            </div>
                            <ul class="list-group list-group-raw fs-15 mb-5">
									<li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										{{'Register and create profile with photos' }}
			                        </li>
									<li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										@if ($package->id == 4)
				                            {{ "personalised expert consultation" }}
										@else
										{{'Initial phone / video consultation'}}
										@endif
						          </li>
									<li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										{{"View profiles without any restrictions"}}
			                        </li>
									<li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										{{"Receive expression of interest"}}
			                        </li>
									<li class="list-group-item py-2">
			                            
										@if ($package->id == 1)
										<i class="las la-times text-danger mr-2"></i>
			                                <del class="opacity-60">{{ translate('Send expression of interest') }}</del>
										@elseif ($package->id==2)
										<i class="las la-check text-success mr-2"></i>
										{{'Send expression of interest to Free and Basic members' }}
										@elseif ($package->id==3)
										<i class="las la-check text-success mr-2"></i>
										{{'Send expression of interest to Free, basic and Ruby members '}}
										@elseif ($package->id==4)
										<i class="las la-check text-success mr-2"></i>
										{{'Send expression of interest to all members'}}
										@endif

						          </li>
								  <li class="list-group-item py-2">
			                            
										@if ($package->id == 1)
										<i class="las la-times text-danger mr-2"></i>
			                                <del class="opacity-60">{{ translate('Advance & Auto Match finder') }}</del>
										@elseif ($package->id==2)
										<i class="las la-check text-success mr-2"></i>
										{{'Advance & Auto Match finder' }}
										@elseif ($package->id==3)
										<i class="las la-check text-success mr-2"></i>
										{{'Advance & Auto Match finder'}}
										@elseif ($package->id==4)
										<i class="las la-check text-success mr-2"></i>
										{{'Highly discrete & confidential match making'}}
										@endif

						          </li>
								  <li class="list-group-item py-2">
			                            
										@if ($package->id == 1)
										<i class="las la-times text-danger mr-2"></i>
			                                <del class="opacity-60">{{ translate('Number of credits') }}</del>
										@elseif ($package->id==2)
										<i class="las la-check text-success mr-2"></i>
										{{'15 Number of credits' }}
										@elseif ($package->id==3)
										<i class="las la-check text-success mr-2"></i>
										{{'75 number of credits'}}
										@elseif ($package->id==4)
										<i class="las la-check text-success mr-2"></i>
										{{'Unlimited credits'}}
										@endif

						          </li>

								 

								  <li class="list-group-item py-2">
									  @if ($package->id >= 3)
			                            <i class="las la-check text-success mr-2"></i>
									    {{ "Confidential advertisement on social media" }}
										@else
										<i class="las la-times text-danger mr-2"></i>
										<del class="opacity-60">{{'Confidential advertisement on social media'}}</del>
										@endif
						          </li>

								  <li class="list-group-item py-2">
									  @if ($package->id >= 3)
			                            <i class="las la-check text-success mr-2"></i>
									    {{ "Will get to see potential matches first" }}
										@else
										<i class="las la-times text-danger mr-2"></i>
										<del class="opacity-60">{{'Will get to see potential matches first'}}</del>
										@endif
						          </li>

								  <li class="list-group-item py-2">
									  @if ($package->id == 4)
			                            <i class="las la-check text-success mr-2"></i>
									    {{ "We design your structure profile" }}
										@else
										<i class="las la-times text-danger mr-2"></i>
										<del class="opacity-60">{{'We design your structure profile'}}</del>
										@endif
						          </li>
								  <li class="list-group-item py-2">
									  @if ($package->id == 4)
			                            <i class="las la-check text-success mr-2"></i>
									    {{ "Exclusive personalised service" }}
										@else
										<i class="las la-times text-danger mr-2"></i>
										<del class="opacity-60">{{'Exclusive personalised service'}}</del>
										@endif
						          </li>
								  <li class="list-group-item py-2">
									  @if ($package->id == 4)
			                            <i class="las la-check text-success mr-2"></i>
									    {{ "Photo shoot & Advertisement in Local newspaper at your cost" }}
										@else
										<i class="las la-times text-danger mr-2"></i>
										<del class="opacity-60">{{'Photo shoot & Advertisement in Local newspaper at your cost'}}</del>
										@endif
						          </li>
			                       <!--  <li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										@if ($package->express_interest >= 99999999)
				                            {{ translate('Unlimited') }} {{ translate('Express Interests') }}
										@else
											{{ $package->express_interest }} {{ translate('Express Interests') }}
										@endif
			                        </li> -->
			                  <!--       <li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										@if ($package->photo_gallery >= 99999999)
				                            {{ translate('Unlimited') }} {{ translate('Galley Photo Upload') }}
										@else
											{{ $package->photo_gallery }} {{ translate('Galley Photo Upload') }}
										@endif

			                        </li>
			                        <li class="list-group-item py-2">
			                            <i class="las la-check text-success mr-2"></i>
										@if ($package->contact >= 99999999)
				                            {{ translate('Unlimited') }} {{ translate('Contact Info View') }}
										@else
			                            	{{ $package->contact }} {{ translate('Contact Info View') }}
										@endif
			                        </li>
			                        <li class="list-group-item py-2 text-line-through">
			                            @if( $package->auto_profile_match == 0 )
			                                <i class="las la-times text-danger mr-2"></i>
			                                <del class="opacity-60">{{ translate('Show Auto Profile Match') }}</del>
			                            @else
			                                <i class="las la-check text-success mr-2"></i>
			                                {{ translate('Show Auto Profile Match') }}
			                            @endif
			                        </li> -->
			                    </ul>
			                    <div class="mb-5 text-dark text-center">
			                        @if ($package->id == 1)
			                            <span class="display-4 fw-600 lh-1 mb-0">{{ translate('Free') }}</span>
			                        @else
			                            <span class="display-4 fw-600 lh-1 mb-0">{{single_price($package->price)}}</span>
			                        @endif
			                        <span class="text-secondary d-block">
									@if($package->validity>=9999) {{translate('Valid until we find your partner')}}	
									@elseif($package->validity<=9) {{translate('')}}	
									@else
									{{$package->validity}} {{translate('Days')}}
									@endif
								</span>
                            
                            </div>
                            <div class="text-center">
                                @if ($package->id != 1)
                                    @if(Auth::check())
                                        <a href="{{ route('package_payment_methods', encrypt($package->id)) }}" type="submit" class="btn btn-primary" >{{translate('Purchase This Package')}}</a>
                                    @else
                                        <button type="submit" onclick="loginModal()" class="btn btn-primary" >{{translate('Purchase This Package')}}</button>
                                    @endif
                                @else
                                    <!-- <a href="javascript:void(0);" class="btn btn-light" ><del>{{translate('Purchase This Package')}}</del></a> -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('modal')
    @include('modals.login_modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
<script type="text/javascript">

	// Login alert
    function loginModal(){
        $('#LoginModal').modal();
    }

    // Package update alert
    function package_update_alert(){
      $('.package_update_alert_modal').modal('show');
    }

</script>
@endsection
