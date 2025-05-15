<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategories extends Model
{
    use HasFactory;
    public $fillable=["sname","sslug","simage","sstatus","sShowPage","categories_id"];
    public function categories(){
        return $this->belongsTo(categories::class);
    }
    public function products(){
        return $this->hasMany(products::class,'Subcategories_id');
    }
    public function attributes(){
        return $this->hasMany(Attributes::class,'categories_id');
    }
}
