<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping;
use App\Models\Country;
use Illuminate\Http\Request;
use Validator;

class ShippingPage extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $countries=Country::where('Status','Active');
        // search
        if($request->has('Countrykeyword')){
            $countries->where('name','like','%'. $request->get('Countrykeyword').'%')
            ->orwhere("code",'like','%'.$request->get('Countrykeyword').'%');
    }
         // apply filters through selected list
        if($request->has('countrySort')){
            switch ($request->get('countrySort')) {
                case 'Latest':
                    $countries->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $countries->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $countries->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $countries->orderBy('id', 'desc');
                    break;
            }
        }    
        $countries=$countries->paginate(10);
        $CountryData['countries']=$countries;
        return view('AdminPages.shipping.LoadCountryShipping',$CountryData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AdminPages.shipping.AddCountryShipping');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'code' => 'string|max:10|unique:countries,code',
            'amount' => 'numeric|nullable',
            'Status' => 'required',
        ];

        $messages = [];
        $attributes = [
            'name' => 'Country Name',
            'code' => 'Country Code',
            'amount' => 'Shipping Amount',
            'Status' => 'Shipping Status',
        ];
        // Validate the request data
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // If validation fails, return with errors and input
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();
        Country::create($validated);
        return redirect()->back()->with('success', 'Country added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $country=Country::find($id);
        return view('AdminPages.shipping.UpdateCountryShipping',["country"=>$country]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules=[
            'name' => 'required|string|max:255',
            'code' => 'string|max:10',
            'amount' => 'numeric|nullable',
            'Status' => 'required',
        ];
        $messages=[];
        $attributes=[
            'name' => 'Country Name',
            'code' => 'Country Code',
            'amount' => 'Shipping Amount',
            'Status' => 'Shipping Status',
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        if($validate->passes()){
            // dd($request->all());
            $country=Country::find($id);
            $country->update([
                "name"=>$request->name,
                "code"=>$request->code,
                "amount"=>$request->amount,
                "Status"=>$request->Status,
            ]);
            return redirect()->back()->with("success","Successfully country update");
        }
        return redirect()->back()->with("fail","Country cannot update")->withErrors($validate);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        // dd(Country::find($id));
        $country = Country::find($id);

        if ($country) {
            $country->delete();
            return redirect()->back()->with('success', 'Country deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Country not found.');
        }
    }
}
