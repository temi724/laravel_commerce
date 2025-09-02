<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
class Sales extends Model
{
    //
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'username',
        'emailaddress',
        'phonenumber',
        'location',
        'state',
        'city',
        'product_ids'
    ];

    protected $casts = [
        'product_ids' => 'array'
    ];

    // Generate MongoDB-like ObjectId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateObjectId();
            }
        });
    }

    public static function generateObjectId()
    {
        return sprintf('%08x%08x%08x',
            time(),
            mt_rand(0, 0xffffff),
            mt_rand(0, 0xffffff)
        );
    }

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
