<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // Fillable fields for mass assignment
    protected $fillable = [
        'product_name',
        'reviews',
        'price',
        'overview',
        'description',
        'about',
        'images_url',
        'what_is_included',
        'specification',
        'in_stock',
    ];

      protected $casts = [
        'reviews' => 'array',
        'images_url' => 'array',
        'what_is_included' => 'array',
        'specification' => 'array',
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    //     // Accessor to get storage options from specification
    // public function getStorageOptionsAttribute()
    // {
    //     return $this->specification['basefeature']['storage'] ?? [];
    // }

    // // Accessor to check if product has dual SIM
    // public function getHasDualSimAttribute()
    // {
    //     return $this->specification['basefeature']['dualsim'] ?? false;
    // }

    // // Scope to filter products in stock
    // public function scopeInStock($query)
    // {
    //     return $query->where('in_stock', true);
    // }

}
