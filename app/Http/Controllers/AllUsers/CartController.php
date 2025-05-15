<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\BestSellingProduct;
use App\Models\brands;
use App\Models\order_item;
use App\Models\products;
use App\Models\ProductsRating;
use App\Models\Subcategories;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function CartPage(Request $request,$id){
        $bestSellingProducts=null;
        $product=products::where('id',$id)->where('pstatus','Yes');
        if($product->doesntExist()){
            return redirect()->back();
        }
        
        $product=$product->first();
        if($product->Subcategories_id !=NULL){
            $data['subCategory']=Subcategories::where('id',$product->Subcategories_id)->value('sname');
        }
        $product_images=$product->productImages()->get();
        $related_productsId=explode(',',$product->relatedProducts);
        $bestSellingIds=BestSellingProduct::select('product_id')->orderBy('QuantitySum','desc')->take(10)->get();
        $produtRatings=ProductsRating::where('product_id',$id)->get();
        if($bestSellingIds!=null){
            foreach($bestSellingIds as $bestSellingId){
                $bestSellingProducts[]=products::where('id',$bestSellingId->product_id)->where('pstatus','Yes')->first();
            }
        }
        $related_products=products::WhereIn("id",$related_productsId)->get();
        if($product->brands_id){
            $brand=brands::find($product->brands_id);
        }
        else{$brand=null;}
        $data['product']=$product;
        $data['brand']=$brand;
        $data['product_images']=$product_images;
        $data['related_products']=$related_products;
        $data['bestSellingProducts']=$bestSellingProducts;
        $data['produtRatings']=$produtRatings;
        return view('AllUsersPages/AddCart/Cart',$data);
    }
}
