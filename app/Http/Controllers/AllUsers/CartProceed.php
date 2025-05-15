<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\BestSellingProduct;
use App\Models\Country;
use App\Models\CoupanCode;
use App\Models\order;
use App\Models\order_item;
use App\Models\productImages;
use App\Models\products;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Validator;
use App\Helper\Helper;
class CartProceed extends Controller
{
    public function ProceedForm(){
        if(Auth::check()){
            if(count(Cart::session(Auth::id())->getContent())>0){
                $countries=Country::where('Status','Active')->get();
                return view('AllUsersPages.AddCart.Proceed',['countries'=>$countries]);
            }
            return redirect()->route('CartPage.index');
            
        }
       return redirect()->route('login');
    }

    public function CountryShipPrice(Request $request){
        // dd(intval($request->CountryId));
        $country=Country::find($request->CountryId);
        if($country){
            $Shiprice=$country->amount;
            $totalPrice=($request->subtotal+$Shiprice)-($request->oldCountry);
            return response()->json(
                [
                    'status'=>true,
                    'Shipprice'=>$Shiprice,
                    'totalPrice'=>$totalPrice,
                    'NewCountryShipping'=>$country->amount
                ]
                );
        }
        return response()->json(
            [
                'status'=>false,
                'totalPrice'=>$request->subtotal-$request->oldCountry,
                'NewCountryShipping'=>0

            ]
            );
       
    }
    public function SubmitOrder(Request $request){
    $rules = [
        'fname' => ['required', 'string', 'max:20'],
        'lname' => ['required', 'string', 'max:20'],
        'email' => ['required', 'email'],
        'CountryId' => ['required'],
        'address' => ['required', 'string', 'max:100'],
        'city' => ['required', 'string'],
        'state' => ['required', 'string'],
        'zipCode' => ['required'],
    ];

    $attributes = [
        'fname' => 'first name',
        'lname' => 'last name',
        'CountryId' => 'Country',
    ];

    $messages = [];

    // Extract and prepare data for validation
    $data = $request->all();
    $completeData = $data['completeData'] ?? []; // Ensure completeData exists

    $inputData = [];
    foreach ($completeData as $item) {
        $inputData[$item['name']] = $item['value'] ?? null;
    }
    // dd($inputData);
    if(key_exists('CardNumber',$inputData) || key_exists('expirayDate',$inputData) || key_exists('cvv',$inputData)){
        $rules['CardNumber']=['required'];
        $rules['expirayDate']=['required','date'];
        $rules['cvv']=['required'];
    }
    $shipping_country=Country::find(intval($inputData['CountryId']));
    // dd($shipping_price);
    $validated = Validator::make($inputData, $rules, $messages, $attributes);
    $coupanDiscountSave=0;
    $coupanCodeApply=null;
    if($inputData['coupanCheck']=='1'){
        $coupan=CoupanCode::where('code',$inputData['coupon_code'])->first();
        $coupanDiscountSave=$coupan->discount_amount;
        $coupanCodeApply=$coupan->code;
    }
    if ($validated->passes()) {
        //store data in order table 
        $order=new order();
        $order->user_id=Auth::id();
        $order->Subtotal=(float)Cart::session(Auth::id())->getSubTotal();
        $order->grand_total=(float)$inputData['totalPrice'];
        $order->Shipping=$shipping_country->amount;
        $order->coupon_code=$coupanCodeApply;
        $order->payment_status=($request->paymentType == 'COD' ? 'not paid' : 'paid');
        $order->status='pending';
        $order->discount=$coupanDiscountSave;
        $order->note=$inputData['note'];
        $order->save();
        
        // store data in order_items table
        $CartData=Cart::session(Auth::id())->getContent();
        foreach($CartData as $data){
            $imageId=null;
            if($data->attributes->productImageId!=null){
                $imageId=productImages::find($data->attributes->productImageId);
                $imageId=$imageId->id;
            }
            order_item::insert([
                'order_id'=>$order->id,
                'products_id'=>$data->id,
                'image_id'=>$imageId,
                'name'=>$data->name,
                'Quantity'=>$data->quantity,
                'price'=>$data->price,
                'total'=>$data->attributes->QuantityPrice,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]);
            // update qunatity of product after selling
            $productQuantityUpdate=products::find($data->id);
            $updateQuantity=abs($productQuantityUpdate->quantity-$data->quantity);
            $productQuantityUpdate->update([
                'quantity'=>$updateQuantity
            ]);
            // update total selling qauntity of product
            $quantitySum=0;
            $bestSellProductGet=BestSellingProduct::where('product_id',$data->id)->first();
            // dd($bestSellProductGet);
            if($bestSellProductGet!=null){
                $quantitySum=$bestSellProductGet->QuantitySum;
            }
            BestSellingProduct::updateOrCreate(
                ['product_id'=>$data->id],
                ['QuantitySum'=>$quantitySum + $data->quantity]
            );   
        }
        // save user address
        $getAddess=UserAddress::where('user_id',Auth::id())->first();
        // dd($getAddess->fname);
        UserAddress::updateOrInsert(
            ["user_id"=>Auth::id()],
            [
                "user_id"=>Auth::id(),
                'country_id'=>intval($inputData['CountryId']),
                'first_name'=>$inputData['fname'],
                'last_name'=>$inputData['lname'],
                'email'=>$inputData['email'],
                'address'=>$inputData['address'],
                'apartment'=>$inputData['apartment'],
                'city'=>$inputData['city'],
                'state'=>$inputData['state'],
                'zip'=>$inputData['zipCode'],
                'created_at'=> empty($getAddess) ? Carbon::now() : $getAddess->created_at,
                'updated_at'=>Carbon::now()
                ]
        );
        Helper::SendEmail($order->id);
        return response()->json([
            'status' => true,
            'OrderDone' => 'OrderDone',
            'orderId'=>$order->id,
            'errors' => $validated->errors(),

        ]);
    }
    
    return response()->json([
        'status' => false,
        'errors' => $validated->errors(),
    ]);
}

    function orderDone(string $id){
        return view('AllUsersPages.AddCart.OrderSubmit',['orderId'=>$id]);
   }
}
