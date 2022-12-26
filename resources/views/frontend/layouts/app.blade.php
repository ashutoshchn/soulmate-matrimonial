@php
if(Session::has('locale')){
$locale = Session::get('locale', Config::get('app.locale'));
}
else{
$locale = env('DEFAULT_LANGUAGE');
}
$lang = \App\Models\Language::where('code', $locale)->first();
@endphp

<!DOCTYPE html>
@if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
<html dir="rtl" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@else
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@endif

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <!-- Title -->
    <title>@yield('meta_title', get_setting('website_name').' | '.get_setting('site_motto'))</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', get_setting('meta_description'))" />
    <meta name="keywords" content="@yield('meta_keywords', get_setting('meta_keywords'))">

    @yield('meta')

    @if(!isset($page))
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ config('app.name', env('APP_NAME')) }}">
    <meta itemprop="description" content="{{ get_setting('meta_description') }}">
    <meta itemprop="image" content="{{ uploaded_asset( get_setting('meta_image') ) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ config('app.name', env('APP_NAME')) }}">
    <meta name="twitter:description" content="{{ get_setting('meta_description') }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset( get_setting('meta_image')) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ config('app.name', env('APP_NAME')) }}" />
    <meta property="og:type" content="Business Site" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}" />
    <meta property="og:description" content="{{ get_setting('meta_description') }}" />
    <meta property="og:site_name" content="{{ get_setting('website_name') }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">

    @endif

    <!-- Favicon -->
    <link rel="icon" href="{{ uploaded_asset(get_setting('site_icon')) }}">

    <!-- CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Alex+Brush:300,400,500,600,700,800&display=swap">
    <link rel="stylesheet" href="{{ static_asset('assets/css/vendors.css') }}">
    <link rel="stylesheet" href="{{ static_asset('assets/css/aiz-core.css') }}">

    @if(\App\Models\Language::where('code', Session::get('locale', Config::get('app.locale')))->first()->rtl == 1)
    <link rel="stylesheet" href="{{ static_asset('assets/css/bootstrap-rtl.min.css') }}">
    @endif

    <script>
        var AIZ = AIZ || {};
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            color: #6d6e6f;
        }

        :root {
            --primary: {{ get_setting('base_color', '#FD2C79') }};
            --hov-primary: {{ get_setting('base_hov_color', '#0069d9') }};
            --soft-primary: {{ hex2rgba(get_setting('base_hov_color', '#377dff'), .15) }} ;
            --secondary: {{ get_setting('secondary_color', '#FD655B') }};
            --soft-secondary: {{ hex2rgba(get_setting('secondary_color', '#FD655B'), .15) }};
        }

        .text-primary-grad {
            background: rgb(253, 41, 123);
            background: -moz-linear-gradient(0deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
            background: -webkit-linear-gradient(0deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
            background: linear-gradient(0deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary,
        .bg-primary-grad {
            background: rgb(253, 41, 123);
            background: -moz-linear-gradient(225deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
            background: -webkit-linear-gradient(225deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
            background: linear-gradient(225deg, {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }} 0%, {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }} 100%);
        }

        .fill-dark {
            fill: #4d4d4d;
        }

        .fill-primary-grad stop:nth-child(1) {
            stop-color: {{ hex2rgba(get_setting('secondary_color', '#FD655B'), 1) }};
        }

        .fill-primary-grad stop:nth-child(2) {
            stop-color: {{ hex2rgba(get_setting('base_color', '#FD2C79'), 1) }};
        }

         /* Header */


         #name1{
            margin-left: 5px;
        }

        #log{
            margin-top: -46px;
        }
        /* according */

        #f23{
            color: black;
			font-size: 2rem;
        }

        #a1,#a3,#a4,#a5,#a6,#a7,#a8{
            color: black;
			font-size: 1rem;
        }
		
		#sba1,#sba3,#sba4,#sba5,#sba6,#sba7,#sba8{
			font-size: 1rem;
		}

        #ab3{
                    background-color: white;
            height: 78px;
            border: var(--bs-accordion-border-width) solid var(--bs-accordion-border-color);
            margin-top: 1px;
            padding-top: 25px;
            margin-top: 7px;
                }
        

                /* photo section */


        .lf-txt{  font-size: 15px;
            color: #fff;
            z-index: 9;
            margin-top: -80px;
            text-align: center;
            letter-spacing: 0.8px;
        }

        #pss{
                    margin-top: 0px;
                margin-bottom: -900px;
                }


        #news1{
            margin-left: 480px;
            width: 457px;
            margin-left: 90px;

        }

        .paddt10 {
            padding-top: 10px;
        }



        .bmt{
            font-size: 20px; font-weight: 700;display:inline;
        }


        #imgc{
            width: 400px;padding-top: 50px
        }

        .img-fluid {
            margin-top: 91px;
            border-radius: 15px;
        }


        #pcol{
            margin-top: 85px;
        }


        #head{
            font-size: 30px;
            font-weight: 700;
            letter-spacing: 1.6px;
        }

        #pictx{
            line-height: 24px;
            font-size: 16px;
            letter-spacing: .96px;
            padding-top: 10px;
        }

        #list{
            line-height: 34px;
            margin-left: -15px;
            font-size: 16px;
            letter-spacing: .6px;

        }

        .regfreebtn {
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            background: #bb0a24;
            color: #fff;
            cursor: pointer;
            padding: 6px 3px 8px 2px;
            border: none!important;
            display: inline-block;
            font-family: Lato;
            outline: medium none;
            text-decoration: none;
            font-size: 12px;
            border-radius: 10px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-weight: 700;
        }

        #hc1{
            padding-right: 61px;

        }


        #hc2{
            
            padding-right: 43px;
            padding-left: -18px;

        }

        #hc3{
            
            padding-left: 8px;
            padding-right: 50px;

        }


        #pltx{
            
            margin-bottom: -148px;

        }

        #py {
            margin-top: -105px;
            margin-bottom: -63px;
        }





