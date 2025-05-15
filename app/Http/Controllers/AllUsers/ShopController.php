<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\brands;
use App\Models\categories;
use App\Models\products;
use Doctrine\DBAL\Query;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function LoadAllProducts(Request $request, $categoriId,$SubcategroyId=null,$brands=null,$min=null,$max=null){
        // dd($request->all());
        $products=products::query();
        $products=$products->where('categories_id',$categoriId)->where('pstatus','Yes');
        $category=categories::where('id',$categoriId)->first();
        $brands=brands::where('bShowPage','Yes')->orderBy('bname','asc')->get();
        $maxPrice=$products->max('price');
        $minPrice=$products->min('price');
        // this condition true if the id pass to dropdown list
        if($SubcategroyId!=null){
            if(!($request->has('SubCategoriesId'))){
                $products=$products->where('Subcategories_id',$SubcategroyId);
                $productsFillter["SubcategroyId"]=$SubcategroyId;
                // dd($products);
            }
          
        }
        // these consitions for filters
        if ($request->has('SubCategoriesId')) {
            $splitSubcategories=explode(',',$request->SubCategoriesId);
            $products = $products->whereIn('Subcategories_id', $splitSubcategories);
            $productsFillter["splitSubcategories"]=$splitSubcategories;
        } 
        if ($request->has('BrandsId')) {
            $splitBrands=explode(',',$request->BrandsId);
            // dd($splitBrands);
            $products = $products->whereIn('brands_id', $splitBrands);
            $productsFillter["splitBrands"]=$splitBrands;

            // dd($products->toSql(), $products->getBindings());

        }
        if ($request->has('minPrice')) {
            $minPrice = $request->minPrice;
        }
        if ($request->has('maxPrice')) {
            $maxPrice = $request->maxPrice;
        }
        if ($request->has('OrderBy')) {
            if($request->OrderBy=="Latest") {$products = $products->oldest();}
            elseif($request->OrderBy=="Oldest") {$products = $products->latest();}
            elseif($request->OrderBy=="HighPrice") {
                $products = $products->orderBy('price', 'desc');
                // dd($products->toSql(), $products->getBindings());
            }
            elseif($request->OrderBy=="LowPrice") {$products = $products->orderBy('price', 'asc');}
            elseif($request->OrderBy=="Descending") {$products = $products->orderBy('id', 'desc');}
            else{$products = $products->orderBy('id', 'asc');}
        }
        
        $products=$products->whereBetween('price',[$minPrice,$maxPrice]);
        // dd($products->toSql(), $products->getBindings());

        $products=$products->get();
        // dd($products);
        $productsFillter["products"]=$products;
        $productsFillter["category"]=$category;
        $productsFillter["brands"]=$brands;
        $productsFillter["maxPrice"]=$maxPrice;
        $productsFillter["minPrice"]=$minPrice;
    
       
        return view("AllUsersPages.ShopProducts.AllProducts",$productsFillter);
    }
}
