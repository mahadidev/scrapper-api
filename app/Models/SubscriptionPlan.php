<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    public $fillable = [
        "name",
        "requests_total",
        "requests_used",
        "requests_available"
    ];
}