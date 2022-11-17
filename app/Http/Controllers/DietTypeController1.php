<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Models\DietType;

use Redirect;

use Validator;



class DietTypeController extends Controller

{

    public function __construct()

    {

        $this->middleware(['permission:show_diet_type'])->only('index');

        $this->middleware(['permission:edit_diet_type'])->only('edit');

        $this->middleware(['permission:delete_diet_type'])->only('destroy');



        $this->rules = [

            'name'      => ['required','max:255'],

        ];



        $this->messages = [

            'name.required'    => translate('Name is required'),

            'name.max'         => translate('Max 255 characters'),

        ];

    }



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

      $sort_search   = null;

      $diet_types = DietType::latest();



      if ($request->has('search')){

          $sort_search       = $request->search;

          $diet_types  = $diet_types->where('name', 'like', '%'.$sort_search.'%');

      }

      $diet_types = $diet_types->paginate(10);

      return view('admin.member_profile_attributes.diet_types.index', compact('diet_types','sort_search'));

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

        $rules      = $this->rules;

        $messages   = $this->messages;

        $validator  = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {

            flash(translate('Sorry! Something went wrong'))->error();

            return Redirect::back()->withErrors($validator);

        }



        $diet_type              = new DietType;

        $diet_type->name        = $request->name;

        if($diet_type->save())

        {

            flash('New Diet Type has been added successfully')->success();

            return redirect()->route('diet_types.index');

        }

        else {

            flash('Sorry! Something went wrong.')->error();

            return back();

        }



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

        $diet_type       = DietType::findOrFail(decrypt($id));

        return view('admin.member_profile_attributes.diet_types.edit', compact('diet_type'));

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

        $rules      = $this->rules;

        $messages   = $this->messages;

        $validator  = Validator::make($request->all(), $rules, $messages);



        if ($validator->fails()) {

            flash(translate('Sorry! Something went wrong'))->error();

            return Redirect::back()->withErrors($validator);

        }



        $diet_type              = DietType::findOrFail($id);

        $diet_type->name        = $request->name;

        if($diet_type->save())

        {

            flash('Diet Type has been updated successfully')->success();

            return redirect()->route('diet_types.index');

        }

        else {

            flash('Sorry! Something went wrong.')->error();

            return back();

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

        if (DietType::destroy($id)) {

            flash('Diet Type info has been deleted successfully')->success();

            return redirect()->route('diet_types.index');

        } else {

            flash('Sorry! Something went wrong.')->error();

            return back();

        }

    }

}

