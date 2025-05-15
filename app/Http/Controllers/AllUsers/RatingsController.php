<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\ProductsRating;
use Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\Guard;
use Validator;

class RatingsController extends Controller
{
    public function saveRatings(Request $request){
        // dd($request->all());
        if(Auth::check()){
            $validated=Validator::make($request->all(),[
                    'name'=>['required','string','max:20'],  
                    'email'=>['required','email'],  
                    'ratings'=>['required'],  
                    'comments'=>['required','string','max:200'],  
            ]);
            
            if($validated->passes()){
                if(ProductsRating::where('user_id',$request->userId)
                                    ->where('product_id',$request->productId)
                                    ->exists()){
                    return response()->json([
                        'status'=>'userAlreadyComment',
                    ]);
                }
                ProductsRating::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'user_id'=>$request->userId,
                    'product_id'=>$request->productId,
                    'ratings'=>$request->ratings,
                    'comments'=>$request->comments,
                ]);
                return response()->json([
                    'status'=>true,
                    'message'=>'Posted a review successfully',
                    'errors'=>$validated->errors()

                ]);
            }
            return response()->json([
                'status'=>'validationFail',
                'errors'=>$validated->errors()
            ]);
           
        }

        return response()->json([
            'status'=>false,
            'message'=>'You are not login please first login and then put the reviews'
        ]);
    }
    public function updateCommentSave(Request $request,$id){
        if(Auth::check()){
            $Review=ProductsRating::where('id',$id)->where('user_id',Auth::id())->first();
            if($Review){
                return response()->json([
                    'status'=>true,
                    'Review'=>$Review
                ]);
            }
            return response()->json([
                'status'=>'UnauthorizeUser',
                'message'=>'You are not authorize to update this message'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'You are not login please first login and then update your comment'
        ]);
    }
    public function SaveUpdateComment(Request $request,$id){
        // dd($request->comments);
        $validate=Validator::make($request->all(),[
            'comments'=>['required','max:200','string'],
            [],
            [
                'comments'=>'comment'
            ]
        ]);
        if($validate->passes()){
            $review=ProductsRating::find($id);
            $review->update([
                'comments'=>$request->comments
            ]);
            return response()->json([
                'status'=>true,
                'errors'=>$validate->errors(),
                'review'=>$review
            ]);
        }
        return response()->json([
            'status'=>false,
            'errors'=>$validate->errors()
        ]);
    }
    public function DeleteComment(Request $request,$id){
        if(Auth::check()){
            $Review=ProductsRating::where('id',$id)->where('user_id',Auth::id())->first();
            if($Review){
                $Review->delete();
                return response()->json([
                    'status'=>true,
                    'review'=>$Review

                ]);
            }
            return response()->json([
                'status'=>'UnauthorizeUser',
                'message'=>'You are not authorize for delete this message'
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'You are not login please first login and then delete your comment'
        ]);
    }
}
