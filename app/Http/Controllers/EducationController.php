<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use Validator;
use Redirect;
use App\Utility\AdminNotificationUtility;

class EducationController extends Controller
{
    public function __construct()
    {
        $this->rules = [
            'degree'          => [ 'required','max:255'],
            'institution'     => [ 'required','max:255'],
            /* 'education_start' => [ 'required','numeric'],
            'education_end'   => [ 'required','numeric'], */
        ];
    }

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

    public function create(Request $request)
    {
        $member_id = $request->id;
        return view('frontend.member.profile.education.create', compact('member_id'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create_new(Request $request)
    {
        $member_id = $request->id;
        return view('frontend.member.profile.education.create_new', compact('member_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Validation error with Education Info'))->error();
            return redirect()->to(url()->previous() . '#edu')->withErrors($validator);
        }

        $education              = new Education;
        $education->user_id     = $request->user_id;
        $education->degree      = $request->degree;
        $education->institution = $request->institution;
      /*   $education->start       = $request->education_start;
        $education->end         = $request->education_end; */

        if($education->save()){
            flash(translate('Education Info has been added successfully'))->success();
            return redirect()->to(url()->previous() . '#edu');
        }
        else {
            flash(translate('Sorry! Something went wrong with Education Info.'))->error();
            return redirect()->to(url()->previous() . '#edu');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_new(Request $request)
    {
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Validation error with Education Info'))->error();
            return back()->with(['nextStep' => '6'])->withErrors($validator);
        }

        $education              = new Education;
        $education->user_id     = $request->user_id;
        $education->degree      = $request->degree;
        $education->institution = $request->institution;
      /*   $education->start       = $request->education_start;
        $education->end         = $request->education_end; */

        if($education->save()){
            flash(translate('Education Info has been added successfully'))->success();
            return back()->with(['nextStep' => '6']);
        }
        else {
            flash(translate('Sorry! Something went wrong with Education Info.'))->error();
            return back()->with(['nextStep' => '6']);
        }
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function done_new(Request $request)
    {
       return back()->with(['nextStep' => '7']);
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

     public function edit(Request $request)
     {
         $education = Education::findOrFail($request->id);
         return view('frontend.member.profile.education.edit', compact('education'));
     }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit_new(Request $request)
    {
        $education = Education::findOrFail($request->id);
        return view('frontend.member.profile.education.edit_new', compact('education'));
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
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Validation error with Education Info'))->error();
            return redirect()->to(url()->previous() . '#edu')->withErrors($validator);
        }

        $education              = Education::findOrFail($id);
        $education->degree      = $request->degree;
        $education->institution = $request->institution;
       /*  $education->start       = $request->education_start;
        $education->end         = $request->education_end;
 */
        if($education->save()){
            flash(translate('Education Info has been updated successfully'))->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Education Info'));

            return redirect()->to(url()->previous() . '#edu');
        }
        else {
            flash(translate('Sorry! Something went wrong with Education Info.'))->error();
            return redirect()->to(url()->previous() . '#edu');
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
        $rules = $this->rules;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            flash(translate('Validation error with Education Info'))->error();
            return back()->with(['nextStep' => '6'])->withErrors($validator);
        }

        $education              = Education::findOrFail($id);
        $education->degree      = $request->degree;
        $education->institution = $request->institution;
       /*  $education->start       = $request->education_start;
        $education->end         = $request->education_end;
 */
        if($education->save()){
            flash(translate('Education Info has been updated successfully'))->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Education Info'));

            return back()->with(['nextStep' => '6']);
        }
        else {
            flash(translate('Sorry! Something went wrong with Education Info.'))->error();
            return back()->with(['nextStep' => '6']);
        }
    }

    public function update_education_present_status(Request $request)
    {
        $education = Education::findOrFail($request->id);
        $education->present = $request->status;
        if ($education->save()) {
            $msg = $education->present == 1 ? translate('Enabled') : translate('Disabled');
            flash(translate($msg))->success();
            return 1;
        }
        return 0;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Education::destroy($id))
        {
            flash(translate('Education info has been deleted successfully'))->success();
            return back();
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
