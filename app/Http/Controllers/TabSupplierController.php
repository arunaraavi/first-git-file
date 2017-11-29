<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TabSupplier;
use App\TabSupplierType;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;
class TabSupplierController extends Controller
{
    //
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
      $tabSupplierTypes = TabSupplierType::all();
        return view('TabSupplier.createsupplier',compact('tabSupplierTypes'));
    }

    public function index(Request $request) 
    {
        return view('/home');
    }
    
    public function list(Request $request) 
    {
    	 $tabSuppliers = DB::table('tab_suppliers as ts')->select('ts.id','ts.name as tsname','st.name as stname','ts.supplier_details')
            ->leftJoin('tab_supplier_types as st', 'ts.supplier_type', '=', 'st.id')
            ->paginate(2);
    // $tabSuppliers = TabSupplier::orderBy('id','DESC')->paginate(2);
        return view('TabSupplier.supplierlist',compact('tabSuppliers'))
            ->with('i');
            //->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {

   $rules = array(
            'name' => 'required',
            'language' => 'required',
            'supplier_details' => 'required',
            'country' => 'required',
            'supplier_type' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        );
      
        $validator = Validator::make(Input::all(), $rules);

        
        if ($validator->fails()) 
        {
            return Redirect::to('/createsupplier')
                ->withErrors($validator)
                ->withInput();

            $input = input::all();
        } 
        else 
        {
        	$imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            // store
            $tabSupplier = new TabSupplier;
            $tabSupplier->name       = Input::get('name');
            $tabSupplier->language    = Input::get('language');
            $tabSupplier->supplier_details    = Input::get('supplier_details');
            $tabSupplier->country       = Input::get('name');
            $tabSupplier->supplier_type    = Input::get('supplier_type');
            $tabSupplier->credit_days    = Input::get('supplier_details');
            $tabSupplier->supplier_name    = Input::get('supplier_name');
            $tabSupplier->image    = $imageName;
            $tabSupplier->save();

            // redirect
            Session::flash('success', 'Successfully created supplier!');
            return Redirect::to('/suppliers');
        } 
    }
    

    public function show($id)
    {
    	$tabSuppliers = DB::table('tab_suppliers as ts')->select('ts.name as tsname','st.name as stname','ts.supplier_details')
            ->leftJoin('tab_supplier_types as st', 'ts.supplier_type', '=', 'st.id')->where('ts.id',$id)
            ->get();
           // print_r($tabSuppliers);exit;
       // $tabSuppliers = TabSupplier::find($id);
        return view('TabSupplier.showsupplier',compact('tabSuppliers'));
    }
    

     public function edit($id)
    {
        //$tabSuppliers = TabSupplier::find($id);
        $tabSuppliers = DB::table('tab_suppliers as ts')->select('ts.name as tsname','st.name as stname','ts.supplier_details','ts.credit_days','ts.image','ts.supplier_name','ts.country','ts.language')
            ->leftJoin('tab_supplier_types as st', 'ts.supplier_type', '=', 'st.id')->where('ts.id',$id)
            ->get();
            //print_r($tabSuppliers);exit;
        $tabSupplierTypes = TabSupplierType::all();
        return view('TabSupplier.editsupplier',compact('tabSuppliers','tabSupplierTypes'));
    }

    public function update($id ,Request $request)
    {
       //print_r($id);exit;

        $tabSupplier = TabSupplier::find($id);
        if(!empty($request->image)){

            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);

            $tabSupplier->name       = Input::get('name');
            $tabSupplier->language    = Input::get('language');
            $tabSupplier->supplier_details    = Input::get('supplier_details');
            $tabSupplier->country       = Input::get('country');
            $tabSupplier->supplier_type    = Input::get('supplier_type');
            $tabSupplier->credit_days    = Input::get('credit_days');
            $tabSupplier->supplier_name    = Input::get('supplier_name');
            $tabSupplier->image    = $imageName;
            $tabSupplier->update();
          
             return redirect()->to('/suppliers')
             ->with('success','supplier updated successfully');
    }   

     else{
            $tabSupplier->name       = Input::get('name');
            $tabSupplier->language    = Input::get('language');
            $tabSupplier->supplier_details    = Input::get('supplier_details');
            $tabSupplier->country       = Input::get('country');
            $tabSupplier->supplier_type    = Input::get('supplier_type');
            $tabSupplier->credit_days    = Input::get('credit_days');
            $tabSupplier->supplier_name    = Input::get('supplier_name');
            $tabSupplier->update();
                       return redirect()->to('/suppliers')
                              ->with('success','supplier updated successfully');
        }   

    }

    public function destroy($id)
    {
        TabSupplier::find($id)->delete();
	Session::flash('success','supplier sussifully deleted');
	return redirect('/suppliers');
    }

    public function search(Request $request)
    {
       //echo 'hiii';exit;
    $search=Input::get('search');
    //$languages=DB::table('languages')->where('foldername','like','%'.$search.'%')->paginate(1);
     //return view('Language/languagelist')->with('languages',$languages)
           //->with('i', ($request->input('page', 1) - 1) * 2);

  $tabSuppliers = DB::table('tab_suppliers as ts')->select('ts.id as id','ts.name as tsname','st.name as stname','ts.supplier_details','ts.credit_days','ts.image','ts.supplier_name','ts.country','ts.language')
            ->leftJoin('tab_supplier_types as st', 'ts.supplier_type', '=', 'st.id')
            ->where('ts.name', 'LIKE', '%' . $search . '%')
            ->paginate(1)
            ->appends(['search' => $search]);
    

    # going to next page is not working yet
    //$tabSuppliers = TabSupplier::where('tsname', 'LIKE', '%' . $search . '%')
        //->paginate(1);
   // $tabSuppliers->appends(['search' => $search]);
    return view('TabSupplier/supplierlist', compact('tabSuppliers'))
                 ->with('i', ($request->input('page', 1) - 1) * 1);
    }

    
}
