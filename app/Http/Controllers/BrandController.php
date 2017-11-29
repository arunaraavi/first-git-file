<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;
class BrandController extends Controller
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
        return view('Brand.createbrand');
    }

    public function index(Request $request) 
    {
        return view('/home');
    }
    
    public function list(Request $request) 
    {
        $brands= Brand::orderBy('id','DESC')->paginate(2);
        return view('Brand.brandlist',compact('brands'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'brand' => 'required',
            'modified_by' => 'required',
            'description' => 'required',
        ]);
         Brand::create($request->all());
        return redirect()->to('/brands')
                        ->with('success','Brand created successfully');

   }

   public function show($id)
    {
        $brands= Brand::find($id);
        return view('Brand.showbrand',compact('brands'));
    }

    public function edit($id)
    {
        $brands= Brand::find($id);
        return view('Brand.editbrand',compact('brands'));
    }

    public function update($id ,Request $request)
    {
             Brand::find($id)->update($request->all());
             return redirect()->to('/brands')
                        ->with('success','brand updated successfully');
    }

    public function destroy($id)
    {
        Brand::find($id)->delete();
	Session::flash('success','brand sussifully deleted');
	return redirect('/brands');
    }

    public function search(Request $request)
    {

    $search=Input::get('search');
    //$languages=DB::table('languages')->where('foldername','like','%'.$search.'%')->paginate(1);
     //return view('Language/languagelist')->with('languages',$languages)
           //->with('i', ($request->input('page', 1) - 1) * 2);

   

    # going to next page is not working yet
    $brands = Brand::where('brand', 'LIKE', '%' . $search . '%')
        ->paginate(1)->appends(['search' => $search]);
    return view('Brand/brandlist', compact('brands'))
                 ->with('i', ($request->input('page', 1) - 1) * 1);
    }
}
