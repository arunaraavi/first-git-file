<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemPrice;
use Session,Validator,Input,Redirect,DB;
use App\Http\Controllers\Controller;
class ItemPriceController extends Controller
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
        return view('ItemPrice.createitemprice');
    }

    public function index(Request $request) 
    {
        return view('/home');
    }
    
    public function list(Request $request) 
    {
        $itemprices= ItemPrice::orderBy('id','DESC')->paginate(2);
        return view('ItemPrice.itempricelist',compact('itemprices'))
            ->with('i', ($request->input('page', 1) - 1) * 2);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'name' => 'required',
            'modified_by' => 'required',
            'item_description' => 'required',
            'item_name' => 'required',
            'currency' => 'required',
            'price_list_rate' => 'required',
            'price_list' => 'required',
        ]);
         ItemPrice::create($request->all());
        return redirect()->to('/itemprices')
                        ->with('success','ItemPrice created successfully');

   }

   public function show($id)
    {
        $itemprices= ItemPrice::find($id);
        return view('ItemPrice.showitemprice',compact('itemprices'));
    }

    public function edit($id)
    {
        $itemprices= ItemPrice::find($id);
        return view('ItemPrice.edititemprice',compact('itemprices'));
    }

    public function update($id ,Request $request)
    {
             ItemPrice::find($id)->update($request->all());
             return redirect()->to('/itemprices')
                        ->with('success','itemprice updated successfully');
    }

    public function destroy($id)
    {
        ItemPrice::find($id)->delete();
	Session::flash('success','itemprice sussifully deleted');
	return redirect('/itemprices');
    }
    
    public function search(Request $request)
    {

    $search=Input::get('search');
    //$languages=DB::table('languages')->where('foldername','like','%'.$search.'%')->paginate(1);
     //return view('Language/languagelist')->with('languages',$languages)
           //->with('i', ($request->input('page', 1) - 1) * 2);

   

    # going to next page is not working yet
    $itemprices = ItemPrice::where('name', 'LIKE', '%' . $search . '%')
        ->paginate(1)->appends(['search' => $search]);
    return view('ItemPrice/itempricelist', compact('itemprices'))
                 ->with('i', ($request->input('page', 1) - 1) * 1);
    }
}
