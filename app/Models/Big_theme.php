<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Big_theme extends Model
{
    use HasFactory;
    public $fillable=[
        "big_theme","cont_which","file_which"
    ];

}
