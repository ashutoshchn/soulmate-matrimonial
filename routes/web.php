<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//demo
Route::get('/demo/cron_1', 'DemoController@cron_1');
Route::get('/demo/cron_2', 'DemoController@cron_2');

Auth::routes();

//Home Page
Route::get('/', 'HomeController@index')->name('index');
Route::get('/', 'HomeController@index')->name('home');

// Uploader
Route::get('/refresh-csrf', function(){
    return csrf_token();
});
Route::post('/aiz-uploader', 'AizUploadController@show_uploader');
Route::post('/aiz-uploader/upload', 'AizUploadController@upload');
Route::get('/aiz-uploader/get_uploaded_files', 'AizUploadController@get_uploaded_files');
Route::delete('/aiz-uploader/destroy/{id}', 'AizUploadController@destroy');
Route::post('/aiz-uploader/get_file_by_ids', 'AizUploadController@get_preview_files');
Route::get('/aiz-uploader/download/{id}', 'AizUploadController@attachment_download')->name('download_attachment');
Route::get('/migrate/database', 'AizUploadController@migrate_database');

Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
Route::get('/verification-confirmation/{code}', 'Auth\VerificationController@verification_confirmation')->name('email.verification.confirmation');
Route::get('/email_change/callback', 'HomeController@email_change_callback')->name('email_change.callback');
Route::post('/password/reset/email/submit', 'HomeController@reset_password_with_code')->name('password.update');


Route::get('/users/login', 'HomeController@login')->name('user.login');
Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::get('/users/blocked', 'HomeController@user_account_blocked')->name('user.blocked');

Route::post('/language', 'LanguageController@changeLanguage')->name('language.change');
Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');


Route::get('/packages', 'PackageController@select_package')->name('packages');
Route::get('/happy-stories','HomeController@happy_stories')->name('happy_stories');
Route::get('/story_details/{id}','HomeController@story_details')->name('story_details');

Route::group(['middleware' => ['member','verified']], function(){

    Route::any('/member-listing', 'HomeController@member_listing')->name('member.listing');

    Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
    Route::post('/new-user-email', 'HomeController@update_email')->name('user.change.email');
    Route::post('/new-user-email-new', 'HomeController@update_email_new')->name('user.change.email_new');
    Route::post('/new-user-verification', 'HomeController@new_verify')->name('user.new.verify');


    Route::get('/profile-settings', 'MemberController@profile_settings_new')->name('profile_settings');
    Route::get('/profile-settings-old', 'MemberController@profile_settings')->name('profile_settings_old');
    Route::get('/package-payment-methods/{id}', 'PackageController@package_payemnt_methods')->name('package_payment_methods');
    Route::post('/package-payment','PackagePaymentController@store')->name('package.payment');

    Route::get('/package-purchase-history', 'PackagePaymentController@package_purchase_history')->name('package_purchase_history');

    Route::get('/member-profile/{id}', 'HomeController@view_member_profile')->name('member_profile');

    // Password Change
    Route::get('/members/change-password', 'MemberController@change_password')->name('member.change_password');
    Route::post('/member/password-update/{id}', 'MemberController@password_update')->name('member.password_update');

    // Member Picture privacy
    Route::get('/members/picture-privacy', 'MemberController@picture_privacy')->name('member.picture_privacy');
    Route::post('/member/update-picture-privacy/{id}', 'MemberController@update_picture_privacy')->name('member.update_picture_privacy');

    // Gallery Image
    Route::resource('/gallery-image', 'GalleryImageController');
    Route::get('/gallery_image/destroy/{id}','GalleryImageController@destroy')->name('gallery_image.destroy');

    // Account deacticvation
    Route::post('/member/account-activation', 'MemberController@update_account_deactivation_status')->name('member.account_deactivation');


    // Express Interest
    Route::resource('/express-interest', 'ExpressInterestController');
    Route::get('/my-interests', 'ExpressInterestController@index')->name('my_interests.index');
    Route::get('/interest/requests', 'ExpressInterestController@interest_requests')->name('interest_requests');
    Route::post('/interest/accept', 'ExpressInterestController@accept_interest')->name('accept_interest');
    Route::post('/interest/reject', 'ExpressInterestController@reject_interest')->name('reject_interest');

    // Chat
    Route::get('/chat', 'ChatController@index')->name('all.messages');
    Route::get('/single-chat/{id}', 'ChatController@chat_view')->name('chat_view');
    Route::post('/chat-reply', 'ChatController@chat_reply')->name('chat.reply');
    Route::get('/chat/refresh/{id}', 'ChatController@chat_refresh')->name('chat_refresh');
    Route::post('/chat/old-messages', 'ChatController@get_old_messages')->name('get-old-message');


    // ShortList list, Add, Remove
    Route::get('/my-shortlists', 'ShortlistController@index')->name('my_shortlists');
    Route::post('/member/add-to-shortlist', 'ShortlistController@create')->name('member.add_to_shortlist');
    Route::post('/member/remove-from-shortlist', 'ShortlistController@remove')->name('member.remove_from_shortlist');

    // Ignore list, Add, Remove
    Route::get('/ignored-list', 'IgnoredUserController@index')->name('my_ignored_list');
    Route::post('/member/add-to-ignore-list', 'IgnoredUserController@add_to_ignore_list')->name('member.add_to_ignore_list');
    Route::post('/member/remove-from-ignored-list', 'IgnoredUserController@remove_from_ignored_list')->name('member.remove_from_ignored_list');

    Route::resource('reportusers', 'ReportedUserController');
    Route::resource('view_contacts', 'ViewContactController');

    // Wallet
    Route::get('/wallet', 'WalletController@index')->name('wallet.index');
    Route::get('/wallet-recharge-methods', 'WalletController@wallet_recharge_methods')->name('wallet.recharge_methods');
    Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');


    Route::get('/member/notifications','NotificationController@frontend_notify_listing')->name('frontend.notifications');

});

