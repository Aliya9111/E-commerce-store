<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoupanCode;
use App\Models\order;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class CoupanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $coupans=CoupanCode::query();
        if($request->get('bkeyword')){
            $coupans=$coupans->where('code','like','%'. $request->get('bkeyword').'%')
            ->orwhere("name",'like','%'.$request->get('bkeyword').'%');
        }
        // apply filters through selected list
        if($request->get('Coupansort')){
            switch ($request->get('Coupansort')) {
                case 'Latest':
                    $coupans=$coupans->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $coupans=$coupans->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $coupans=$coupans->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $coupans=$coupans->orderBy('id', 'desc');
                    break;
            }
        }
        $coupans=$coupans->paginate(10);
        return view('AdminPages.coupanCode.LoadAllCoupans',['coupans'=>$coupans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AdminPages.coupanCode.AddCoupan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules=[
            'code'=>['required','string','max:30','unique:coupan_codes,code'],
            'name'=>['nullable','unique:coupan_codes,name'],
            'max_uses'=>['nullable','integer'],
            'max_uses_user'=>['nullable','integer'],
            'discount_amount'=>['required','numeric'],
            'min_amount'=>['nullable','numeric'],
            'satarts_at'=>['nullable','date'],
            'expires_at'=>['nullable','date']
        ];
        $messages=[];
        $attributes=[];
        $validated=Validator::make($request->all(),$rules,$messages,$attributes,);
        if($validated->passes()){
            CoupanCode::create(
                $request->all()
            );
            session()->flash('success','to create coupan');
            return back();
        }
        session()->flash('fail','to create coupan');
        return back()->withInput()->withErrors($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,string $code)
    {
        $code=trim($code);
        dd($code);
        $minAmount=$request->minAmount;
        $coupan=CoupanCode::where('code',$code)->where('status',1)->first();
        // dd($coupan);
        if($coupan){
            // false if max uses are end
            if($coupan->max_uses){
                $maxUseCoupan=order::where('coupon_code',$coupan->code)->count();
                if($maxUseCoupan==$coupan->max_uses){
                    return response()->json([
                        'status'=>false,
                        'message'=>'limit of use coupan code is end'
                    ]);
                }
            }
            // false if max uses are end
            if($coupan->max_uses_user){
                $maxUseUserCoupan=order::where('coupon_code',$coupan->code)->where('user_id',Auth::id())->count();
                if($maxUseUserCoupan==$coupan->max_uses_user){
                    return response()->json([
                        'status'=>false,
                        'message'=>'limit of use coupan code is end'
                    ]);
                }
            }
            // false if min amount are satisfied
            if($coupan->min_amount){
                if($minAmount<$coupan->min_amount){
                    return response()->json([
                        'status'=>false,
                        'message'=>'The order price must be large than ' .$coupan->min_amount
                    ]);
                }
            }
            // check the type of discount and the subtartct the discount form totla peice
            if($coupan->type=='fixed'){
                $totalPrice=$minAmount+($coupan->discount_amount);
                // dd($coupan->min_amount);
                // dd($totalPrice);
            }
            else{
                $totalPrice=($coupan->discount_amount/100)*$minAmount;
            }
            // check coupan time start or not
            if($coupan->satarts_at){
                $currentTime=Carbon::now();
                $startDate=Carbon::parse($coupan->satarts_at);
                if($startDate->greaterThan($currentTime)){
                    return response()->json([
                        'status'=>false,
                        'message'=>'The coupan start time in '.$startDate
                    ]);
                }
            }
            // check the start and end time
            if($coupan->expires_at){
                $currentTime=Carbon::now();
                $expireDate=Carbon::parse($coupan->expires_at);
                if($expireDate->lessThan($currentTime)){
                    return response()->json([
                        'status'=>false,
                        'message'=>'The coupan time is end'
                    ]);
                }
            }
            // 
            // dd($coupan);
            return response()->json([
                'status'=>true,
                'coupan'=>$coupan,
                'totalPrice'=>$totalPrice,
                'newCoupanPrice'=>$coupan->discount_amount
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'This coupan not exsist',
            'totalPrice'=>$minAmount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $coupan=CoupanCode::find($id);
        return view('AdminPages.coupanCode.UpdateCoupan',['coupan'=>$coupan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules=[
            'code'=>['required','string','max:30'],
            'name'=>['nullable'],
            'max_uses'=>['nullable','integer'],
            'max_uses_user'=>['nullable','integer'],
            'discount_amount'=>['required','numeric'],
            'min_amount'=>['nullable','numeric'],
            'satarts_at'=>['nullable','date'],
            'expires_at'=>['nullable','date']
        ];
        $messages=[];
        $attributes=[];
        $validated=Validator::make($request->all(),$rules,$messages,$attributes,);
        if($validated->passes()){
            $coupan=CoupanCode::find($id);
            $coupan->update($request->all());
            session()->flash('success','to update coupan');
            return redirect()->back()->withInput();
            
        }
        session()->flash('fail','to update coupan');
        return redirect()->back()->withErrors($validated)->withInput();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        CoupanCode::find($id)->delete();
        session()->flash('success','Something error cannot delete coupan');
        return back();
    }
}
