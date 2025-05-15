<?php

namespace App\Http\Controllers\UserAuthenticate;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
// use Illuminate\Support\Facades\Auth;
use Auth;
use Carbon\Carbon;
use DB;
use Gate;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Validator;

class AuthController extends Controller
{
    public function Login(){
        return view('UserAuthenticate.login');
    }

    // check login details
   

    public function Check(Request $request){
        $counter=session('counter',0);
        $counter++;
        session()->put('counter',$counter);

        if(session('counter') <=5){
            $user=User::where('email',$request->email)->first();
           
            if($user && Hash::check($request->password,$user->password)){
                if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                    $request->session()->regenerate();
                    session()->forget('counter');
                    
                    if(Gate::allows('isAdmin')){
                        return redirect()->route('dashborad');
                    }
                    if(session()->has('urlSave')){
                        $geturl=session()->get('urlSave');
                        session()->forget('urlSave');
                        return redirect($geturl);
                    }
                    return redirect()->route('Home');
                }
            }
            session()->flash('error','Wrong email or password');
            return redirect()->back();
        }
        else{
            $PauseTime=time()+30;
            if(!session()->has('PauseTime')){
                session()->put('PauseTime',$PauseTime);
            }
            if(session()->get('PauseTime') < time()){
                session()->forget(['counter','PauseTime']);
            }
            session()->flash('AttemptsEnd','Your attempts are complete Try again after 30seconds');
            return redirect()->back();
        }
  
        
    }

    public function Register(){
        return view('UserAuthenticate.register');
    }

    // save the new user
    public function Save(Request $request){
        // dd($request->all());
        $rules=[
            'name'=>['required','string','max:30'],
            'email'=>['required','email','unique:users,email'],
            'password'=>['required','string','min:8','confirmed'],
        ];
        $messages=[
            'password.min'=>'Password size must be greater then 8 digits'
        ];
        $validate=Validator::make($request->all(),$rules,$messages);
    
       if($validate->passes()){
        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'gender'=>(!empty($request->gender)? $request->gender: "not selected")

        ]);
        return redirect()->route('login')->with('successLog','Successfully register and now login');
    }
    return redirect()->back()->withErrors($validate)->withInput();
    }

    // logout user
    public function Logout(){
        session()->forget(['counter','lockout_time']);
        Auth::logout();
        return redirect()->back();
    }

    public function emailCheck(Request $request){
        return view('UserAuthenticate.passwordResetEmail');
    }

    public function emailSave(Request $request){
        $request->validate([
            'email'=>['required','email','exists:users,email']
        ]);
        $token=bin2hex(random_bytes(30));
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email'=>$request->email],
            [
                'token'=>$token,
                'created_at'=>Carbon::now()
                
            ]
        );
        $subject="Reset password link";
        $data=[
            'email'=>$request->email,
            'token'=>$token
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($subject,$data));
        session()->flash('success','A link send to your gmail account please go to your account and reset password');
        return redirect()->back();
        // return view('UserAuthenticate.passwordResetEmail');
    }
    public function TokenCheck(Request $request, $token){
        $tokenResult=DB::table('password_reset_tokens')->where('token',$token)->first();
        if($tokenResult){
            return view('UserAuthenticate.PasswordResetForm',['email'=>$tokenResult->email]);
        }
        session()->flash('success','Invalid link please enter email again');
        return redirect()->route('emailSend');
    }
    public function UpdatePasswordSave(Request $request,$email){
        $request->validate([
            'password'=>['required','min:8','string','confirmed'],
            'password_confirmation'=>['required','string','min:8'],
        ]);
        $user=User::where('email',$email)->first();
        $user->update([
            'password'=>Hash::make($request->password)
        ]);
        session()->flash('success','Password change successfully and now ');
        return redirect()->back();
    }
}
