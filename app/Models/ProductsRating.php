<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsRating extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function RatingsLikeDsilike(){
        return $this->hasOne(RatingsLikeDsilike::class,'products_rating');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(products::class);
    }
}
