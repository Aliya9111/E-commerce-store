<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\order;
use App\Models\order_item;
use App\Models\UserAddress;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function LoadOrders(Request $request){
        $orders=order::query();

           // search
        if($request->get('orderkeyword')){
            $orders=$orders->where('id','like','%'. $request->get('orderkeyword').'%');
        }
            // apply filters through selected list
        if($request->get('sort')){
            switch ($request->get('sort')) {
                case 'Latest':
                    $orders=$orders->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $orders=$orders->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $orders=$orders->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $orders=$orders->orderBy('id', 'desc');
                    break;
            }
        }
        $orders=$orders->paginate(10);
        // dd($products);
        return view('AdminPages.orders.LoadAllOrders',['orders'=>$orders]);
    }

    public function SingeUserOrder(int $orderId, int $userId){
        // dd("ff");
        $order=order::find($orderId);
        $orderItems=order_item::where('order_id',$orderId)->get();
        $userAddress=UserAddress::where('user_id',$userId)->first();
        $country=Country::find($userAddress->country_id);
        $Orderget['order']=$order;
        $Orderget['orderItems']=$orderItems;
        $Orderget['userAddress']=$userAddress;
        $Orderget['country']=$country;
        

        return view('AdminPages.orders.SingleUserOrder',$Orderget);
    }
    public function UpdatePaymentStatus(Request $request){
        $order=order::find($request->orderId);
        $order->update([
            'payment_status'=>$request->paymentType
        ]);
        return response()->json([
            'status'=>true,
            'message'=>"status update",
            'paymentType'=>$order->payment_status
        ]);

    }
    public function UpdateOrderStatus(Request $request){
        // dd($request->shippedDate);
        $order=order::find($request->orderId);
        if($request->orderType=='shipped'){
            if($request->get("shippedDate")!=null){
                $order->update([
                    'status'=>$request->orderType,
                    'Shipped_Date'=>Carbon::parse($request->shippedDate)->format('Y-m-d H:i:s')
            ]);
            return response()->json([
                'status'=>true,
                'message'=>"status update",
                'orderType'=>$order->status,
                'shippedDateUpdate'=>$order->Shipped_Date
            ]);
            }
            else{
                return response()->json([
                    'status'=>false,
                    'error'=>"Shipped date is required",
                ]);
            }
        }
        else{
            $order->update([
                'status'=>$request->orderType
            ]);
        }
        return response()->json([
            'status'=>true,
            'message'=>"status update",
            'orderType'=>$order->status
        ]);

    }
}
