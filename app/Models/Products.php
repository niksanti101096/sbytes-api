<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'ProductSeriesName',
        'ProductModel',
        'Stock',
        'Price',
        'ImageUrl',
        'Cpu',
        'Memory',
        'IntegratedGfx',
        'Storage',
        'ScreenSize',
        'Resolution',
        'RefreshRate',
        'Color',
        'Battery',
        'OperatingSystem',
        'Package',
        'product_category_id'
    ];
}
