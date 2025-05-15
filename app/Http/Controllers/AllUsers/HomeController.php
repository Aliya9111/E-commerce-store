<?php

namespace App\Http\Controllers\AllUsers;
use App\Http\Controllers\Controller;
use App\Models\favouriteProduct;
use App\Models\Page;
use App\Models\products;
use Auth;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Helper\Helper;
class HomeController extends Controller
{
    public function HomeView(){
        return view("AllUsersPages.Home.Home");
    }

    public function ShowMoreProducts(Request $request, $id){
        $i=0;
        $products=products::where('categories_id',$id)
        ->skip($request->productNo)
        ->take(12)
        ->with('productImages')
        ->get();
        foreach($products as $product){
            $accuracy[$i]=Helper::ReviewsPercentage($product->id);
            $i++;
        }
        // dd($products);
        $productsCount=products::where('categories_id',$id)->count();
        if(Auth::check()){
            $favProducts=favouriteProduct::where('user_id',Auth::id())->pluck('product_id');
        }
        else{ $favProducts=null;}
        // dd($productsCount);
        // dd(intval($request->productNo));
        return response()->json([
            'status'=>true,
            'categoryId'=>$id,
            'products'=>$products,
            'favProducts'=>$favProducts,
            'ProductsCount'=>$productsCount,
            'ProRatings'=>$accuracy
        ]);
    }
 
}