/* media query 1 */

@media (max-width:1400px) {

	#pss {
    margin-top: 0px;
    margin-bottom: -847px;

	}

	#news1 {
    margin-left: 480px;
    width: 457px;
    margin-left: 138px;
}

	
}
 
 
@media (max-width:1200px) {

	#pss{
		margin-top: 0px;
    margin-bottom: -708px;
	}

	
} 




/* md 5 */

@media (max-width:993px) {


	#pss {
    margin-top: 0px;
    margin-bottom: -516px;
	}
	
}



/* mq  */

@media (max-width:768px) {

            #pss {
            margin-top: 0px;
            margin-bottom: -387px;
        }

        #news1 {
            margin-left: 480px;
            width: 337px;
            margin-left: 94px;
        }

        #nm{
            margin-top: -71px;
        }


        #l2 {
            width: 295px;
        }




}




@media (max-width:498px) {
	#reversecol{
		display: flex ;
		flex-direction: column-reverse;
	}
			
}




/* mq */

@media (max-width:436px) {
				#news1 {
				width: 255px;
				margin-left: 74px;
			}



			#pstx{
				
				width: 112%;
				font-size: 12px !important;
			}


			#pss {
				margin-top: 0px;
				margin-bottom: -315px;
			}

    

}








/* mq */

@media (max-width:380px) {

				#pss {
				margin-top: 0px;
				margin-bottom: -264px;
			}

			#ss{
				margin-top: -37px;
			}

			#nm{
				margin-top: -82px;
			}

			#news1 {
				width: 255px;
				margin-left: 40px;
			}



	
	}

        /* margin in footer */

        @media (max-width:575px) {
            .mb-4 {
            margin-left: -7px;
        }

            #con{
                padding-left: 19px;

            }

            #sa{
                
            margin-left: 31px;

            }

            #ad,#wb,#em,#ph{
            margin-left: 9px;
        }


    }
    </style>

    @if (get_setting('google_analytics_activation') == 1)
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ env('GOOGLE_ANALYTICS_TRACKING_ID') }}');
    </script>
    @endif

    @if (get_setting('facebook_pixel_activation') == 1)
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', {{ env('FACEBOOK_PIXEL_ID') }});
          fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={{ env('FACEBOOK_PIXEL_ID') }}/&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Facebook Pixel Code -->
    @endif

    {!! get_setting('header_script') !!}

</head>

<body class="text-left">

    <div class="aiz-main-wrapper d-flex flex-column position-relative @if(Route::currentRouteName() != 'home') pt-8 pt-lg-10 @endif bg-white">

        @include('frontend.inc.header')

        @yield('content')

        @include('frontend.inc.footer')

    </div>


   <!--  @if (get_setting('show_cookies_agreement') == 'on')
        <div class="aiz-cookie-alert shadow-xl">
            <div class="p-3 bg-dark rounded">
                <div class="text-white mb-3">
                    @php
                        echo get_setting('cookies_agreement_text');
                    @endphp
                </div>
                <button class="btn btn-primary aiz-cookie-accepet">
                    {{ translate('Ok. I Understood') }}
                </button>
            </div>
        </div>
    @endif -->

    @yield('modal')

    <div class="modal fade account_status_change_modal" id="modal-zoom">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <form class="form-horizontal member-block" action="{{ route('member.account_deactivation') }}" method="POST">
                        @csrf
                        <input type="hidden" name="deacticvation_status" id="deacticvation_status" value="">
                        <h4 class="modal-title h6 mb-3" id="confirmation_note" value=""></h4>
                        <hr>
                        <button type="submit" class="btn btn-primary mt-2">{{translate('Yes')}}</button>
                        <button type="button" class="btn btn-danger mt-2" data-dismiss="modal">{{translate('No')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (get_setting('facebook_chat_activation') == 1)
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v3.3'
            });
            };

            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="fb-root"></div>
    <!-- Your customer chat code -->
    <div class="fb-customerchat" attribution=setup_tool page_id="{{ env('FACEBOOK_PAGE_ID') }}">
    </div>
    @endif

    <script src="{{ static_asset('assets/js/vendors.js') }}"></script>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}"></script>

    @yield('script')

    <script type="text/javascript">
        @foreach (session('flash_notification', collect())->toArray() as $message)
  	       AIZ.plugins.notify('{{ $message['level'] }}', '{{ $message['message'] }}');
  	    @endforeach

        @if(Auth::check() && Auth::user()->user_type == 'member')
          function account_deactivation(){
            var status = {{ Auth::user()->deactivated }}
            $('.account_status_change_modal').modal('show');
            if(status == 0)
            {
                $('#deacticvation_status').val(1);
                $('#confirmation_note').html('{{ translate('Do You Realy Want To Deactive Your Account') }}');
            }
            else {
                $('#deacticvation_status').val(0);
                $('#confirmation_note').html('{{ translate('Are You Sure To Reactive Your Account') }}');
            }
          }
        @endif


    </script>

    
    @if (env("DEMO_MODE") == "On")
        <script type="text/javascript">
            // Login credentials autoFill for demo
            function autoFill1(){
                $('#email').val('user2@example.com');
                $('#password').val('12345678');
            }
            function autoFill2(){
                $('#email').val('user17@example.com');
                $('#password').val('12345678');
            }
        </script>
    @endif

    {!! get_setting('footer_script') !!}

</body>

</html>
