<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserQuestion extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function Users(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function QuestionResponse(){
        return $this->hasMany(QuestionResponse::class,'user_questions_id');
    }
}
