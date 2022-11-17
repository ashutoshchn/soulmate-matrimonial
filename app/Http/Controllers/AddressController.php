<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Validator;
use Redirect;
use App\Utility\AdminNotificationUtility;

class AddressController extends Controller
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
    public function update_new(Request $request, $id)
    {
        $address_type = $request->address_type;
        if($address_type == 'present'){
            $this->rules = [
                'present_country_id'   => [ 'required'],
                'present_state_id'     => [ 'required'],
                'present_city_id'      => [ 'required'],
                'present_postal_code'  => [ 'required','numeric'],
            ];
            $this->messages = [
                'present_country_id.required'  => translate('Country is required'),
                'present_state_id.required'    => translate('State Name is required'),
                'present_city_id.required'     => translate('City Name is required'),
                'present_postal_code.required' => translate('Postal Code is required'),
                'present_postal_code.numeric'  => translate('Postal Code should be numeric type'),
            ];
        }
        elseif($address_type == 'permanent'){
            $this->rules = [
                'permanent_country_id'   => [ 'required'],
                'permanent_state_id'     => [ 'required'],
                'permanent_city_id'      => [ 'required'],
                'permanent_postal_code'  => [ 'required','numeric'],
            ];
            $this->messages = [
                'permanent_country_id.required'  => translate('Country is required'),
                'permanent_state_id.required'    => translate('State Name is required'),
                'permanent_city_id.required'     => translate('City Name is required'),
                'permanent_postal_code.required' => translate('Postal Code is required'),
                'permanent_postal_code.numeric'  => translate('Postal Code should be numeric type'),
            ];
        }
        else{
            $address_type='';
        }

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Validation error with  address'))->error();
            if($address_type == 'present'){
                return back()->with(['nextStep' => '3'])->withErrors($validator); 
            }            
            elseif($address_type == 'permanent'){
                return back()->with(['nextStep' => '5'])->withErrors($validator);             
            }
            else
            {
                return back()->withErrors($validator);  
            }
        }

        $address = Address::where('user_id', $id)->where('type',$request->address_type)->first();
        if(empty($address)){
            $address = new Address;
            $address->user_id = $id;
        }
        if($address_type == 'present'){
            $address->country_id   = $request->present_country_id;
            $address->state_id     = $request->present_state_id;
            $address->city_id      = $request->present_city_id;
            $address->postal_code  = $request->present_postal_code;
        }
        elseif($address_type == 'permanent'){
            $address->country_id   = $request->permanent_country_id;
            $address->state_id     = $request->permanent_state_id;
            $address->city_id      = $request->permanent_city_id;
            $address->postal_code  = $request->permanent_postal_code;
        }
        $address->type             = $address_type;


        if($address->save()){
            flash(translate('Address info has been updated successfully'))->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate($address_type.' address'));
            if($address_type == 'present'){
                return back()->with(['nextStep' => '4']);
            }            
            elseif($address_type == 'permanent'){
                return back()->with(['nextStep' => '6']);
            }
            else
            {
                return back();
            }
        }
        else {
            flash(translate('Sorry! Something went wrong with '.$address_type))->error();
            if($address_type == 'present'){
                return back()->with(['nextStep' => '3']);
            }            
            elseif($address_type == 'permanent'){
                return back()->with(['nextStep' => '5']);
            }
            else
            {
                return back();
            }
        }

    }

    public function update(Request $request, $id)
     {

         $address_type = $request->address_type;
         if($address_type == 'present'){
             $this->rules = [
                 'present_country_id'   => [ 'required'],
                 'present_state_id'     => [ 'required'],
                 'present_city_id'      => [ 'required'],
                 'present_postal_code'  => [ 'required','numeric'],
             ];
             $this->messages = [
                 'present_country_id.required'  => translate('Country is required'),
                 'present_state_id.required'    => translate('State Name is required'),
                 'present_city_id.required'     => translate('City Name is required'),
                 'present_postal_code.required' => translate('Postal Code is required'),
                 'present_postal_code.numeric'  => translate('Postal Code should be numeric type'),
             ];
         }
         elseif($address_type == 'permanent'){
             $this->rules = [
                 'permanent_country_id'   => [ 'required'],
                 'permanent_state_id'     => [ 'required'],
                 'permanent_city_id'      => [ 'required'],
                 'permanent_postal_code'  => [ 'required','numeric'],
             ];
             $this->messages = [
                 'permanent_country_id.required'  => translate('Country is required'),
                 'permanent_state_id.required'    => translate('State Name is required'),
                 'permanent_city_id.required'     => translate('City Name is required'),
                 'permanent_postal_code.required' => translate('Postal Code is required'),
                 'permanent_postal_code.numeric'  => translate('Postal Code should be numeric type'),
             ];
         }
         else{
             $address_type='';
         }

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {

             flash(translate('Validation error with '.$address_type.' address'))->error();

             return redirect()->to(url()->previous() . '#'.$address_type)->withErrors($validator);             
         }

         $address = Address::where('user_id', $id)->where('type',$request->address_type)->first();
         if(empty($address)){
             $address = new Address;
             $address->user_id = $id;
         }
         if($address_type == 'present'){
             $address->country_id   = $request->present_country_id;
             $address->state_id     = $request->present_state_id;
             $address->city_id      = $request->present_city_id;
             $address->postal_code  = $request->present_postal_code;
         }
         elseif($address_type == 'permanent'){
             $address->country_id   = $request->permanent_country_id;
             $address->state_id     = $request->permanent_state_id;
             $address->city_id      = $request->permanent_city_id;
             $address->postal_code  = $request->permanent_postal_code;
         }
         $address->type             = $address_type;


         if($address->save()){
             flash(translate('Address info has been updated successfully'))->success();
             AdminNotificationUtility::send_profileupdate_admin_notification(translate($address_type.' address'));

             return redirect()->to(url()->previous() . '#'.$address_type);
         }
         else {
             flash(translate('Sorry! Something went wrong with '.$address_type))->error();
             return redirect()->to(url()->previous() . '#'.$address_type);
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
