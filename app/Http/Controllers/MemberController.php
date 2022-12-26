<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Package;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Religion;
use App\Models\Caste;
use App\Models\SubCaste;
use App\Models\MemberLanguage;
use App\Models\FamilyValue;
use App\Models\MaritalStatus;
use App\Models\DietType;
// use App\Models\OnBehalf;
use App\Models\Wallet;
use App\Notifications\DbStoreNotification;
use Notification;
use DB;
use App\User;
use Hash;
use Validator;
use Redirect;
use Auth;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Utility\EmailUtility;
use App\Utility\AdminNotificationUtility;
use App\Utility\SmsUtility;
use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Collection;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_members'])->only('index');
        $this->middleware(['permission:create_member'])->only('create');
        $this->middleware(['permission:edit_member'])->only('edit');
        $this->middleware(['permission:delete_member'])->only('destroy');
        $this->middleware(['permission:view_member_profile'])->only('show');
        $this->middleware(['permission:block_member'])->only('block');
        $this->middleware(['permission:approve_member'])->only('approve');
        $this->middleware(['permission:update_member_package'])->only('package_info');
        $this->middleware(['permission:login_as_member'])->only('login');
        $this->middleware(['permission:deleted_member_show'])->only('deleted_members');
        $this->middleware(['permission:download_members'])->only('download_members');
        $this->rules = [
            'first_name'        => [ 'required','max:255'],
            'last_name'         => [ 'required','max:255'],
            'email'             => [ 'max:255','unique:users,email'],
            'gender'            => [ 'required'],
            'date_of_birth'     => [ 'required'],
            // 'on_behalf'         => [ 'required'],
            'package'           => [ 'required'],
            'password'          => [ 'min:8','required_with:confirm_password','same:confirm_password'],
            'confirm_password'  => [ 'min:8'],
        ];
        $this->messages = [
            'first_name.required'       => translate('First name is required'),
            'first_name.max'            => translate('Max 255 characters'),
            'last_name.required'        => translate('First name is required'),
            'last_name.max'             => translate('Max 255 characters'),
            'email.max'                 => translate('Max 255 characters'),
            'email.unique'              => translate('Email Should be unique'),
            'gender.required'           => translate('Gender is required'),
            'date_of_birth.required'    => translate('Gender is required'),
            // 'on_behalf.required'        => translate('On behalf is required'),
            'package.required'          => translate('Package is required'),
            'password.min'              => translate('Min 8 characters'),
            'password.required_with'    => translate('Password and Confirm password are required'),
            'password.same'             => translate('Password and Confirmed password did not matched'),
            'confirm_password.min'      => translate('Max 8 characters'),
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $id)
    {
        $sort_search  = null;
        $members1 = Member::latest()-> where('current_package_id',$id)->select('user_id')->get()->toArray();
        $members       = User::latest()->where('users.user_type','member')->whereIn('id', $members1);
        if ($request->has('search')){
            $sort_search  = $request->search;
            $members  = $members->where('code',$sort_search)->orwhere('first_name', 'like', '%'.$sort_search.'%')->orWhere('last_name', 'like', '%'.$sort_search.'%');
        }
        $members = $members->where('user_type', 'member');
        $members = $members->paginate(10);
        return view('admin.members.index', compact('members','sort_search'));
    }

    public function index1(Request $request, $id) 
    {
        $sort_search  = null;
        $members1 = Member::latest()-> where('current_package_id',$id)->select('user_id')->get()->toArray();
        $members       = User::latest()->where('user_type','member')->whereIn('id', $members1);
        if ($request->has('search')){
            $sort_search  = $request->search;
            $members  = $members->where(function($q) use ($sort_search){    
                $q->where('code' , $sort_search)
                ->orwhere('first_name' , 'like', '%'.$sort_search.'%')
                ->orWhere('last_name','like','%'.$sort_search.'%');
            }); 
        }
        $members = $members->where('permanently_delete','0');
        $members = $members->paginate(10);
        return view('admin.members.index', compact('members','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.create');
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
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            flash(translate('Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }
        if($request->email == null && $request->phone == null )
        {
            flash(translate('Email and Phone both can not be null.'));
            return back();
        }
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        elseif (User::where('phone', '+'.$request->country_code.$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }
        $user               = new user;
        $user->user_type    = 'member';
        $user->code         = unique_code();
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->password     = Hash::make($request->password);
        $user->photo        = $request->photo;
        $user->email        = $request->email;
        if($request->phone != null){
          $user->phone        = '+'.$request->country_code.$request->phone;
        }
        if($request->member_verification == 1){
            $user->email_verified_at     = date('Y-m-d h:m:s');
        }
        if($user->save()){
            $member                             = new Member;
            $member->user_id                    = $user->id;
            $member->gender                     = $request->gender;
            // $member->on_behalves_id             = $request->on_behalf;
            $member->birthday                   = date('Y-m-d', strtotime($request->date_of_birth));
            $package                            = Package::where('id',$request->package)->first();
            $member->current_package_id         = $package->id;
            $member->remaining_interest         = $package->express_interest;
            $member->remaining_contact_view     = $package->contact;
            $member->remaining_photo_gallery    = $package->photo_gallery;
            $member->auto_profile_match         = $package->auto_profile_match;
            $member->package_validity           = Date('Y-m-d', strtotime($package->validity." days"));
            $membership                         = $package->id ;
            $member->save();
            $user_update                = User::findOrFail($user->id);
            $user_update->membership    = $membership;
            $user_update->save();
            // Account opening email to member
            if($user->email != null  && env('MAIL_USERNAME') != null && (get_email_template('account_oppening_email','status') == 1))
            {
                EmailUtility::account_oppening_email($user->id, $request->password);
            }
            // Account Opening SMS to member
            if($user->phone != null && addon_activation('otp_system') && (get_sms_template('account_opening_by_admin','status') == 1 ))
            {
                SmsUtility::account_opening_by_admin($user, $request->password);
            }
            flash('New member has been added successfully')->success();
            return redirect()->route('members.index', $membership);
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::findOrFail($id);
        return view('admin.members.view', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member             = User::findOrFail(decrypt($id));
        $countries          = Country::where('status',1)->get();
        $states             = State::all();
        $cities             = City::all();
        $religions          = Religion::all();
        $castes             = Caste::all();
        $sub_castes         = SubCaste::all();
        $family_values      = FamilyValue::all();
        $marital_statuses   = MaritalStatus::all();
        $diet_types   = DietType::all();
        // $on_behalves        = OnBehalf::all();
        $languages          = MemberLanguage::all();
        return view('admin.members.edit.index', compact('member','countries','states','cities','religions','castes','sub_castes','family_values','marital_statuses','diet_types','languages'));
        //return view('admin.members.edit.index', compact('member','countries','states','cities','religions','castes','sub_castes','family_values','marital_statuses','diet_types','on_behalves','languages'));
    }

    public function introduction_edit(Request $request)
    {
        $member = User::findOrFail($request->id);
        return view('admin.members.edit_profile_attributes.introduction', compact('member'));
    }

    public function introduction_update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $member->introduction = $request->introduction;
        if($member->save()){
            flash('Member introduction info has been updated successfully')->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Introduction'));
            return back()->with(['nextStep' => '1']);
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }
    public function send_admin_approval(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        if(Auth::user()->approved == 0)
        {
           try{
                //check photo 

                $gallery_images_count = GalleryImage::where('user_id',Auth::user()->id)->count();
                if($gallery_images_count >= 2) 
                {
                    AdminNotificationUtility::send_for_admin_approval_notification();
     
                }
                else{
                    flash(translate('Please upload photo for your profile and consider updating “Gallery” with at least two photographs with one close up/face photo and one full size photo.'))->error();
                    return redirect()->route('gallery-image.index');
                }
           }
           catch(\Exception $e){
               // dd($e)
               flash('Something went wrong, please try again later or email support.')->error();
           }
        }
        return back();
    }
    public function send_admin_approval_new(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        if(Auth::user()->approved == 0)
        {
           try{
                //check photo 

                $gallery_images_count = GalleryImage::where('user_id',Auth::user()->id)->count();
                if($gallery_images_count >= 2) 
                {
                    AdminNotificationUtility::send_for_admin_approval_notification();
                    return back()->with(['nextStep' => '17']);
                }
                else{
                    flash(translate('Please upload photo for your profile and consider updating “Gallery” with at least two photographs with one close up/face photo and one full size photo.'))->error();

                    return redirect()->route('gallery-image.index')->with(['nextStep' => '16']);

                }
           }
           catch(\Exception $e){
               // dd($e)
               flash('Something went wrong, please try again later or email support.')->error();
           }
        }
        return back();
    }
    public function basic_info_update(Request $request, $id)
    {
        $this->rules = [
            'first_name'    => [ 'required','max:255'],
            'last_name'     => [ 'required','max:255'],
            'gender'        => [ 'required'],
            'date_of_birth' => [ 'required'],
            // 'on_behalf'     => [ 'required'],
            'marital_status'=> [ 'required'],
            // 'diet_type'=> [ 'required'],
        ];
        $this->messages = [
            'first_name.required'             => translate('First Name is required'),
            'first_name.max'                  => translate('Max 255 characters'),
            'last_name.required'              => translate('First Name is required'),
            'last_name.max'                   => translate('Max 255 characters'),
            'gender.required'                 => translate('Gender is required'),
            'date_of_birth.required'          => translate('Date Of Birth is required'),
            // 'on_behalf.required'              => translate('On Behalf is required'),
            'marital_status.required'         => translate('Marital Status is required'),
            // 'diet_type.required'         => translate('Diet Type is required'),
        ];
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            flash(translate('Validation error with Basic Profile'))->error();
            return  redirect()->to(url()->previous() . '#basic')->withErrors($validator);
        }
        if($request->email == null && $request->phone == null){
          flash(translate('Email and Phone number both can not be null. '))->error();
          return redirect()->to(url()->previous() . '#basic');
        }
        $user               = User::findOrFail($request->id);
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->photo        = $request->photo;
        // $user->email        = $request->email;
        $user->phone        = $request->phone;
        $user->save();
        $member                     = Member::where('user_id',$request->id)->first();
        $member->gender             = $request->gender;
        // $member->on_behalves_id     = $request->on_behalf;
        $member->birthday           = date('Y-m-d', strtotime($request->date_of_birth));
        $member->marital_status_id  = $request->marital_status;
        // $member->diet_type_id  = $request->diet_type;
        $member->children           = $request->children;
        if($member->save())
        {
            flash('Member basic info  has been updated successfully')->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Basic Info'));

            return redirect()->to(url()->previous() . '#basic');
        }
        flash('Sorry! Something went wrong.')->error();
        return redirect()->to(url()->previous() . '#basic');
    }
    public function basic_info_update_new(Request $request, $id)
    {
        $this->rules = [
            'first_name'    => [ 'required','max:255'],
            'last_name'     => [ 'required','max:255'],
            'gender'        => [ 'required'],
            'date_of_birth' => [ 'required'],
            // 'on_behalf'     => [ 'required'],
            'marital_status'=> [ 'required'],
            // 'diet_type'=> [ 'required'],
        ];
        $this->messages = [
            'first_name.required'             => translate('First Name is required'),
            'first_name.max'                  => translate('Max 255 characters'),
            'last_name.required'              => translate('First Name is required'),
            'last_name.max'                   => translate('Max 255 characters'),
            'gender.required'                 => translate('Gender is required'),
            'date_of_birth.required'          => translate('Date Of Birth is required'),
            // 'on_behalf.required'              => translate('On Behalf is required'),
            'marital_status.required'         => translate('Marital Status is required'),
            // 'diet_type.required'         => translate('Diet Type is required'),
        ];
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            flash(translate('Validation error with Basic Profile'))->error();
            return back()->with(['nextStep' => '2'])->withErrors($validator);
        }
        if($request->email == null && $request->phone == null){
          flash(translate('Email and Phone number both can not be null. '))->error();
          return back()->with(['nextStep' => '2']);
        }
        $user               = User::findOrFail($request->id);
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->photo        = $request->photo;
        // $user->email        = $request->email;
        $user->phone        = $request->phone;
        $user->save();
        $member                     = Member::where('user_id',$request->id)->first();
        $member->gender             = $request->gender;
        // $member->on_behalves_id     = $request->on_behalf;
        $member->birthday           = date('Y-m-d', strtotime($request->date_of_birth));
        $member->marital_status_id  = $request->marital_status;
        // $member->diet_type_id  = $request->diet_type;
        $member->children           = $request->children;
        if($member->save())
        {
            flash('Member basic info  has been updated successfully')->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Basic Info'));

            return back()->with(['nextStep' => '3']);
        }
        flash('Sorry! Something went wrong.')->error();
        return back()->with(['nextStep' => '2']);
    }
    public function language_info_update(Request $request, $id)
    {
        $this->rules = [
            'mothere_tongue'    => [ 'required'],
        ];
        $this->messages = [
            'mothere_tongue.required' => translate('Mother Tongue is required'),
        ];
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->with(['nextStep' => '9'])->withErrors($validator);
        }
        $member                     = Member::where('user_id',$request->id)->first();
        $member->mothere_tongue     = $request->mothere_tongue;
        $member->known_languages    = $request->known_languages;
        if($member->save())
        {
            flash('Member language info has been updated successfully')->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Language info'));

            return redirect()->to(url()->previous() . '#lang');
        }
        flash('Sorry! Something went wrong with language info.')->error();
        return redirect()->to(url()->previous() . '#lang');
    }
    public function language_info_update_new(Request $request, $id)
    {
        $this->rules = [
            'mothere_tongue'    => [ 'required'],
        ];
        $this->messages = [
            'mothere_tongue.required' => translate('Mother Tongue is required'),
        ];
        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->with(['nextStep' => '9'])->withErrors($validator);
        }
        $member                     = Member::where('user_id',$request->id)->first();
        $member->mothere_tongue     = $request->mothere_tongue;
        $member->known_languages    = $request->known_languages;
        if($member->save())
        {
            flash('Member language info has been updated successfully')->success();
            AdminNotificationUtility::send_profileupdate_admin_notification(translate('Language info'));
            return back()->with(['nextStep' => '10']);
            //return redirect()->to(url()->previous() . '#lang');
        }
        flash('Sorry! Something went wrong with language info.')->error();
        return back()->with(['nextStep' => '9']);
        //return redirect()->to(url()->previous() . '#lang');
    }
    public function approve(Request $request)
    {
        $member             = User::findOrFail($request->member_id);
        $member->approved   = 1;
        if ($member->save()) {
            // Account approval email send to members
            if($member->email != null && get_email_template('account_approval_email','status'))
            {
                EmailUtility::account_approval_email($member);
            }
            // Account Approval SMS send to member
            if($member->phone && addon_activation('otp_system') && get_sms_template('account_approval','status'))
            {
                SmsUtility::account_approval($member);
            }
            flash('Member Approved')->success();
            return redirect()->route('members.show', $member->id);
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    public function deleted_members(Request $request)
    {
        $sort_search        = null;
        $deleted_members    = User::onlyTrashed()->where('permanently_delete',0);
        if ($request->has('search')){
            $sort_search  = $request->search;
            $deleted_members  = $deleted_members->where('code',$sort_search)->orwhere('first_name', 'like', '%'.$sort_search.'%')->orWhere('last_name', 'like', '%'.$sort_search.'%');
        }
        $deleted_members = $deleted_members->paginate(10);
        return view('admin.members.deleted_members', compact('deleted_members','sort_search'));
    }

    public function download_members(Request $request)
    {
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
        return view('admin.members.download_members');
        //return (new App\Models\MembersExport)->download('members.xlsx');
    }

    public function download_members_data(Request $request)
    {
        // $users = DB::table('careers')->get();
        // // $members = $users->member()->get();
        // // $members = $users

        // return $users;
        $data =  DB::table('users')
        // ->where('users.deleted_at','=', 'NULL')
                ->whereNull('users.deleted_at')
                ->join('members', 'members.user_id', '=','users.id')
                ->leftJoin('marital_statuses', 'members.marital_status_id', '=','marital_statuses.id')
                ->leftJoin('member_languages', 'members.mothere_tongue', '=','member_languages.id')
                ->leftJoin('packages', 'members.current_package_id', '=','packages.id')
                ->leftJoin('astrologies', 'members.user_id', '=','astrologies.user_id')
                ->leftJoin('careers', function($join) {
                    $join->on('members.user_id','=','careers.user_id')
                    ->where('careers.deleted_at','NULL');
                })
                ->leftJoin('families','members.user_id','=','families.user_id')
                ->leftJoin('hobbies','members.user_id','=','hobbies.user_id')
                ->leftJoin('lifestyles','members.user_id','=','lifestyles.user_id')
                ->leftJoin('diet_types','diet_types.id','=','lifestyles.diet')
                ->leftJoin('partner_expectations','members.user_id','=','partner_expectations.user_id')
                ->leftJoin('marital_statuses as mat','mat.id','=','partner_expectations.marital_status_id')
                ->leftJoin('countries','countries.id','=','partner_expectations.residence_country_id')
                ->leftJoin('religions','religions.id','=','partner_expectations.religion_id')
                ->leftJoin('castes','castes.id','=','partner_expectations.caste_id')
                ->leftJoin('sub_castes','sub_castes.id','=','partner_expectations.sub_caste_id')
                ->leftJoin('diet_types as part_diet','part_diet.id','=','partner_expectations.diet')
                ->leftJoin('countries as part_cunt','part_cunt.id','=','partner_expectations.preferred_country_id')
                ->leftJoin('states','states.id','=','partner_expectations.preferred_state_id')
                ->leftJoin('package_payments','members.user_id','=','package_payments.user_id')
                ->leftJoin('physical_attributes','members.user_id','=','physical_attributes.user_id')
                ->leftJoin('recidencies','members.user_id','=','recidencies.user_id')
                ->leftJoin('countries as birth_cunt','birth_cunt.id','=','recidencies.birth_country_id')
                ->leftJoin('countries as resi_cunt','resi_cunt.id','=','recidencies.recidency_country_id')
                ->leftJoin('countries as citizen_cunt','citizen_cunt.id','=','recidencies.growup_country_id')
                ->leftJoin('spiritual_backgrounds','members.user_id','=','spiritual_backgrounds.user_id')
                ->leftJoin('religions as sp_reli','sp_reli.id','=','spiritual_backgrounds.religion_id')
                ->leftJoin('castes as sp_caste','sp_caste.id','=','spiritual_backgrounds.caste_id')
                ->leftJoin('sub_castes as sub_caste','sub_caste.id','=','spiritual_backgrounds.sub_caste_id')
                // ->count();
                ->limit(100)
                ->orderBy('members.user_id','desc')
                ->get([
                    'users.code as MemberId','users.first_name','users.last_name','users.email','users.email_verified_at','users.phone','users.email_verified_at1 as phone_verified_at','users.blocked','users.deactivated','users.permanently_delete','users.approved',
                    'users.created_at','users.deleted_at',DB::raw('IF(members.gender = "1", "Male", "Female") as gender'),
                    'members.birthday','members.introduction','marital_statuses.name as maritalstatus','member_languages.name as mother_tongue',
                    'packages.name as package_name','members.remaining_interest','members.remaining_contact_view','members.remaining_photo_gallery',
                    'members.auto_profile_match','members.package_validity','members.profile_picture_privacy','members.gallery_image_privacy',
                    'astrologies.sun_sign','astrologies.moon_sign','astrologies.time_of_birth','astrologies.city_of_birth','astrologies.manglik as astrologies_manglik',
                    'careers.designation as designation','careers.company as company',
                    'families.father','families.mother','families.sibling',
                    'hobbies.hobbies','hobbies.interests',
                    'diet_types.name as diet_name','lifestyles.drink','lifestyles.smoke',
                    'partner_expectations.general as partner_expectations_general','partner_expectations.height as partner_expectations_min_height','mat.name as partner_expectations_marital_status','countries.name as partner_expectations_residence_country',
                    'religions.name as partner_expectations_religion','castes.name as partner_expectations_caste','sub_castes.name as partner_expectations_sub_caste','partner_expectations.education as education',
                    'partner_expectations.profession as profession','partner_expectations.smoking_acceptable as smoking_acceptable','part_diet.name as partner_expectations_diet','partner_expectations.drinking_acceptable as partner_expectations_drinking_acceptable',
                    'partner_expectations.manglik as partner_expectations_manglik','part_cunt.name as partner_expectations_preferred_country_id','states.name as partner_expectations_preferred_state','partner_expectations.partner_age_from as partner_age_from',
                    'partner_expectations.partner_age_to as partner_age_to','package_payments.payment_status','package_payments.payment_status','package_payments.amount','package_payments.amount','package_payments.created_at as package_payments_created_at',
                    'physical_attributes.height','physical_attributes.disability',
                    'birth_cunt.name as birth_country','resi_cunt.name as recidency_country','citizen_cunt.name as citizen_country','recidencies.immigration_status as immigration_status',
                    'sp_reli.name as spiritual_backgrounds_religion','sp_caste.name as spiritual_backgrounds_caste','sub_caste.name as spiritual_backgrounds_sub_caste','spiritual_backgrounds.ethnicity as ethnicity','spiritual_backgrounds.family_value as family_value',
                    
                ]);

        return $data ;
        return Excel::download(new MembersExport, 'members.xlsx');
        flash(translate('Members exported successfully'))->success();
        return back();
        // header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        // header('Cache-Control: no-store, no-cache, must-revalidate');
        // header('Cache-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        // return (new \App\Models\MembersExport)->download('members.xlsx'); 
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
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $membership = $user->membership;
        if (User::destroy($id)) {
            flash('Member has been added to the deleted member list')->success();
            return redirect()->route('members.index', $membership);
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    public function restore_deleted_member($id)
    {
        if (User::withTrashed()->where('id', $id)->restore()) {
            flash('Member has been restored successfully')->success();
            return redirect()->route('deleted_members');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    public function member_permanemtly_delete($id)
    {
      $user = User::withTrashed()->where('id', $id)->first();
      $user->permanently_delete = 1;
        if ($user->save()) {
            flash('Member permanently deleted successfully')->success();
            return redirect()->route('deleted_members');
        } else {
            flash('Sorry! Something went wrong.')->error();
            return back();
        }
    }
    public function package_info(Request $request)
    {
        $member = Member::where('user_id',$request->id)->first();
        return view('admin.members.package_modal', compact('member'));
    }
    public function get_package(Request $request)
    {
        $member_id = $request->id;
        $packages  = Package::where('active',1)->get();
        return view('admin.members.get_package', compact('member_id','packages'));
    }
    public function package_do_update(Request $request, $id){
        $member                             = Member::where('id',$id)->first();
        $package                            = Package::where('id', $request->package_id)->first();
        $member->current_package_id         = $package->id;
        $member->remaining_interest         = $member->remaining_interest + $package->express_interest;
        $member->remaining_contact_view     = $member->remaining_contact_view + $package->contact;
        $member->remaining_photo_gallery    = $member->remaining_photo_gallery + $package->photo_gallery;
        $member->auto_profile_match         = $package->auto_profile_match;
        $member->package_validity           = date('Y-m-d', strtotime($member->package_validity. ' +'. $package->validity .'days'));
        $membership                         = $package->id ;
        if($member->save()){
            $user                = User::where('id',$member->user_id)->first();
            $user->membership    = $membership;
            if($user->save()){
                flash(translate('Member package has been updated successfully'))->success();
                return redirect()->route('members.index', $membership);
            }
        }
        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
    public function member_wallet_balance_update(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $wallet                   = new Wallet;
        $wallet->user_id          = $user->id;
        $wallet->amount           = $request->wallet_amount;
        $wallet->payment_method   = $request->payment_option;
        $wallet->payment_details  = '';
        $wallet->save();
        if($request->payment_option == 'added_by_admin'){
          $user->balance = $user->balance + $request->wallet_amount;
        }
        elseif($request->payment_option == 'deducted_by_admin'){
          $user->balance = $user->balance - $request->wallet_amount;
        }
        if($user->save()){
          flash(translate('Wallet Balance Updated Successfully'))->success();
          return back();
        }
        else{
          flash(translate('Something Went Wrong!'))->error();
          return back();
        }
    }
    public function block(Request $request)
    {
        $user           = User::findOrFail($request->member_id);
        $user->blocked  = $request->block_status;
        if($user->save()){
            $member                 = Member::where('user_id', $user->id)->first();
            $member->blocked_reason = !empty($request->blocking_reason) ? $request->blocking_reason : "" ;
            if($member->save()){
                flash($user->blocked == 1 ? translate('Member Blocked !') : translate('Member Unblocked !') )->success();
                return back();
            }
        }
        flash('Sorry! Something went wrong.')->error();
        return back();
    }
    public function blocking_reason(Request $request)
    {
        $blocked_reason = Member::where('user_id', $request->id)->first()->blocked_reason;
        return $blocked_reason;
    }
    // Login by admin as a Member
    public function login($id)
    {
        $user = User::findOrFail(decrypt($id));
        auth()->login($user, true);
        return redirect()->route('dashboard');
    }
    // Member Profile settings Frontend
    public function profile_settings()
    {
      $member             = User::findOrFail(Auth::user()->id);
      $countries          = Country::where('status',1)->get();
      $states             = State::all();
      $cities             = City::all();
      $religions          = Religion::all();
      $castes             = Caste::all();
      $sub_castes         = SubCaste::all();
      $family_values      = FamilyValue::all();
      $marital_statuses   = MaritalStatus::all();
      $diet_types   = DietType::all();
    //   $on_behalves        = OnBehalf::all();
      $languages          = MemberLanguage::all();
    //   return view('frontend.member.profile.index', compact('member','countries','states','cities','religions','castes','sub_castes','family_values','marital_statuses','diet_types','on_behalves','languages'));
      return view('frontend.member.profile.index', compact('member','countries','states','cities','religions','castes','sub_castes','family_values','marital_statuses','diet_types','languages'));
    }
    // Member Profile settings Frontend
    public function profile_settings_new()
    {
      $member             = User::findOrFail(Auth::user()->id);
      $countries          = Country::where('status',1)->get();
      $states             = State::all();
      $cities             = City::all();
      $religions          = Religion::all();
      $castes             = Caste::all();
      $sub_castes         = SubCaste::all();
      $family_values      = FamilyValue::all();
      $marital_statuses   = MaritalStatus::all();
      $diet_types   = DietType::all();
    //   $on_behalves        = OnBehalf::all();
      $languages          = MemberLanguage::all();
      return view('frontend.member.profile.index1', compact('member','countries','states','cities','religions','castes','sub_castes','family_values','marital_statuses','diet_types','languages'));
    }
    // Change Password
    public function change_password()
    {
      return view('frontend.member.password_change');
    }
    public function password_update(Request $request, $id)
    {
      $rules = [
          'old_password'      => [ 'required'],
          'password'          => [ 'min:8','required_with:confirm_password','same:confirm_password'],
          'confirm_password'  => [ 'min:8'],
      ];
      $messages = [
          'old_password.required'     => translate('Old Password is required'),
          'password.required_with'    => translate('Password and Confirm password are required'),
          'password.same'             => translate('Password and Confirmed password did not matched'),
          'confirm_password.min'      => translate('Max 8 characters'),
      ];
      $validator  = Validator::make($request->all(), $rules, $messages);
      if ($validator->fails()) {
          flash(translate('Sorry! Something went wrong'))->error();
          return Redirect::back()->withErrors($validator);
      }
      $user = User::findOrFail($id);
      if(Hash::check($request->old_password, $user->password))
      {
        $user->password = Hash::make($request->password);
        $user->save();
        flash(translate('Passwoed Updated successfully.'))->success();
        return redirect()->route('member.change_password');
      }
      else
      {
        flash(translate('Old password do not matched.'))->error();
        return back();
      }
    }
    // Member Picture Privacy
    public function picture_privacy()
    {
      return view('frontend.member.picture_privacy');
    }
    public function update_picture_privacy(Request $request, $id)
    {
      $user                           =  Member::where('user_id',$id)->first();
      $user->profile_picture_privacy  =  $request->profile_picture_privacy;
      $user->gallery_image_privacy    =  $request->gallery_image_privacy;
      if($user->save()){
        flash(translate('Picture Privacy Updated Successfully.'))->success();
        return redirect()->route('member.picture_privacy');
      }
      flash(translate('Something Went Wrong!'))->error();
      return back();
    }
    public function update_account_deactivation_status(Request $request)
    {
        $user = Auth::user();
        $user->deactivated = $request->deacticvation_status;
        $deacticvation_msg = $request->deacticvation_status == 1 ? translate('deactivated') : translate('reactivated');
        if($user->save())
        {
            flash(translate('Your account ').$deacticvation_msg.translate(' successfully!'))->success();
            return redirect()->route('dashboard');
        }
        flash(translate('Something Went Wrong!'))->error();
        return back();
    }



    /**
     * new profile settings
     */


    public function basic_profile()
    {
        $marital_statuses = MaritalStatus::all();
      return view('frontend.member.profile.newindex', compact('marital_statuses'));
        // return "basic profile";
    }

    public function basicupdate(Request $request)
    {
        
        // return $request;
        $this->rules = [
            // 'email'         => [ 'email:unique'],
            'first_name'    => [ 'required','max:255'],
            'last_name'     => [ 'required','max:255'],
            'gender'        => [ 'required'],
            'date_of_birth' => [ 'required'],
            'marital_status'=> [ 'required'],
        ];

        $this->messages = [
            // 'email.unique'                     => translate('Email Already Exists.'),
            'first_name.required'             => translate('First Name is required'),
            'first_name.max'                  => translate('Max 255 characters'),
            'last_name.required'              => translate('Last Name is required'),
            'last_name.max'                   => translate('Max 255 characters'),
            'gender.required'                 => translate('Gender is required'),
            'date_of_birth.required'          => translate('Date Of Birth is required'),
            'marital_status.required'         => translate('Marital Status is required'),
        ];

        $rules = $this->rules;
        $messages = $this->messages;
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            flash(translate('Validation error with Basic Profile'))->error();
            return back()->withErrors($validator);
        }

        if($request->email != NULL) {
            if(User::where('email',$request->email)->count() > 1 ){
                flash(translate('Warning: This email is already been used by another member profile.'))->warning();
                return back();  
            }
        }

        /**
         * update details
        */
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->photo = $request->photo;
        $user->email = $request->email;
        $user->save();


        /**
         * Updated member introduction
         *  
         * */ 

        Member::where('user_id', Auth::user()->id)->update([
            "introduction" => $request->introduction
        ]);
        
        flash(translate('Basic information Updated.'))->success();
        return redirect()->route('member.address');  

    }


    public function addressForm()
    {
        $countries          = Country::where('status',1)->get();
        $states             = State::all();
        $cities             = City::all();

        $presentAddress = DB::table('addresses')->where('user_id', Auth::user()->id)->where('type','present')->get();
        // return $presentAddress;
        $permanentAddress = DB::table('addresses')->where('user_id', Auth::user()->id)->where('type','permanent')->get();
        
        return view('frontend.member.profile.newAddress', compact('permanentAddress','presentAddress','countries','states','cities'));
    }


}