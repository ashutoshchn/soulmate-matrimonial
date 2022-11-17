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
      return view('admin.member_profile_attributes.diet-types.index', compact('diet_types','sort_search'));
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
            return redirect()->route('diet-types.index');
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
        return view('admin.member_profile_attributes.diet-types.edit', compact('diet_type'));
    }

    /**
     * Update the specified resource in storage.
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

            return redirect()->route('diet-types.index');

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

            return redirect()->route('diet-types.index');

        } else {

            flash('Sorry! Something went wrong.')->error();

            return back();

        }

    }

}





namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Schema;
use ZipArchive;
use File;

class DemoController extends Controller

{

    public function __construct()

    {
        ini_set('memory_limit', '2048M');

        ini_set('max_execution_time', 600);
    }

    public function cron_1()

    {
        if (env('DEMO_MODE') != 'On') {
            return back();
        }

        $this->drop_all_tables();
        $this->import_demo_sql();
    }

    public function cron_2()

    {
        if (env('DEMO_MODE') != 'On') {
           return back();
        }

        $this->remove_folder();

        $this->extract_uploads();

    }

    public function drop_all_tables()

    {

        Schema::disableForeignKeyConstraints();

        foreach (DB::select('SHOW TABLES') as $table) {

            $table_array = get_object_vars($table);

            Schema::drop($table_array[key($table_array)]);

        }

    }

    public function import_demo_sql()

    {

        $sql_path = base_path('demo.sql');

        DB::unprepared(file_get_contents($sql_path));

    }

   public function extract_uploads()

    {

        $zip = new ZipArchive;

        $zip->open(base_path('public/uploads.zip'));

        $zip->extractTo('public/uploads');



    }
    public function remove_folder()

    {

        File::deleteDirectory(base_path('public/uploads'));

    }

}

