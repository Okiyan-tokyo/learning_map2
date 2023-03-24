<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learntheme extends Model
{
    use HasFactory;
    protected $fillable=[
        "big_theme",
        "small_theme",
        "contents",
        "reference",
        "url",
        "is_mastered",
        "conscious"
    ];
}
