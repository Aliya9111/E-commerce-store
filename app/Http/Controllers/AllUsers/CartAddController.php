<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\productImages;
use App\Models\products;
// use Darryldecode\Cart\Cart;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::check()){
            $productsLength=count(Cart::Session(Auth::id())->getContent());
            return view('AllUsersPages/AddCart/CartProducts',["productsLength"=>$productsLength]);
        }
        return redirect()->route('login');
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $product = products::where("id", $request->ProductId)->first();
    $userId=Auth::id();
    if ($product == null) {
        return response()->json([
            'status' => false,
            'message' => "This product is not available"
        ]);
    }
    // Get the first product image (if exists)
    $productImage=null;
    if($request->imageId!=null){
        $productImage = productImages::where('id',$request->imageId)->first();
    }

    if (Cart::Session($userId)->has($product->id)) {
        return response()->json([
            'status' => false,
            'message' => 'Product is already in the cart',
            'titleFail'=> $product->title
        ]);
    }
    Cart::session($userId)->add(array(
        'id' => $product->id,
        'name' => $product->title,
        'price' => $product->price,
        'quantity' => 1,
        'attributes' => array(
            'productImageId' => $productImage ? $productImage->id : '',
            'productImage' => $productImage ? $productImage->name : '',
            'ProductQuantity'=>$product->quantity ==NULL? '' :intval($product->quantity),
            'QuantityPrice'=> $product->price
        )
    ));
    return response()->json([
        'status' => true,
        'title' => $product->title,
        'message' => "Product added successfully to the cart",
        'TotalProducts' => count(Cart::Session($userId)->getContent()),
        'titleSuccess'=> $product->title
    ]);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cart::remove($request->CartProductId);
        // dd(Cart::Session(Auth::id())->get($request->CartProductId));
        // dd($OldQuantity);
        if($request->IncDec=="Increase"){
            $OldProduct=Cart::Session(Auth::id())->get($request->CartProductId);
            $newPrice=$OldProduct->price *($OldProduct->quantity+1);
            // dd($newPrice);
            Cart::Session(Auth::id())->update($request->CartProductId,[
                'quantity'=> [
                    'relative'=>true,
                    'value'=>1
                ],
                'attributes'=> array_merge(
                    Cart::session(Auth::id())->get($request->CartProductId)->attributes->toArray(),
                    ['QuantityPrice'=>$newPrice]
                )
                
            ]);
        }
        if($request->IncDec=="Decrease"){
            $OldProduct=Cart::Session(Auth::id())->get($request->CartProductId);
            $newPrice=$OldProduct->price *($OldProduct->quantity-1);
            // dd($newPrice);
            Cart::Session(Auth::id())->update($request->CartProductId,[
                'quantity'=> [
                    'relative'=>true,
                    'value'=>-1
                ],
                'attributes'=> array_merge(
                    Cart::session(Auth::id())->get($request->CartProductId)->attributes->toArray(),
                    ['QuantityPrice'=>$newPrice]
                )
                
            ]);
        }
        $UpdatedProduct=Cart::Session(Auth::id())->get($request->CartProductId);
        return response()->json([
            'status'=>true,
            'title'=>"Product increase/decrease successfully",
            'productId'=>$UpdatedProduct->id,
            'totalPrice'=>$UpdatedProduct->attributes->QuantityPrice,
            'TotalQuantityPrice'=>Cart::Session(Auth::id())->getSubTotal()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,int $id)
    {
        Cart::Session(Auth::id())->remove($id);
        // dd("d");
        // dd(Cart::getContent());
        return response()->json([
            'status'=>true,
            'title'=>"Successfully delete the product",
            'Count'=>Count(Cart::Session(Auth::id())->getContent()),
            'TotalQuantityPrice'=>Cart::Session(Auth::id())->getSubTotal()
        ]);
    }
}
