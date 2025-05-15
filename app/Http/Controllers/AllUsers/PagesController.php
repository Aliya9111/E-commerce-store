<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Page;
use App\Models\products;
use App\Models\ProductsRating;
use App\Models\User;
use App\Models\UserQuestion;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PagesController extends Controller
{
    public function PagesContact(Request $request, string $name){
        $count=0;
        $pageData=Page::where('Name','=',$name)
                    ->where('status','=','1')->first();
        $users=User::where('status', '!=', 'admin')->Where('UserBlock','Yes')->get();
        $GetAllRatings=ProductsRating::get();
        if(count($users) > 0 && count($GetAllRatings)>0){
            foreach($users as $user){
                $userRating=$user->ProductsRating()->sum('ratings');
                $userRatingCount=$user->ProductsRating()->count();
                $average=abs($userRating/$userRatingCount);
                $percentage=$average *100 /5;
                if($percentage > 50){
                    $count++;
                }
            }
        }
        $products=products::count();
        $countries=Country::count();
        $data['pageData']=$pageData;
        $data['products']=$products;
        $data['countries']=$countries;
        $data['count']=$count;


        return view('AllUsersPages.pagesContactShow.PageContact',$data);
    }
    public function SaveMessage(Request $request,$name){
        // dd($request->all());    
        if(Auth::check()){
            $validate=Validator::make($request->all(),[
                'name'=>['required','string'],
                'email'=>['required','email','string','exists:users,email'],
                'message'=>['required']
            ]);
            if($validate->passes()){
                UserQuestion::create([
                    'user_id'=>Auth::id(),
                    'name'=>$request->get('name'),
                    'email'=>$request->get('email'),
                    'message'=>$request->get('message'),
                ]
                );
                $emailSend=\App\Helper\Helper::UserMessageSend(Auth::id());
                return response()->json([
                    'status'=>true,
                    'message'=>'Your message are successfully send',
                    'errors'=>$validate->errors()


                ]);
            }
            return response()->json([
                'status'=>true,
                'errors'=>$validate->errors()
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>'Please first login'
        ]);
    }
}
