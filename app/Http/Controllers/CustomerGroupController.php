<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerGroups;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;
class CustomerGroupController extends Controller
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
        return view('CustomerGroup.createcustomer');
    }

    public function index(Request $request) 
    {
        return view('/home');
    }

    public function list(Request $request) 
    {
        $customers= CustomerGroups::orderBy('id','DESC')->paginate(2);
        return view('CustomerGroup.customerlist',compact('customers'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {
     
     $this->validate($request, [
            'name' => 'required',
            //'created_at' => 'required',
            //'updated_at' => 'required',
            'modified_by' => 'required',
            'owner' => 'required',
            'idx' => 'required',
            'credit_limit' => 'required',
            'rgt' => 'required',
            'is_group' => 'required',
            'lft' => 'required',
            'customer_group_name' => 'required',
        ]);
      
        CustomerGroups::create($request->all());
        return Redirect::to('/customergroups')
                        ->with('success','customergroup created successfully');
    }

    public function show($id)
    {
        $customers= CustomerGroups::find($id);
        return view('CustomerGroup.showcustomer',compact('customers'));
    }
    
    public function edit($id)
    {
        $customers= CustomerGroups::find($id);
        return view('CustomerGroup.editcustomer',compact('customers'));
    }

    public function update($id ,Request $request)
    {
             CustomerGroups::find($id)->update($request->all());
             return redirect()->to('/customergroups')
                        ->with('success','customergroup updated successfully');

    }

    public function destroy($id)
    {
        CustomerGroups::find($id)->delete();
    Session::flash('success','customer group sussifully deleted');
    return redirect('/customergroups');
    }

    public function search(Request $request)
    {

    $search=Input::get('search');
    //$customers=DB::table('customer_groups')->where('name','like','%'.$search.'%')->paginate(1);
     //return view('CustomerGroup/customerlist')->with('customers',$customers)
              //->with('i', ($request->input('page', 1) - 1) * 2);

   # going to next page is not working yet
    $customers = CustomerGroups::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(1);
$customers->appends(['search' => $search]);
    return view('CustomerGroup/customerlist', compact('customers'))
                  ->with('i', ($request->input('page', 1) - 1) * 1);
    
    }
}
