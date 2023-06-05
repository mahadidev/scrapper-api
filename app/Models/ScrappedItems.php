<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrappedItems extends Model
{
    use HasFactory;

    protected $fillable = [
        "url",
        "value",
        "type",
        "user_ref"
    ];
}