<?php

namespace App\Http\Controllers\Admin;
use File;
use Intervention\Image\Facades\Image; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\tempImages;
use Validator;
class TempImagesController extends Controller
{
    public function StoreImages(Request $request){
        $rules=[
            'image'=>['image','mimes:jpg,jpeg,png,gif','max:2048']
        ];
        $messages=[
            'image.image'=>'Only select the image',
            'image.mimes'=>'The image type should consists on particular extensions jpg,jpeg,png,gif',
            'image.max'=>'The file size must be less than or equal 2MB'
        ];
        $attribute=[
            'image'=>'Image field',
        ];
        $validate=Validator::make($request->all(),$rules,$messages,$attribute);
        if($validate->passes()){
            if($request->hasFile('image')){
                $image=$request->file('image');
                $ImgName=hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                $tempImages=new tempImages();
                $tempImages->Name=$ImgName;
                $tempImages->save();
    
                // store image in public/Admin/images/products/thumb directory
                $image->move(public_path('Admin/images/products/temp'),$tempImages->Name);
                // $sPath=public_path().'/Admin/images/products/temp/'.$tempImages->Name;
                // $dPath=public_path().'/Admin/images/products/'.$tempImages->Name;
                // dd($imgPath);
                // print_r($imgPath);
                // $image=Image::make($sPath);
                // $image->resize(1400,null,function($constraint){
                //     $constraint->aspectRatio();
                // });
                // $image->resize(370,246);
                // $image->save($dPath);
    
            
            }
            return response()->json([
                'status'=>true,
                'image_id'=>$tempImages->id,
                'imagePath'=>asset("Admin/images/products/temp/".$ImgName),
                'Success'=>"Sucessfully upload image"
            ]);
        }
        else{
            $image=$request->file('image');
            $faildDir=public_path()."Admin/images/products/temp/faild";
            if(!File::exists($faildDir)){
                  File::makeDirectory($faildDir, 0755, true);
            }
            $image->move(public_path('Admin/images/products/temp/faild/'),$image->getClientOriginalName());
            return response()->json([
                'status'=>false,
                'image_id'=>$image->getClientOriginalName(),
                'imagePath'=>asset("Admin/images/products/temp/faild/".$image->getClientOriginalName()),
                'error'=>$validate->errors()->all()
            ]);
        }
      
       
    }
}
