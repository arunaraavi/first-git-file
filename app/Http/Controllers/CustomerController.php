<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\customer;
use App\Http\Controllers\Controller;
use Validator,Input,Session,Redirect;
//use Illuminate\Support\Facades\Input;
class CustomerController extends Controller
{
	 public function __construct()
    {
        $this->middleware('auth');
    }
     public function index(Request $request)
    {

        $customer= customer::orderBy('id')->paginate(5);
        return view('Customer.index',compact('customer'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
     public function create()
    {
        return view('Customer.create');
    }

   
    public function store(Request $request)
    {
       $this->validate($request, [
            'name' => 'required',
             'owner' => 'required',
            'status' => 'required',
            'customer_details' => 'required',
            'customer_name' => 'required',
                        
 ]);
        customer::create($request->all());
         return Redirect::to('/customers')
                        ->with('success','Customer Created Successfully');
    }
    /*
     $rules = array(
            'iso' => 'required|max:2',
             'name' => 'required|max:80',
            'nicename' => 'required|max:80',
            'iso3' => 'required|max:3',
            'numcode' => 'required|max:6',
            'phonecode' => 'required|max:5',
        );
      
        $validator = Validator::make(input::all(), $rules); 
        if ($validator->fails()) {
            return Redirect::to('Country/edit')
                ->withErrors($validator)
                ->withInput();

            $input = input::all();
        } else {
            // store
            $country = new country;
            $country->iso      = input::get('iso');
            $country->name     = Input::get('name');
            $country->nicename = Input::get('nicename');
            $country->iso3     = Input::get('iso3');
            $country->numcode  = Input::get('numcode');
            $country->phonecode= Input::get('phonecode');
            $country->save();
            // redirect
            Session::flash('message', 'Successfully created product!');
            return Redirect::to('Country');
        }}*/
     public function show()
     {

     }

      public function edit($id)
    {
        $create = customer::find($id);
        return view('Customer.edit',compact('create'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
        	'name' => 'required|max:2',
            'owner' => 'required|max:80',
            'status' => 'required|max:80',
            'customer_details' => 'required|max:3',
            'customer_name' => 'required|max:6',
        ]);

        customer::find($id)->update($request->all());
         return redirect()->to('/customers')
                        ->with('success','coutry updated successfully');
    }
     
    public function destroy($id)
    {
        customer::find($id)->delete();
         return redirect()->to('/customers')
                        ->with('success','customer deleted successfully');
    }  

public function search(Request $request)
{
    if(empty(Input::get('search'))){
 return redirect()->route('Customer.index');
    }
    else{
    $q = Input::get('search');
$customer = customer::where('name', 'LIKE', '%' . $q . '%')->paginate(2);

return view('Customer/index')->with('customer',$customer);
  }  
 }

}
