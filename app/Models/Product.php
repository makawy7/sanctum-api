<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasSlug;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description'
    ];
}
