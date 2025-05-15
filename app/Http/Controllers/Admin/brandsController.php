<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandValidate;
use App\Models\brands;
use Illuminate\Http\Request;
use Validator;
class brandsController extends Controller
{
    public function LoadBrandView(){
        return view("AdminPages.Brands.AddBrand");
    }
    public function AddBrand(BrandValidate $request){
        $request->validated();
        $brand=new brands();
        $brand->bname=$request->bname;
        $brand->bslug=$request->bslug;
        $brand->bstatus=$request->bstatus;
        $brand->bShowPage=$request->bShowPage;
        $brand->save();

        return redirect()->back()->withInput()->with("success","Successfully save the brand");
    }

    public function LoadAllBrands(Request $request){
        $brands=brands::query();
        // search
        if($request->get('bkeyword')){
            $brands->where('bname','like','%'. $request->get('bkeyword').'%')
            ->orwhere("bslug",'like','%'.$request->get('bkeyword').'%');
        }
        // apply filters through selected list
        if($request->get('bsort')){
            switch ($request->get('bsort')) {
                case 'Latest':
                    $brands->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $brands->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $brands->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $brands->orderBy('id', 'desc');
                    break;
            }
}
        $brands=$brands->paginate(10);
        $brandData['brands']=$brands;
        return view("AdminPages.Brands.LoadAllBrands",$brandData);
    }

    public function LoadUpdateBrands($id){
        $brand=brands::find($id);
        $brandData["brand"]=$brand;
        return view("AdminPages.Brands.UpdateBrand",$brandData);
    }

    public function DeleteBrand($id){
        brands::find($id)->delete();
        return redirect()->back()->with('success','Successfully delete the brand');

    }
    public function UpdateBrand(Request $request, $id){
        $rules=[
            "bname"=>["required","string","max:255"],
            "bslug"=>["required","string","max:255"],
        ];
        $messages=[];
        $attributes=[
            "bname"=>"Name",
            "bslug"=>"Slug",
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attributes);
        if($validate->passes()){
            // dd($request->all());
            $category=brands::find($id);
            $category->update([
                "bname"=>$request->bname,
                "bslug"=>$request->bslug,
                "bstatus"=>$request->bstatus,
                "bShowPage"=>$request->bShowPage,
            ]);
            return redirect()->back()->with("success","Successfully to update brand");
        }
        // $errors=$validate->errors();
        return redirect()->back()->with("fail","Failed to update brand")->withErrors($validate)->withInput($request->all());
    }
}
