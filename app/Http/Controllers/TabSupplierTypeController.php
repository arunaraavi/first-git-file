<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TabSupplierType;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;

class TabSupplierTypeController extends Controller
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
       return view('TabSupplierType.createsuppliertype');
    }

    public function index(Request $request) 
    {
        return view('/home');
    }
    
    public function list(Request $request) 
    {
        $tabSupplierTypes = TabSupplierType::orderBy('id','DESC')->paginate(2);
        return view('TabSupplierType.suppliertypelist',compact('tabSupplierTypes'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required',
            'modified_by' => 'required',
            'supplier_type' => 'required',
            'credit_days' => 'required',
        ]);
         TabSupplierType::create($request->all());
        return redirect()->to('/suppliertypes')
                        ->with('success','SupplierType created successfully');

   }

   public function show($id)
    {
        $tabSupplierTypes = TabSupplierType::find($id);
        return view('TabSupplierType.showsuppliertype',compact('tabSupplierTypes'));
    }

    public function edit($id)
    {
        $tabSupplierTypes = TabSupplierType::find($id);
        return view('TabSupplierType.editsuppliertype',compact('tabSupplierTypes'));
    }

    public function update($id ,Request $request)
    {
             TabSupplierType::find($id)->update($request->all());
             return redirect()->to('/suppliertypes')
                        ->with('success','suppliertype updated successfully');
    }

    public function destroy($id)
    {
        TabSupplierType::find($id)->delete();
	Session::flash('success','suppliertype sussifully deleted');
	return redirect('/suppliertypes');
    }

    public function search(Request $request)
    {

    $search=Input::get('search');
    //$languages=DB::table('languages')->where('foldername','like','%'.$search.'%')->paginate(1);
     //return view('Language/languagelist')->with('languages',$languages)
           //->with('i', ($request->input('page', 1) - 1) * 2);

   

    # going to next page is not working yet
    $tabSupplierTypes = TabSupplierType::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(1);
    $tabSupplierTypes->appends(['search' => $search]);
    return view('TabSupplierType/suppliertypelist', compact('tabSupplierTypes'))
                 ->with('i', ($request->input('page', 1) - 1) * 1);
    }
}
