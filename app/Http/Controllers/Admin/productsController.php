<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\Subcategories;
use App\Models\brands;
use App\Models\products;
use App\Models\tempImages;
use App\Models\productImages;
use App\Models\Attributes;
use App\Models\AttibutesCategories;
use Validator;
use File;
class productsController extends Controller
{
    public function LoadProductView(){
        $categories=categories::orderby("cname","asc")->with("Subcategories")->get();
        $brands=brands::orderBy("bname","asc")->get();
        $dataSend["categories"]=$categories;
        $dataSend["brands"]=$brands;

        return view("AdminPages.Products.AddProduct",$dataSend);
    }
    public function AddProduct(Request $request){
        // dd($request->all());
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:products,slug', 'max:255'],
            'ShortDescription' => ['nullable', 'string'],
            'Description' => ['nullable', 'string'],
            'Shipping_returns' => ['nullable', 'string'],
            'relatedProducts' => ['nullable'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'categories_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'unique:products,sku'],
            'barcode' => ['nullable', 'string'],
            'pstatus' => ['required', 'in:Yes,No'],
            'ProductFeature' => ['required', 'in:Yes,No'],
        ];
        $messages=[
            'categories_id.exists'=>'Please select the category'
        ];
        if($request->track_qty=='on'){
            $rules['quantity']=['required', 'integer', 'min:0'];
        }
        $validate=Validator::make($request->all(),$rules,$messages);
        if($validate->passes()){
            $products=new products();
            $products->title=$request->title;
            $products->slug=$request->slug;
            $products->ShortDescription=$request->ShortDescription;
            $products->Description=$request->Description;
            $products->Shipping_returns=$request->Shipping_returns;
            $products->relatedProducts=(!empty($request->relatedProducts)? implode(',',$request->relatedProducts):'');
            $products->price=$request->price;
            $products->compare_price=$request->compare_price;
            $products->categories_id=$request->categories_id;
            $products->sku=$request->sku;
            $products->barcode=$request->barcode;
            $products->track_qty=$request->track_qty;
            $products->quantity=$request->quantity;
            $products->pstatus=$request->pstatus;
            $products->ProductFeature=$request->ProductFeature;
            if($request->Subcategories_id!='none'){
                $products->Subcategories_id=$request->Subcategories_id;
            }
            if($request->brands_id!='none'){
                $products->brands_id=$request->brands_id;
            }
            $products->save();
            // save the images in image table
            if(!empty($request->images)){
                foreach($request->images as $image_id){
                    $image=tempImages::find($image_id);
                    $olname=$image->Name;
                    $imgArray=explode('.',$olname);
                    $imgext=last($imgArray);
                    $newname=time().'_'.$image->id.'_'.$products->id.'.'.$imgext;
                    $productImages=new productImages();
                    $productImages->name=$newname;
                    $productImages->products_id=$products->id;
                    $productImages->save();
                    // copy image from temp folder to uloads folder
                    $sPath=public_path().'/Admin/images/products/temp/'.$image->Name;
                    $dPath=public_path().'/Admin/images/products/uploads/'.$productImages->name;
                    File::copy($sPath,$dPath);
                }
            }
            //Delete all tempoaray images from temp $ faild folder
            $tempImages=tempImages::get();
            if($tempImages->isNotEmpty()){
                foreach($tempImages as $tempImage){
                    $sourcePath=public_path()."/Admin/images/products/temp/".$tempImage->Name;
                    if(File::exists($sourcePath)){
                        File::delete($sourcePath);
                    }
                }
               //Now delete all temporary images after save in table
                tempImages::truncate(); 
            }
            $faildDir=public_path()."/Admin/images/products/temp/faild";
            if(File::exists($faildDir)){
                File::deleteDirectory($faildDir);
            }

            // now store the attributes of product in Attributes table
            if($request->counter>0){
                for($i=1;$i<=$request->counter;$i++){
                    if($request->has("Attribute-".$i)){
                        $getArrayAttributes=$request->get("Attribute-".$i);
                        $getAttribute=array_shift($getArrayAttributes);
                        $attribute=new Attributes();
                        $attribute->AttrName=$getAttribute;
                        $attribute->counter=$i;
                        $attribute->products_id=$products->id;
                        $attribute->categories_id=$products->categories_id;
                        $attribute->subcategories_id=$products->Subcategories_id;
                        $attribute->save();
                        foreach ($getArrayAttributes as $key => $value) {
                            $attrCategory=new AttibutesCategories();
                            $attrCategory->AttrCategory=$value;
                            $attrCategory->attributes_id=$attribute->id;
                            $attrCategory->CategoryCounter=$key+1;
                            $attrCategory->save();
                        }
                    }
                }
            }
            return redirect()->back()->with('success','Add product successfully');
        }
        else{
            return to_route("product")->withInput()->withErrors($validate)->with('fail','Fail to add product');
            // return redirect()->back()->withInput()->withErrors($validate)->with('fail','Fail to add product');
        }
    }
    public function RealtedProducts(Request $request){
        $tempProduct=[];
        if($request->term!=""){
            $products=products::where('title','like','%'.$request->term.'%')->get();
            if($products!=null){
               foreach ($products as $product) {
                    $tempProduct[]=array('id'=>$product->id,'text'=>$product->title);
               } 
           
            }
        }
        return response()->json([
            'tags'=>$tempProduct,
            'status'=>true
        ]);
    }
    public function LoadAllProducts(Request $request){
        $products=products::query()->with("productImages");

           // search
        if($request->get('productkeyword')){
        $products->where('title','like','%'. $request->get('productkeyword').'%')
        ->orwhere("slug",'like','%'.$request->get('productkeyword').'%');
        }
        // apply filters through selected list
        if($request->get('sort')){
            switch ($request->get('sort')) {
                case 'Latest':
                    $products->orderBy('id', 'desc');
                    break;
                case 'Oldest':
                    $products->orderBy('id', 'asc');
                    break;
                case 'asc':
                    $products->orderBy('id', 'asc');
                    break;
                case 'desc':
                    $products->orderBy('id', 'desc');
                    break;
            }
        }
        $products=$products->paginate(10);
        // dd($products);
        $data["products"]=$products;
        return view("AdminPages.Products.LoadAllProducts",$data);
    }

