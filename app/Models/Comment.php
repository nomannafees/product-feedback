<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    function feedback(){
        return $this->belongsTo(Feedback::class,'feedback_id','id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date))->format('d-m-Y h:i A');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($date))->format('d-m-Y h:i A');
    }
}
