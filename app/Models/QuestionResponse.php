<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionResponse extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function UserQuestion(){
        return $this->belongsTo(UserQuestion::class);
    }
}