Route::group(['middleware' => ['auth']], function () {
    // member info edit
    Route::post('/members/introduction_update/{id}', 'MemberController@introduction_update')->name('member.introduction.update');
    Route::post('/members/send_admin_approval/{id}', 'MemberController@send_admin_approval')->name('member.send_admin_approval');
    Route::post('/members/send_admin_approval_new/{id}', 'MemberController@send_admin_approval_new')->name('member.send_admin_approval_new');
    Route::post('/members/basic_info_update/{id}', 'MemberController@basic_info_update')->name('member.basic_info_update');
    Route::post('/members/basic_info_update_new/{id}', 'MemberController@basic_info_update_new')->name('member.basic_info_update_new');
    Route::post('/members/language_info_update/{id}', 'MemberController@language_info_update')->name('member.language_info_update');
    Route::post('/members/language_info_update_new/{id}', 'MemberController@language_info_update_new')->name('member.language_info_update_new');

    Route::resource('/address','AddressController');
    // Route::post('/address/create', 'AddressController@create')->name('address.create');
    // Route::post('/address/edit', 'AddressController@edit')->name('address.edit');
    // Route::post('/address/update/{id}','AddressController@update')->name('address.update');
     Route::patch('/address/update_new/{id}','AddressController@update_new')->name('address.update_new');
    // Route::get('/address/destroy/{id}','AddressController@destroy')->name('address.destroy');

    // Member education
    Route::resource('/education','EducationController');
    Route::post('/education/create', 'EducationController@create')->name('education.create');
    Route::post('/education/edit', 'EducationController@edit')->name('education.edit');
    Route::post('/education/update_education_present_status','EducationController@update_education_present_status')->name('education.update_education_present_status');
    Route::get('/education/destroy/{id}','EducationController@destroy')->name('education.destroy');
    Route::post('/education/create_new', 'EducationController@create_new')->name('education.create_new');
    Route::post('/education/edit_new', 'EducationController@edit_new')->name('education.edit_new');
    Route::post('/education/store_new','EducationController@store_new')->name('education.store_new');
    Route::post('/education/done_new','EducationController@done_new')->name('education.done_new');
    Route::patch('/education/update_new/{id}','EducationController@update_new')->name('education.update_new');

    // Member Career
    Route::resource('/career','CareerController');
    Route::post('/career/create', 'CareerController@create')->name('career.create');
    Route::post('/career/edit', 'CareerController@edit')->name('career.edit');
    Route::post('/career/update_career_present_status','CareerController@update_career_present_status')->name('career.update_career_present_status');
    Route::post('/career/create_new', 'CareerController@create_new')->name('career.create_new');
    Route::post('/career/store_new','CareerController@store_new')->name('career.store_new');
    Route::post('/career/edit_new', 'CareerController@edit_new')->name('career.edit_new');
    Route::post('/career/done_new','CareerController@done_new')->name('career.done_new');
    Route::get('/career/destroy/{id}','CareerController@destroy')->name('career.destroy');

    Route::resource('/physical-attribute','PhysicalAttributeController');
    Route::patch('/physical-attribute/update_new/{id}','PhysicalAttributeController@update_new')->name('physical-attribute.update_new');
    Route::resource('/hobbies','HobbyController');
    Route::patch('/hobbies/update_new/{id}','HobbyController@update_new')->name('hobbies.update_new');
    Route::resource('/attitudes','AttitudeController');
    Route::resource('/recidencies','RecidencyController');
    Route::patch('/recidencies/update_new/{id}','RecidencyController@update_new')->name('recidencies.update_new');

    Route::resource('/lifestyles','LifestyleController');
    Route::patch('/lifestyles/update_new/{id}','LifestyleController@update_new')->name('lifestyles.update_new');
    Route::resource('/astrologies','AstrologyController');
    Route::patch('/astrologies/update_new/{id}','AstrologyController@update_new')->name('astrologies.update_new');
    Route::resource('/families','FamilyController');
    Route::patch('/families/update_new/{id}','FamilyController@update_new')->name('families.update_new');
    Route::resource('/spiritual_backgrounds','SpiritualBackgroundController');
    Route::patch('/spiritual_backgrounds/update_new/{id}','SpiritualBackgroundController@update_new')->name('spiritual_backgrounds.update_new');
    Route::resource('/partner_expectations','PartnerExpectationController');
    Route::patch('/partner_expectations/update_new/{id}','PartnerExpectationController@update_new')->name('partner_expectations.update_new');

    Route::post('/states/get_state_by_country', 'StateController@get_state_by_country')->name('states.get_state_by_country');
    Route::post('/cities/get_cities_by_state', 'CityController@get_cities_by_state')->name('cities.get_cities_by_state');
    Route::post('/castes/get_caste_by_religion', 'CasteController@get_caste_by_religion')->name('castes.get_caste_by_religion');
    Route::post('/sub-castes/get_sub_castes_by_religion', 'SubCasteController@get_sub_castes_by_religion')->name('sub_castes.get_sub_castes_by_religion');

    Route::get('/package-payment-invoice/{id}', 'PackagePaymentController@package_payment_invoice')->name('package_payment.invoice');

    Route::resource('/happy-story','HappyStoryController');

    Route::get('/notification-view/{id}','NotificationController@notification_view')->name('notification_view');
});

