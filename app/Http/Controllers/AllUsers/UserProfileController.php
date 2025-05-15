<?php

namespace App\Http\Controllers\AllUsers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\favouriteProduct;
use App\Models\order;
use App\Models\User;
use App\Models\UserAddress;
use Auth;
use Gate;
use Hash;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function UserProfile(){
        if(Auth::check()){
            $user=User::find(Auth::id());
            $address=UserAddress::where('user_id',Auth::id())->first();
            $countries=Country::orderBy('name','asc')->get();
            $orders=order::where('user_id',Auth::id())->latest()->get();
            $favourite_products=favouriteProduct::where('user_id',Auth::id())->latest()->get();
            $data['user']=$user;
            $data['address']=$address;
            $data['countries']=$countries;

            $data['orders']=$orders;
            $data['favourite_products']=$favourite_products;
            return view('AllUsersPages.profile.Profile',$data);
        }
        return redirect()->route('login');
    }
    public function UpdateAddress(Request $request,int $id){
        if(Auth::check()){
            if(Gate::allows('SingleUser',$id)){
                $request->validate([
                    'firstName'=>'required|string',
                    'lastName'=>'required|string',
                    'email'=>'required|email',
                    'CountryId'=>'required',
                    'city'=>'required|string',
                    'state'=>'required|string',
                    'zipCode'=>'required|string',
                ]);
                UserAddress::updateOrCreate(
                    ["user_id"=>Auth::id()],
                    [
                        "user_id"=>Auth::id(),
                        'country_id'=>$request->CountryId,
                        'first_name'=>$request->get('firstName'),
                        'last_name'=>$request->get('lastName'),
                        'email'=>$request['email'],
                        'address'=>'empty',
                        'city'=>$request['city'],
                        'state'=>$request['state'],
                        'zip'=>$request['zipCode'],
                        ]
                );
                session()->flash('successAddress','Update Address');
                return redirect()->back();
            }
            session()->flash('failAddress','You are not authorize for update the address');
            return redirect()->back();
        }
        return redirect()->back();
    }
    public function ChangePassword(Request $request, int $id){
        if(Auth::check()){
            if(Gate::allows('SingleUser',$id)){
                // dd($request->all());
                $user=User::find($id);
                $request->validate([
                    "oldPassword"=>['required'],
                    "password"=>['required','min:8','confirmed'],
                    "password_confirmation"=>['required','min:8'],
                ]);
                if(Hash::check($request->oldPassword,$user->password)){
                    $user->update([
                        'password'=>Hash::make($request->password),
                    ]);
                    session()->flash('success','Password Update');
                    return redirect()->back();
                }
                session()->flash('fail','old password not correct');
                return redirect()->back();
            }
            session()->flash('fail','You are not authorize to change this password');
            return redirect()->back();

        }
        return redirect()->back();
    }
}
