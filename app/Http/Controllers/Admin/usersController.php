<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use App\Http\Requests\UserValidate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Validator;
class usersController extends Controller
{
    public function LoadUserView(){
        return view("AdminPages.Users.AddUser");
    }
    public function AddUser(UserValidate $request){
    //    dd($request->all());
        $request->validated();
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->gender=($request->gender=='Not selected'? 'not selected' : $request->gender);
        $user->number=$request->number;
        $user->dob=$request->dob;
        
        $user->password=Hash::make($request->password);
        $user->status=$request->status;
        $user->UserBlock=$request->UserBlock;

        if($request->hasFile("image")){
            // get image and set the rotating angel and then save in database
            $image=$request->file("image");
            $imageName=uniqid().".".$image->getClientOriginalExtension();

            // $img=Image::make($image->getRealPath());
            // $img->rotate($Getangel1);
            $image->move(public_path("Admin/images/users"),$imageName);
            $user->image= "Admin/images/users/".$imageName;
            $user->angle=$request->get("rotation-angel1");
        }
        $user->save();
        return redirect()->back()->with("success","Successfully save the user")->withInput();
    }
    public function LoadAllUsers(Request $request){
        $user=User::query();
        // search
        if($request->get('ukeyword')){
            $user->where('name','like','%'. $request->get('ukeyword').'%')
            ->orwhere("email",'like','%'.$request->get('ukeyword').'%');
        }
        // apply filters through selected list
        if($request->get('usort')){
            switch ($request->get('usort')) {
                case 'Latest':
                    $user->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $user->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $user->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $user->orderBy('id', 'desc');
                    break;
            }
        }
        $user=$user->paginate(10);
        $userdata["users"]=$user;
        return view("AdminPages.Users.LoadAllUsers",$userdata);
    }
    public function LoadUpdateUser($id){
        $user=User::find($id);
        $userdata["user"]=$user;
        return view("AdminPages.Users.UpdateUser",$userdata);
    }
    public function UpdateUser(Request $request, $id){
        // dd(request()->all());
        if(Gate::any(['isAdmin','SingleUser'],$id)){
            $rules=[
                "name"=>["required","string","max:255"],
                "email"=>["required","email"],
                // "password"
                "image" => ["image","mimes:png,gif,jpg,jpeg","max:2048"],
                "dob"=>["nullable","date"],
                // "gender"=>["in:male,female,transgender","not selected"],
                "number"=>["nullable","numeric","digits:11"]
            ];
            $messages=[
                "image.max"=>"The file size cannot greater then 2MB",
                "image.mimes"=>"The file only accpted in jpg,jpeg,gif",
                "image.image"=>"Only accpted image",
                'number.numeric' => 'The number must be a valid number.',
                'dob.date' => 'The date of birth must be a valid date.',
            ];
            $attributes=[
                "name"=>"Name",
                "email"=>"email",
                "image"=>"image",
            ];
            
            // Add password validation only if the password field is filled
            if ($request->filled('password')) {
                $rules['password'] = ["min:8", "confirmed"];
                $attributes['password'] = "password";
            }
            $validate=Validator::make($request->all(),$rules,$messages,$attributes);
            if($validate->passes()){
                $user=User::find($id);
                $user->update([
                    "name"=>$request->name,
                    "email"=>$request->email,
                    "gender"=>($request->gender=='Not selected'? 'not selected' : $request->gender),
                    "number"=>$request->number,
                    "dob"=>$request->dob,
                    "status"=>$request->status,
                    "UserBlock"=>$request->UserBlock,
                ]);
                if($request->hasFile("image")){
                    $image=$request->file("image");
                    $ImageName=time()."_".$image->getClientOriginalExtension();
                    $image->move(public_path("Admin/images/users"),$ImageName);
                    $user->update([
                        $user->image="Admin/images/users/".$ImageName,
                        $user->angle=$request->get("rotation-angel1")
                    ]);
                }
                else{
                    $user->update([
                        $user->image=null,
                        $user->angle=$request->get("rotation-angel1")
                    ]);
                }
                if ($request->filled('password')) {
                    // dd($request->get('password'));
                    if (!Hash::check($request->password, $user->password)) {
                        $user->update([
                            $user->password = Hash::make($request->password)
                        ]);
                    
                    } else {
                        return redirect()->back()->with('fail', 'Password should be different from the old password')->withInput();
                    }
                }
                
                // dd($user);
                return redirect()->back()->with("success","Successfully to update user");
            }
            // $errors=$validate->errors();
            return redirect()->back()->with("fail","Failed to update user")->withErrors($validate)->withInput();
        }
        return redirect()->back()->with("fail","Your are not authenticate for update this record");

    }
    public function DeleteUser($id){
        // dd($id);
        User::find($id)->delete();
        return redirect()->back()->with("success","Succefully delete user");
    }
}