// Payment gateway Redirect

//Paypal START
Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel');
//Paypal END

Route::get('/instamojo/payment/pay-success', 'InstamojoController@success')->name('instamojo.success');
Route::post('rozer/payment/pay-success', 'RazorpayController@payment')->name('payment.rozer');

//Stipe Start
Route::get('stripe', 'StripeController@stripe');
Route::post('/stripe/create-checkout-session', 'StripeController@create_checkout_session')->name('stripe.get_token');
Route::any('/stripe/payment/callback', 'StripeController@callback')->name('stripe.callback');
Route::get('/stripe/success', 'StripeController@success')->name('stripe.success');
Route::get('/stripe/cancel', 'StripeController@cancel')->name('stripe.cancel');
//Stripe END

Route::get('/customer-products/admin', 'HomeController@profile_edit')->name('profile.edit');
Route::get('/check_for_package_invalid', 'PackageController@check_for_package_invalid')->name('member.check_for_package_invalid');

Route::get('/match_profiles', 'ProfileMatchController@match_profiles')->name('match_profiles');
Route::get('/migrate/products/', 'ProfileMatchController@migrate_profiles');

Route::get('/check', 'HomeController@check');
Route::get('/permissions', 'HomeController@permissions');

//Custom page
Route::get('/{slug}', 'PageController@show_custom_page')->name('custom-pages.show_custom_page');
