<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categories extends Model
{
    use HasFactory;
    public $fillable=["cname","cslug","cimage","cstatus","cShowPage","CAngle"];
    public function Subcategories(){
        return $this->hasMany(Subcategories::class,"categories_id");
    }
    public function products(){
        return $this->hasMany(products::class,'categories_id');
    }
    public function attributes(){
        return $this->hasMany(Attributes::class,'subcategories_id');
    }
}
