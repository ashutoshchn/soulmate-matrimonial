<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartnerExpectation;
use App\Models\Member;
use App\Models\PhysicalAttribute;
use App\Models\SpiritualBackground;
use App\Mail\SecondEmailVerifyMailManager;
use App\Models\Education;
use App\Models\Career;
use App\Models\Address;
use App\Models\Lifestyle;
use App\Models\HappyStory;
use App\Models\IgnoredUser;
use App\Models\ProfileMatch;
use App\Models\DietType;
use App\User;
use Auth;
use Validator;
use Redirect;
use App\Utility\AdminNotificationUtility;

class PartnerExpectationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, $id)
     { 
         $this->rules = [
             'general'                      => [ 'max:255'],
             'partner_height'               => [ 'max:50'],
            //  'partner_weight'               => [ 'max:50'],
            //  'partner_children_acceptable'  => [ 'max:20'],
             'pertner_education'            => [ 'max:255'],
             'partner_profession'           => [ 'max:50'],
             'smoking_acceptable'           => [ 'max:20'],
             'drinking_acceptable'          => [ 'max:20'],
             'partner_diet'                 => [ 'max:50'],
            // 'partner_body_type'            => [ 'max:50'],
             'partner_personal_value'       => [ 'max:50'],
             'partner_manglik'              => [ 'max:50'],
            // 'pertner_complexion'           => [ 'max:50'],
             'partner_age_from'                  => [ 'max:50'],
             'partner_age_to'                  => [ 'max:50'],
             'partner_age_to'                  => [ 'max:50', 'gte:partner_age_from'],
            ];
         $this->messages = [
             'general.max'                      => translate('Max 255 characters'),
             'partner_height.max'               => translate('Max 50 characters'),
            //  'partner_weight.max'               => translate('Max 50 characters'),
            //  'partner_children_acceptable.max'  => translate('Max 20 characters'),
             'pertner_education.max'            => translate('Max 255 characters'),
             'partner_profession.max'           => translate('Max 50 characters'),
             'smoking_acceptable.max'           => translate('Max 20 characters'),
             'drinking_acceptable.max'          => translate('Max 20 characters'),
            // 'partner_diet.max'               => translate('Max 50 characters'),
             'partner_body_type.max'            => translate('Max 50 characters'),
            //  'partner_personal_value.max'       => translate('Max 50 characters'),
             'partner_manglik.max'              => translate('Max 50 characters'),
             'partner_age_from.max'             => translate('Max 50 characters'),
             'partner_age_to.max'               => translate('Max 50 characters'),
             'partner_age_to.gte'               => translate('Preferred Age from cannot be greater than Preferred Age to'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Partner Expectation info.'))->error();
             return redirect()->to(url()->previous() . '#partner')->withErrors($validator);
         }

         $user                 = User::where('id',$id)->first();
         $partner_expectations = PartnerExpectation::where('user_id', $id)->first();
         if(empty($partner_expectations)){
             $partner_expectations           = new PartnerExpectation;
             $partner_expectations->user_id  = $id;
         }
         
         $partner_expectations->general                   = $request->general;
         $partner_expectations->height                    = $request->partner_height;
        //  $partner_expectations->weight                    = $request->partner_weight;
         $partner_expectations->marital_status_id         = $request->partner_marital_status;
        //  $partner_expectations->children_acceptable       = $request->partner_children_acceptable;
         $partner_expectations->residence_country_id      = $request->residence_country_id;
         $partner_expectations->religion_id               = $request->partner_religion_id;
         $partner_expectations->caste_id                  = $request->partner_caste_id;
         $partner_expectations->sub_caste_id              = $request->partner_sub_caste_id;
         $partner_expectations->education                 = $request->pertner_education;
         $partner_expectations->profession                = $request->partner_profession;
         $partner_expectations->smoking_acceptable        = $request->smoking_acceptable;
         $partner_expectations->drinking_acceptable       = $request->drinking_acceptable;
         $partner_expectations->diet                      = $request->diet;
         $partner_expectations->body_type                 = $request->partner_body_type;
        //  $partner_expectations->personal_value            = $request->partner_personal_value;
         $partner_expectations->manglik                   = $request->partner_manglik;
         $partner_expectations->language_id               = $request->language_id;
         $partner_expectations->family_value_id           = $request->family_value_id;
         $partner_expectations->preferred_country_id      = $request->partner_country_id;
         $partner_expectations->preferred_state_id        = $request->partner_state_id;
        //  $partner_expectations->complexion                = $request->pertner_complexion;
         $partner_expectations->partner_age_from          = $request->partner_age_from;
         $partner_expectations->partner_age_to            = $request->partner_age_to;
        
          if($partner_expectations->save()){
           
            if($user->member->auto_profile_match ==  1){
              $ProfileMatchController = new ProfileMatchController;
              $ProfileMatchController->match_profiles($user->id);
            }
            flash(translate('Partner Expectations Info has been updated successfully'))->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate("Partner Expectation"));
            return redirect()->to(url()->previous() . '#partner');
          }
          else {
            flash(translate('Sorry! Something went wrong with Partner Expectation info.'))->error();
            return redirect()->to(url()->previous() . '#partner');
          }

     }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update_new(Request $request, $id)
     { 
         $this->rules = [
             'general'                      => [ 'max:255'],
             'partner_height'               => [ 'max:50'],
            //  'partner_weight'               => [ 'max:50'],
            //  'partner_children_acceptable'  => [ 'max:20'],
             'pertner_education'            => [ 'max:255'],
             'partner_profession'           => [ 'max:50'],
             'smoking_acceptable'           => [ 'max:20'],
             'drinking_acceptable'          => [ 'max:20'],
             'partner_diet'                 => [ 'max:50'],
            // 'partner_body_type'            => [ 'max:50'],
             'partner_personal_value'       => [ 'max:50'],
             'partner_manglik'              => [ 'max:50'],
            // 'pertner_complexion'           => [ 'max:50'],
             'partner_age_from'                  => [ 'max:50'],
             'partner_age_to'                  => [ 'max:50'],
             'partner_age_to'                  => [ 'max:50', 'gte:partner_age_from'],
            ];
         $this->messages = [
             'general.max'                      => translate('Max 255 characters'),
             'partner_height.max'               => translate('Max 50 characters'),
            //  'partner_weight.max'               => translate('Max 50 characters'),
            //  'partner_children_acceptable.max'  => translate('Max 20 characters'),
             'pertner_education.max'            => translate('Max 255 characters'),
             'partner_profession.max'           => translate('Max 50 characters'),
             'smoking_acceptable.max'           => translate('Max 20 characters'),
             'drinking_acceptable.max'          => translate('Max 20 characters'),
            // 'partner_diet.max'               => translate('Max 50 characters'),
             'partner_body_type.max'            => translate('Max 50 characters'),
            //  'partner_personal_value.max'       => translate('Max 50 characters'),
             'partner_manglik.max'              => translate('Max 50 characters'),
             'partner_age_from.max'             => translate('Max 50 characters'),
             'partner_age_to.max'               => translate('Max 50 characters'),
             'partner_age_to.gte'               => translate('Preferred Age from cannot be greater than Preferred Age to'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Partner Expectation info.'))->error();
             return back()->with(['nextStep' => '15'])->withErrors($validator);
         }

         $user                 = User::where('id',$id)->first();
         $partner_expectations = PartnerExpectation::where('user_id', $id)->first();
         if(empty($partner_expectations)){
             $partner_expectations           = new PartnerExpectation;
             $partner_expectations->user_id  = $id;
         }
         
         $partner_expectations->general                   = $request->general;
         $partner_expectations->height                    = $request->partner_height;
        //  $partner_expectations->weight                    = $request->partner_weight;
         $partner_expectations->marital_status_id         = $request->partner_marital_status;
        //  $partner_expectations->children_acceptable       = $request->partner_children_acceptable;
         $partner_expectations->residence_country_id      = $request->residence_country_id;
         $partner_expectations->religion_id               = $request->partner_religion_id;
         $partner_expectations->caste_id                  = $request->partner_caste_id;
         $partner_expectations->sub_caste_id              = $request->partner_sub_caste_id;
         $partner_expectations->education                 = $request->pertner_education;
         $partner_expectations->profession                = $request->partner_profession;
         $partner_expectations->smoking_acceptable        = $request->smoking_acceptable;
         $partner_expectations->drinking_acceptable       = $request->drinking_acceptable;
         $partner_expectations->diet                      = $request->diet;
         $partner_expectations->body_type                 = $request->partner_body_type;
        //  $partner_expectations->personal_value            = $request->partner_personal_value;
         $partner_expectations->manglik                   = $request->partner_manglik;
         $partner_expectations->language_id               = $request->language_id;
         $partner_expectations->family_value_id           = $request->family_value_id;
         $partner_expectations->preferred_country_id      = $request->partner_country_id;
         $partner_expectations->preferred_state_id        = $request->partner_state_id;
        //  $partner_expectations->complexion                = $request->pertner_complexion;
         $partner_expectations->partner_age_from          = $request->partner_age_from;
         $partner_expectations->partner_age_to            = $request->partner_age_to;
        
          if($partner_expectations->save()){
           
            if($user->member->auto_profile_match ==  1){
              $ProfileMatchController = new ProfileMatchController;
              $ProfileMatchController->match_profiles($user->id);
            }
            flash(translate('Partner Expectations Info has been updated successfully'))->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate("Partner Expectation"));
            //return redirect()->to(url()->previous() . '#partner');
            return back()->with(['nextStep' => '16']);
          }
          else {
            flash(translate('Sorry! Something went wrong with Partner Expectation info.'))->error();
            //return redirect()->to(url()->previous() . '#partner');
            return back()->with(['nextStep' => '15']);
          }

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