    public function LoadUpdateProducts($id){
        $categories=categories::orderby("cname","asc")->with("Subcategories")->get();
        $brands=brands::orderBy("bname","asc")->get();
        $product=products::where("id",$id)->with("productImages")->first();
        $Images=$product->productImages()->get();
        $attributes=$product->attributes()->get();
        if(!empty($product->relatedProducts)){
            $relproducts=explode(',',$product->relatedProducts);
        }
        else{
            $relproducts=[];
        }
        // dd($Images);
        $data['product']=$product;
        $data['Images']=$Images;
        $data["categories"]=$categories;
        $data["brands"]=$brands;
        $data["relProducts"]=$relproducts;
        $data["attributes"]=$attributes;
        return view("AdminPages.Products.UpdateProduct",$data);
    }
     // reuse the code of update images
     public function ReuseImgCode($image,$product){
        $olname=$image->Name;
        $imgArray=explode('.',$olname);
        $imgext=last($imgArray);
        $newname=time().'_'.$image->id.'_'.$product->id.'.'.$imgext;
        $productImages=new productImages();
        $productImages->name=$newname;
        $productImages->products_id=$product->id;
        $productImages->save();
        // copy image from temp folder to uloads folder
        $sPath=public_path().'/Admin/images/products/temp/'.$image->Name;
        $dPath=public_path().'/Admin/images/products/uploads/'.$productImages->name;
        File::copy($sPath,$dPath);
    }
    public function UpdateProducts(Request $request,$id){
        // dd($request->all());
        $rules = [
            'title' => ['required','string','max:255'],
            'slug' => ['required','string','max:255'],
            'ShortDescription' => ['nullable', 'string'],
            'Description' => ['nullable', 'string'],
            'Shipping_returns' => ['nullable', 'string'],
            'relatedProducts' => ['nullable'],
            // 'images' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:2048'],
            'price' => ['required', 'numeric', 'min:0'],
            'compare_price' => ['nullable', 'numeric', 'min:0'],
            'categories_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string'],
            'barcode' => ['nullable', 'string'],
            'pstatus' => ['required', 'in:Yes,No'],
            'ProductFeature' => ['required', 'in:Yes,No'],
        ];
        $messages=[
            'categories_id.exists'=>'Please select the category'
        ];
        if($request->track_qty=='on'){
            $rules['quantity']=['required', 'integer', 'min:0'];
        }
        $validated=Validator::make($request->all(),$rules,$messages);
        if($validated->passes()){
            $product=products::find($id);
            $product->update([
                "title"=>$request->title,
                "slug"=>$request->slug,
                "ShortDescription"=>$request->ShortDescription,
                "Description"=>$request->Description,
                "Shipping_returns"=>$request->Shipping_returns,
                "relatedProducts"=>(!empty($request->relatedProducts)? implode(',',$request->relatedProducts):''),
                "price"=>$request->price,
                "compare_price"=>$request->compare_price,
                "categories_id"=>$request->categories_id,
                "sku"=>$request->sku,
                "barcode"=>$request->barcode,
                "track_qty"=>$request->track_qty,
                "quantity"=>$request->quantity,
                "pstatus"=>$request->pstatus,
                "ProductFeature"=>$request->ProductFeature,
            ]);
            if($request->Subcategories_id!='none'){
                $product->update([
                    "Subcategories_id"=>$request->Subcategories_id,
                ]);
            }
            if($request->brands_id!='none'){
                $product->update([
                    "brands_id"=>$request->brands_id,
                ]);
            }
            if(!empty($request->images)){
                foreach(array_unique($request->images) as $image_id){
                    $perImg=productImages::where('id',$image_id)->first();
                    $temImg=tempImages::where('id',$image_id)->first();
                    if($perImg && $temImg){
                        $this->ReuseImgCode($temImg,$product);
                    }

                    if(!(productImages::where('id',$image_id)->exists())){
                        $this->ReuseImgCode($temImg,$product);
                    }
                    
                }
            }
          
             //Delete all tempoaray images from temp folder
            $tempImages=tempImages::get();
            if($tempImages->isNotEmpty()){
                foreach($tempImages as $tempImage){
                    $sourcePath=public_path()."/Admin/images/products/temp/".$tempImage->Name;
                    if(File::exists($sourcePath)){
                        File::delete($sourcePath);
                    }
                }
                //Now delete all temporary images after save in table
                tempImages::truncate(); 
            }
            $faildDir=public_path()."/Admin/images/products/temp/faild";
            if(File::exists($faildDir)){
                File::deleteDirectory($faildDir);
            }
              // now store the update attributes of product in Attributes table
            if($request->counter>0){
                // dd($request->counter);
                $attributes=$product->attributes()->get();
                $oldAttrLength=count($attributes);
                // dd($oldAttrLength);
                $newAttrLength=abs($oldAttrLength-$request->counter);
                // dd($newAttrLength);

                if($oldAttrLength>0){
                    // dd($oldAttrLength);
                    foreach($attributes as $attribute){
                        if($request->has("Attribute-".$attribute->counter)){
                            $attr=$request->get("Attribute-".$attribute->counter);
                            // dd($attr);
                            $attrFirstValue=array_shift($attr);
                            $attribute->update([
                                "AttrName"=>$attrFirstValue,
                            ]);
                            $attrCategories=$attribute->AttibutesCategories()->get();
                            if(count($attrCategories)>0){
                                // delete the previus store categories attribute and then store new 
                                foreach($attrCategories as $attrCategory){
                                    $attrCategory->delete();
                                }
                            }    
                            if(array_count_values($attr)>0){
                                foreach($attr as $key =>$value){
                                    $attrCategoriesObject=new AttibutesCategories();
                                    $attrCategoriesObject->AttrCategory=$value;
                                    $attrCategoriesObject->attributes_id=$attribute->id;
                                    $attrCategoriesObject->CategoryCounter=$key+1;
                                    $attrCategoriesObject->save();
                                }

                            }
                        }
                        else{
                            $attribute->delete();
                        }
                    }
                    $lastCounter=$attribute->counter;
                }
                else{
                    $lastCounter=0;
                }
                // dd($attribute->counter);
                if($newAttrLength>0){
                    // dd($newAttrLength);
                    for($newAtt=$lastCounter+1; $newAtt<=$request->counter;$newAtt++){
                        if($request->has("Attribute-".$newAtt)){
                            $newAttrValues=$request->get("Attribute-".$newAtt);
                            $FirstValue=array_shift($newAttrValues);
                            $attribute=new Attributes();
                            $attribute->AttrName=$FirstValue;
                            $attribute->counter=$newAtt;
                            $attribute->products_id=$product->id;
                            $attribute->categories_id=$product->categories_id;
                            $attribute->subcategories_id=$product->Subcategories_id;
                            $attribute->save();
                            foreach ($newAttrValues as $key=> $value) {
                                $attrCategory=new AttibutesCategories();
                                $attrCategory->AttrCategory=$value;
                                $attrCategory->attributes_id=$attribute->id;
                                $attrCategory->CategoryCounter=$key+1;
                                $attrCategory->save();
                            }
                        }
                    }
                }
            }
            return redirect()->back()->with('success','Update product successfully');
        }
        else{
            return redirect()->back()->withInput()->withErrors($validated)->with('fail','Fail to update product');
        }
    }
   
    public function productDel($id){
        products::find($id)->delete();
        return redirect()->route('productLoad')->with("success","Seccueefully delete product");
    }

    // delete product image
    public function productImgDel($iddel){
        $image=productImages::find($iddel);
        $path=public_path()."/Admin/images/products/uploads/".$image->name;
        File::delete($path);
        $image->delete();
        return redirect()->back();
    }
}
