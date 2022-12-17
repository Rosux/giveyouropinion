<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    
    protected $table = "answer";

    protected $fillable = [
        "userToken",
        "question_id",
        "answeredTime",
        "answers"
    ];

    protected $hidden = [
        "userToken"
    ];

    protected $casts = [
        "answeredTime"
    ];
}
