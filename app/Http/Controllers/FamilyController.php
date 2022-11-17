<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Family;
use Validator;
use Redirect;
use App\Utility\AdminNotificationUtility;

class FamilyController extends Controller
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
             'father'   => [ 'max:255'],
             'mother'   => [ 'max:255'],
             'sibling'  => [ 'max:255'],
         ];
         $this->messages = [
             'father.max'   => translate('Max 255 characters'),
             'mother.max'   => translate('Max 255 characters'),
             'sibling.max'  => translate('Max 255 characters'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Family Info'))->error();
             return redirect()->to(url()->previous() . '#family')->withErrors($validator);
         }

         $family = Family::where('user_id', $id)->first();
         if(empty($family)){
             $family           = new Family;
             $family->user_id  = $id;
         }

         $family->father    = $request->father;
         $family->mother    = $request->mother;
         $family->sibling   = $request->sibling;

         if($family->save()){
             flash(translate('Family info has been updated successfully'))->success();
             AdminNotificationUtility::send_profileupdate_admin_notification(translate("Family Information"));

            return redirect()->to(url()->previous() . '#family');
         }
         else {
             flash(translate('Sorry! Something went wrong with Family Info.'))->error();
             return redirect()->to(url()->previous() . '#family');
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
             'father'   => [ 'max:255'],
             'mother'   => [ 'max:255'],
             'sibling'  => [ 'max:255'],
         ];
         $this->messages = [
             'father.max'   => translate('Max 255 characters'),
             'mother.max'   => translate('Max 255 characters'),
             'sibling.max'  => translate('Max 255 characters'),
         ];

         $rules = $this->rules;
         $messages = $this->messages;
         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
             flash(translate('Validation error with Family Info'))->error();
             return back()->with(['nextStep' => '14'])->withErrors($validator);
         }

         $family = Family::where('user_id', $id)->first();
         if(empty($family)){
             $family           = new Family;
             $family->user_id  = $id;
         }

         $family->father    = $request->father;
         $family->mother    = $request->mother;
         $family->sibling   = $request->sibling;

         if($family->save()){
             flash(translate('Family info has been updated successfully'))->success();
             AdminNotificationUtility::send_profileupdate_admin_notification(translate("Family Information"));

            //return redirect()->to(url()->previous() . '#family');
            return back()->with(['nextStep' => '15']);
         }
         else {
             flash(translate('Sorry! Something went wrong with Family Info.'))->error();
             //return redirect()->to(url()->previous() . '#family');
             return back()->with(['nextStep' => '14']);
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
