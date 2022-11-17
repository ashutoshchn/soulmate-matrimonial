<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhysicalAttribute;
use Validator;
use Redirect;
use App\Utility\AdminNotificationUtility;

class PhysicalAttributeController extends Controller
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
             'height'       => [ 'required','numeric','between:3,12'],
            //  'weight'       => [ 'required','numeric','between:20,200'],
            //  'eye_color'    => [ 'required','max:50'],
            //  'hair_color'   => [ 'required','max:50'],
            //  'complexion'   => [ 'required','max:50'],
            //  'blood_group'  => [ 'required','max:3'],
            //  'body_type'    => [ 'required','max:50'],
            //  'body_art'     => [ 'required','max:50'],
             'disability'   => [ 'max:255'],
         ];
         $this->messages = [
             'height.required'      => translate('Height is required'),
             'height.numeric'       => translate('Height should be numeric type'),
             'height.between'       => translate('Invalid Height value'),
            //  'weight.required'      => translate('Weight is required'),
            //  'weight.numeric'       => translate('Weight should be numeric type'),
            //  'weight.between'       => translate('Invalid Weight value'),
            //  'eye_color.required'   => translate('Eye Color is required'),
            //  'eye_color.max'        => translate('Max 50 characters'),
            //  'hair_color.required'  => translate('Hair Color is required'),
            //  'hair_color.max'       => translate('Max 50 characters'),
            //  'complexion.required'  => translate('Complexion is required'),
            //  'complexion.max'       => translate('Max 50 characters'),
            //  'blood_group.required' => translate('Blood Group is required'),
            //  'blood_group.max'      => translate('Max 3 characters'),
            //  'body_type.required'   => translate('Body Type is required'),
            //  'body_type.max'        => translate('Max 50 characters'),
            //  'body_art.required'    => translate('Body Art is required'),
            //  'body_art.max'         => translate('Max 50 characters'),
             'disability.max'       => translate('Max 255 characters'),

         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Physical Attribute Info.'))->error();
             return redirect()->to(url()->previous() . '#physical')->withErrors($validator);
         }

         $physical_attribute = PhysicalAttribute::where('user_id', $id)->first();
         if(empty($physical_attribute)){
             $physical_attribute = new PhysicalAttribute;
             $physical_attribute->user_id = $id;
         }

         $physical_attribute->height        = $request->height;
         $physical_attribute->weight        = $request->weight;
        //  $physical_attribute->eye_color     = $request->eye_color;
        //  $physical_attribute->hair_color    = $request->hair_color;
        //  $physical_attribute->complexion    = $request->complexion;
        //  $physical_attribute->blood_group   = $request->blood_group;
        //  $physical_attribute->body_type     = $request->body_type;
        //  $physical_attribute->body_art      = $request->body_art;
         $physical_attribute->disability    = $request->disability;

         if($physical_attribute->save()){
             flash(translate('Physical Attribute Info has been updated successfully'))->success();
             AdminNotificationUtility::send_profileupdate_admin_notification(translate('Physical Attribute Info'));

             return redirect()->to(url()->previous() . '#physical');
         }
         else {
             flash(translate('Sorry! Something went wrong with Physical Attribute Info.'))->error();
             return redirect()->to(url()->previous() . '#physical');
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
             'height'       => [ 'required','numeric','between:3,12'],
            //  'weight'       => [ 'required','numeric','between:20,200'],
            //  'eye_color'    => [ 'required','max:50'],
            //  'hair_color'   => [ 'required','max:50'],
            //  'complexion'   => [ 'required','max:50'],
            //  'blood_group'  => [ 'required','max:3'],
            //  'body_type'    => [ 'required','max:50'],
            //  'body_art'     => [ 'required','max:50'],
             'disability'   => [ 'max:255'],
         ];
         $this->messages = [
             'height.required'      => translate('Height is required'),
             'height.numeric'       => translate('Height should be numeric type'),
             'height.between'       => translate('Invalid Height value'),
            //  'weight.required'      => translate('Weight is required'),
            //  'weight.numeric'       => translate('Weight should be numeric type'),
            //  'weight.between'       => translate('Invalid Weight value'),
            //  'eye_color.required'   => translate('Eye Color is required'),
            //  'eye_color.max'        => translate('Max 50 characters'),
            //  'hair_color.required'  => translate('Hair Color is required'),
            //  'hair_color.max'       => translate('Max 50 characters'),
            //  'complexion.required'  => translate('Complexion is required'),
            //  'complexion.max'       => translate('Max 50 characters'),
            //  'blood_group.required' => translate('Blood Group is required'),
            //  'blood_group.max'      => translate('Max 3 characters'),
            //  'body_type.required'   => translate('Body Type is required'),
            //  'body_type.max'        => translate('Max 50 characters'),
            //  'body_art.required'    => translate('Body Art is required'),
            //  'body_art.max'         => translate('Max 50 characters'),
             'disability.max'       => translate('Max 255 characters'),

         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Physical Attribute Info.'))->error();
             return back()->with(['nextStep' => '8'])->withErrors($validator);
         }

         $physical_attribute = PhysicalAttribute::where('user_id', $id)->first();
         if(empty($physical_attribute)){
             $physical_attribute = new PhysicalAttribute;
             $physical_attribute->user_id = $id;
         }

         $physical_attribute->height        = $request->height;
         $physical_attribute->weight        = $request->weight;
        //  $physical_attribute->eye_color     = $request->eye_color;
        //  $physical_attribute->hair_color    = $request->hair_color;
        //  $physical_attribute->complexion    = $request->complexion;
        //  $physical_attribute->blood_group   = $request->blood_group;
        //  $physical_attribute->body_type     = $request->body_type;
        //  $physical_attribute->body_art      = $request->body_art;
         $physical_attribute->disability    = $request->disability;

         if($physical_attribute->save()){
             flash(translate('Physical Attribute Info has been updated successfully'))->success();
             AdminNotificationUtility::send_profileupdate_admin_notification(translate('Physical Attribute Info'));

             // return redirect()->to(url()->previous() . '#physical');
             return back()->with(['nextStep' => '9']);
         }
         else {
             flash(translate('Sorry! Something went wrong with Physical Attribute Info.'))->error();
             //return redirect()->to(url()->previous() . '#physical');
             return back()->with(['nextStep' => '8']);
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
