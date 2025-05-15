<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\Subcategories;
use PhpParser\Node\Stmt\Return_;
use Validator;

class sub_categoriesController extends Controller
{
    public function LoadSubCategroyView(){
        $Categories=categories::orderBy("cname","asc")->get();
        $dataCate['Categories']=$Categories;
        return view("AdminPages.SubCategories.AddSubCategories",$dataCate);
    } 

    public function AddSubCategries(Request $request){
        // dd($request->all());
        $rules=[
            "sname"=>["required","string","max:255"],
            "sslug"=>["required","string","max:255","unique:Subcategories,sslug"],
            "simage" => ["image","mimes:jpg,jpeg,gif,png","max:2048"],
            "categories_id"=>["required"]
        ];
        $messages=[
            "simage.max"=>"The file size cannot greater then 2MB",
            "simage.mimes"=>"The file only accpted in jpg,jpeg,gif",
            "simage.image"=>"Only accpted image",
        ];
        $attributes=[
            "sname"=>"Name",
            "sslug"=>"Slug",
            "simage"=>"image"
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        $Subcategory=new Subcategories();

        if($validate->passes()){
            $Subcategory->sname=$request->sname;
            $Subcategory->sslug=$request->sslug;
            $Subcategory->categories_id=$request->categories_id;
            $Subcategory->sstatus=$request->sstatus;
            $Subcategory->sShowPage=$request->sShowPage;
            $Subcategory->SAngle=$request->get("rotation-angel1");
            if($request->hasFile("simage")){
                $image=$request->file("simage");
                $imageName=time().".".$image->getClientOriginalExtension();
                $image->move(public_path("Admin/images/Subcategories"),$imageName);
                $Subcategory->simage= "Admin/images/Subcategories/".$imageName;
            }
            $Subcategory->save();
            return redirect()->back()->with("success","Successfully save the Subcategory");
        }
        return redirect()->back()->with("fail","Failed to add Subcategory")->withErrors($validate)->withInput($request->all());
       
    }
    public function LoadAllSubCategries(Request $request){
        $Subcategory = Subcategories::query();
        // dd($catSub);
        if($request->get('skeyword')){
            $Subcategory->where('sname','like','%'. $request->get('skeyword').'%')
            ->orwhere("sslug",'like','%'.$request->get('skeyword').'%');
        }
        // apply filters through selected list
        if($request->get('sort')){
            switch ($request->get('sort')) {
                case 'Latest':
                    $Subcategory->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $Subcategory->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $Subcategory->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $Subcategory->orderBy('id', 'desc');
                    break;
            }
        } 

        $Subcategory=$Subcategory->paginate(10);
        // foreach ($Subcategory as $record) {
        //     echo "<p>".$record."</p>";
        //     echo "<p>".$record->categories->id."</p>";
        // }
        $AllData["subcategories"]=$Subcategory;
        // dd($AllData);
        return view("AdminPages.SubCategories.LoadAllSubCategories",$AllData);
    }
    public function LoadUpdateSubCategries($id){
        $subcategory=Subcategories::find($id);
        // dd($subcategory->categories_id);
        $categories=categories::orderBy("cname","asc")->get();
        return view("AdminPages.SubCategories.UpdateSubCategories",["subcategory"=>$subcategory,"categories"=>$categories]);
    }

    public function DeleteSubCate(Request $request,$id){
        Subcategories::find($id)->delete();
        return redirect()->back()->with("success","Successfully delete the Subcategory");
    }
    public function UpdateSubCategory(Request $request, $id){
        // dd($request->all());
        $rules=[
            "sname"=>["required","string","max:255"],
            // "sslug"=>["required","string","max:255","unique:Subcategories,sslug"],
            "simage" => ["image","mimes:jpg,jpeg,gif,png","max:2048"],
            // "categories_id" => ["required", "exists:categories,id"],
        ];
        $messages=[
            "simage.max"=>"The file size cannot greater then 2MB",
            "simage.mimes"=>"The file only accpted in jpg,jpeg,gif",
            "simage.image"=>"Only accpted image",


        ];
        $attributes=[
            "sname"=>"Name",
            // "sslug"=>"Slug",
            "simage"=>"image"
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        if($validate->passes()){
            // dd($request->all());
            $subcategory=Subcategories::find($id);
            $subcategory->update([
                "sname"=>$request->sname,
                "sslug"=>$request->sslug,
                "categories_id"=>$request->categories_id,
                "sstatus"=>$request->sstatus,
                "sShowPage"=>$request->sShowPage,
            ]);
            if($request->hasFile("simage")){
                $image=$request->file("simage");
                $ImageName=time()."_".$image->getClientOriginalExtension();
                $image->move(public_path("Admin/images/Subcategories"),$ImageName);
                $subcategory->update([
                    $subcategory->simage="Admin/images/Subcategories/".$ImageName,
                ]);
            }
            else{
                $subcategory->update([
                    $subcategory->simage=null,
                    $subcategory->SAngle=$request->get("rotation-angel1")
                ]);
            }
            return redirect()->back()->with("success","Successfully to update category");
        }
        // $errors=$validate->errors();
        return redirect()->back()->with("fail","Failed to update category")->withErrors($validate)->withInput();
    }
       
}
