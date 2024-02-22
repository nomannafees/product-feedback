<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $guarded = [];

    function user(){
       return $this->belongsTo(User::class,'user_id','id');
    }
    function category(){
       return $this->belongsTo(Category::class,'category_id','id');
    }
}
