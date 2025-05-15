<?php

namespace App\Helper;

use App\Mail\InvoiceEmail;
use App\Mail\UserMessage;
use App\Models\categories;
use App\Models\Country;
use App\Models\favouriteProduct;
use App\Models\order;
use App\Models\order_item;
use App\Models\Page;
use App\Models\productImages;
use App\Models\products;
use App\Models\ProductsRating;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserQuestion;
use Auth;
use Mail;

class Helper{
    public static function categories(){
        $categories=categories::orderBy('cname','asc')->get();
        return $categories;
    }
    public static function productsQuantity($coumnName,int $id){
        $productsQuantity=products::where($coumnName,$id)->count();
        return $productsQuantity;
    }
    public static function FeaturedProducts(){
        $FeatureProducts=products::where('ProductFeature' ,'Yes')->where('pstatus','Yes')
        ->latest()
        ->take(12)
        ->get();
        return $FeatureProducts;
    }
    public static function LatestProducts(){
        $latestProducts=products::where('pstatus','Yes')
        ->latest()
        ->take(12)
        ->get();
        return $latestProducts;
    }
    public static function orderDetails(int $id){
        $orderItems=order_item::where('order_id',$id)->orderBy('id','asc')->get();
        return $orderItems;
    }
    public static function SendEmail(int $orderId){
        $order=order::find($orderId);
        $orderItems=order_item::where('order_id',$order->id)->get();
        $address=UserAddress::where('user_id',$order->user_id)->first();
        $country=Country::find($address->country_id);
        $subject="Aliya Online shopping store";
        // dd($address->email);
        Mail::to($address->email)->send(new InvoiceEmail($subject,$order,$orderItems,$address,$country));
    }
    public static function SingleFavPro(int $id){
        $singlefavouritePro=favouriteProduct::where('product_id',$id)->where('user_id',Auth::id())->exists();
        return $singlefavouritePro;
    }
    public static function FavouriteProducts(){
        $productId=[];
        $favouritePro=favouriteProduct::where('user_id',Auth::id())->orderBy('product_id','asc')->get();
        foreach($favouritePro as $favourite){
            $productId[]=$favourite->product_id;
        }
        return $productId;
    }
    public static function LoadPages(){
        $pages=Page::where('status','1')->orderBy('Name','asc')->get();
        return $pages;
    }
    public static function ReviewsPercentage(int $id){
        $products=ProductsRating::where('product_id',$id);
        if($products->Exists()){
            $average=$products->sum('ratings') / $products->count();
            $percentage=$average / 5;
        }
        else{
            $average=0.0;
        }
        return $average;
    }

    public static function UserMessageSend($id){
        $user=User::find($id);
        $userMessageRecord=UserQuestion::where('user_id',$id)->orderBy('id','desc')->first();
        $adminEmail=User::where('status','admin')->value('email');
        $subject= "Received a new message";
        $email=Mail::to($adminEmail)->send(new UserMessage($subject,$userMessageRecord));
        return $email;
        // Mail::to()
    }
    public static function ProductImage($id){
        $Image=productImages::where('products_id',$id)->first();
        return $Image;
    }
    public static function Buyercategories($productIds){
        foreach($productIds as $productId){
            $product=products::where('id',$productId->products_id)->first();
            $category=$product->categories;
            $categoryName[]=$category->cname;
        }
        $uniqueCategories=array_unique($categoryName);
        return $uniqueCategories;
    }
}

