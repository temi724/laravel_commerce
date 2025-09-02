<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
class Sales extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'username',
        'email_address',
        'phone_number',
        'location',
        'state',
        'city',
        'product_ids'
    ];

    protected $casts = [
        'product_ids' => 'array'
    ];

    // Relationship to get products associated with this sale
    public function products()
    {
        return Product::whereIn('id', $this->product_ids ?? []);
    }

    // Accessor to get the count of products in this sale
    public function getProductCountAttribute()
    {
        return count($this->product_ids ?? []);
    }

    // Method to add a product to the sale
    public function addProduct($productId)
    {
        $productIds = $this->product_ids ?? [];
        if (!in_array($productId, $productIds)) {
            $productIds[] = $productId;
            $this->product_ids = $productIds;
        }
    }
}
