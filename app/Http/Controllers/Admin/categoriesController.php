<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\categoryValidate;
use App\Models\categories;
use Validator;
class categoriesController extends Controller
{
    public function LoadCategroyView(Request $request){
        return view("AdminPages.categories.AddCategories");
    }

    public function AddCategory(categoryValidate $request){
        $request->validated();
        $category=new categories();
        $category->cname=$request->cname;
        $category->cslug=$request->cslug;
        $category->cstatus=$request->cstatus;
        $category->cShowPage=$request->cShowPage;
        $category->CAngle=$request->get("rotation-angel1");
        if($request->hasFile("cimage")){
            $image=$request->file("cimage");
            $imageName=time().".".$image->getClientOriginalExtension();
            $image->move(public_path("Admin/images/categories"),$imageName);
            $category->cimage= "Admin/images/categories/".$imageName;
        }
        $category->save();
        return redirect()->back()->with("success","Successfully save the category");
    }
    public function LoadAllCategries(Request $request){
        $categories=categories::query();
        // search
        if($request->get('keyword')){
            $categories->where('cname','like','%'. $request->get('keyword').'%')
            ->orwhere("cslug",'like','%'.$request->get('keyword').'%');
        }
        // apply filters through selected list
        if($request->get('sort')){
            switch ($request->get('sort')) {
                case 'Latest':
                    $categories->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $categories->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $categories->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $categories->orderBy('id', 'desc');
                    break;
            }
        }
        $categories=$categories->paginate(10);
        $data["categories"]=$categories;
        return view("AdminPages.categories.LoadAllCategories",$data);
    }
    // public function LoadSearchCategries(Request $request){
    //     $tempCategory=[];
    //     if($request->term!=""){
    //         $categories=categories::where('cname','like','%'.$request->term.'%')->get();
    //         if($categories!=null){
    //            foreach ($categories as $categorie) {
    //                 $tempCategory[]=array('id'=>$categorie->id,'text'=>$categorie->cname);
    //            } 
           
    //         }
    //     }
    //     return response()->json([
    //         'tags'=>$tempCategory,
    //         'status'=>true
    //     ]);
    // }
    public function LoadUpdateCategries($id){
        $category=categories::find($id);
        $dataUpadate["category"]=$category;
        return view("AdminPages.categories.UpdateCategories",$dataUpadate);
    }

    public function UpdateCategory(Request $request, $id){
        // dd($request->all());
        $rules=[
            "cname"=>["required","string","max:255"],
            "cslug"=>["required","string","max:255"],
            "cimage" => ["image","mimes:jpg,jpeg,gif,png","max:2048"],
        ];
        $messages=[
            "cimage.max"=>"The file size cannot greater then 2MB",
            "cimage.mimes"=>"The file only accpted in jpg,jpeg,gif",
            "cimage.image"=>"Only accpted image",


        ];
        $attributes=[
            "cname"=>"Name",
            "cslug"=>"Slug",
            "cimage"=>"image"
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        if($validate->passes()){
            // dd($request->all());
            $category=categories::find($id);
            $category->update([
                "cname"=>$request->cname,
                "cslug"=>$request->cslug,
                "cstatus"=>$request->cstatus,
                "cShowPage"=>$request->cShowPage,
            ]);
            if($request->hasFile("cimage")){
                $image=$request->file("cimage");
                $ImageName=time()."_".$image->getClientOriginalExtension();
                $image->move(public_path("Admin/images/categories"),$ImageName);
                $category->update([
                    $category->cimage="Admin/images/categories/".$ImageName,
                    $category->CAngle=$request->get("rotation-angel1")
                ]);
            }
            else{
                $category->update([
                    $category->cimage=null,
                    $category->CAngle=$request->get("rotation-angel1")
                ]);
            }
            return redirect()->back()->with("success","Successfully to update category");
        }
        // $errors=$validate->errors();
        return redirect()->back()->with("fail","Failed to update category")->withErrors($validate)->withInput();
    }
    public function DelCategory($id){
        // dd($id);
        categories::find($id)->delete();
        return redirect()->back()->with("success","Succefully delete category");
    }
}
