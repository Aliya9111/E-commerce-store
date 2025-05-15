<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttibutesCategories extends Model
{
    use HasFactory;
    protected $fillable=['AttrCategory','CategoryCounter'];

    public function attributes(){
        return $this->belongsTo(Attributes::class);
    }
}
