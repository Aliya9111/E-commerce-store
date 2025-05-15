<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $fillable=[
        "title",
        "slug",
        "ShortDescription",
        "Description",
        "Shipping_returns",
        "relatedProducts",
        "price",
        "compare_price",
        "categories_id",
        "sku",
        "barcode",
        "track_qty",
        "quantity",
        "pstatus",
        "ProductFeature",
        "Subcategories_id",
        "brands_id",
        ];

    public function categories(){
        return $this->belongsTo(categories::class);
    }
    public function Subcategories(){
        return $this->belongsTo(Subcategories::class);
    }
    public function brands(){
        return $this->belongsTo(brands::class);
    }
    public function productImages(){
        return $this->hasMany(productImages::class,"products_id");
    }
    public function attributes(){
        return $this->hasMany(Attributes::class,"products_id");
    }
    public function ProductsRating(){
        return $this->hasMany(ProductsRating::class,"product_id");
    }
    
}
