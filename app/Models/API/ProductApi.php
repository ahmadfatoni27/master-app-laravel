<?php

namespace App\Models\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'price',
        'stock',
        'description',
    ];
}
