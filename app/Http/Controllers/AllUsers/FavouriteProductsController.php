<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\favouriteProduct;
use App\Models\products;
use Auth;
use Illuminate\Http\Request;

class FavouriteProductsController extends Controller
{
    function AddProducts(Request $request, int $id){
        if(Auth::check()){
            // dd($id);
            $product=products::find($id);
            // dd($product);
            if($product){
                // dd("enter");
                favouriteProduct::create([
                    'user_id'=>Auth::id(),
                    'product_id'=>$id
                ]);
                return response()->json([
                    'status'=>true,
                    'id'=>$request->id,
                    'message'=>'<div class="alert alert-success"><strong>Success!'.$product->title.'</strong> product add in favourite</div>'
                ]);
            }
            return response()->json([
                'status'=>false,
                'id'=>$request->id,
                'message'=>'<div class="alert alert-danger"><strong>Fail</strong>Product not present</div>'
            ]);

        }
        session(['urlSave'=>url()->previous()]);
        return response()->json([
            'status'=>'login',
        ]);
        
    }
    public function RemoveProducts(Request $request, int $id){
        // dd($id);
        if(Auth::check()){
            // dd($id);
            $product=products::find($id);
            // dd($product);
            if($product){
                // dd("enter");
                favouriteProduct::where("product_id",$id)->delete();
                return response()->json([
                    'status'=>true,
                    'id'=>$request->id,
                    'identity'=>$request->identity,
                    'message'=>'<div class="alert alert-success"><strong>Success!'.$product->title.'</strong> product remove in your favourite</div>'
                ]);
            }
            return response()->json([
                'status'=>false,
                'id'=>$request->id,
                'message'=>'<div class="alert alert-danger"><strong>Fail</strong>Product not present</div>'
            ]);

        }
        session(['urlSave'=>url()->previous()]);
        return response()->json([
            'status'=>'login',
        ]);
    }
}
