<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    use HasFactory;
    protected $fillable=['AttrName','counter'];
    public function products(){
        return $this->belongsTo(products::class);
    }
    public function attibutesCategories(){
        return $this->hasMany(AttibutesCategories::class,"attributes_id");
    }
    public function categories(){
        return $this->belongsTo(Categories::class);
    }
    public function subcategories(){
        return $this->belongsTo(Subcategories::class);
    }
}
