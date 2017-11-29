<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Languages;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;
class LanguageController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('Language.createlanguage');
    }

    public function index(Request $request) 
    {
        return view('/home');
    }
    
    public function list(Request $request) 
    {
        $languages= Languages::orderBy('id','DESC')->paginate(2);
        return view('Language.languagelist',compact('languages'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {
    	/*$this->validate($request, [
            'foldername' => 'required',
            'languagename' => 'required',
            'description' => 'required',
            'flag_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
         Languages::create($request->all());
        return redirect()->to('/home')
                        ->with('success','Language created successfully');*/

      $rules = array(
            'foldername' => 'required',
            'languagename' => 'required',
            'description' => 'required',
            'flag_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
      
        $validator = Validator::make(Input::all(), $rules);

        
        if ($validator->fails()) 
        {
            return Redirect::to('/createlanguage')
                ->withErrors($validator)
                ->withInput();

            $input = input::all();
        } 
        else 
        {
        	 $imageName = time().'.'.$request->flag_image->getClientOriginalExtension();
            $request->flag_image->move(public_path('images'), $imageName);
            // store
            $language = new Languages;
            $language->foldername       = Input::get('foldername');
            $language->languagename    = Input::get('languagename');
            $language->description    = Input::get('description');
            $language->flag_image    = $imageName;
            $language->save();

            // redirect
            Session::flash('success', 'Successfully created language!');
            return Redirect::to('/languages');
        } 

    	                
    }

    public function show($id)
    {
        $languages= Languages::find($id);
        return view('Language.showlanguage',compact('languages'));
    }

    public function edit($id)
    {
        $languages= Languages::find($id);
        return view('Language.editlanguage',compact('languages'));
    }

    public function update($id ,Request $request)
    {
        $languages = Languages::find(Input::get('id'));

        if(!empty($request->flag_image)){

            $imageName = time().'.'.$request->flag_image->getClientOriginalExtension();
            $request->flag_image->move(public_path('images'), $imageName);

            $languages->foldername       = Input::get('foldername');
            $languages->languagename    = Input::get('languagename');
            $languages->description    = Input::get('description');
            $languages->flag_image    = $imageName;
            $languages->update();
          
             return redirect()->to('/languages')
             ->with('success','languages updated successfully');
    }   

     else{
            $languages->foldername       = Input::get('foldername');
            $languages->languagename    = Input::get('languagename');
            $languages->description    = Input::get('description');
            $languages->update();
                       return redirect()->to('/languages')
                              ->with('success','languages updated successfully');
        }   

    }

   public function destroy($id)
    {
        Languages::find($id)->delete();
	Session::flash('success','language sussifully deleted');
	return redirect('/languages');
    }

    public function search(Request $request)
    {

    $search=Input::get('search');
    //$languages=DB::table('languages')->where('foldername','like','%'.$search.'%')->paginate(1);
     //return view('Language/languagelist')->with('languages',$languages)
           //->with('i', ($request->input('page', 1) - 1) * 2);

   

    # going to next page is not working yet
    $languages = Languages::where('foldername', 'LIKE', '%' . $search . '%')
        ->paginate(1);
$languages->appends(['search' => $search]);
    return view('Language/languagelist', compact('languages'))
                 ->with('i', ($request->input('page', 1) - 1) * 1);
    }

}
