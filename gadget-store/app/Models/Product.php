<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     // Disable auto-incrementing since we're using custom IDs
    public $incrementing = false;
     // Set key type to string
    protected $keyType = 'string';
    // Fillable fields for mass assignment
    protected $fillable = [
        'id',
        'product_name',
        'category_id',
        'reviews',
        'price',
        'overview',
        'description',
        'about',
        'images_url',
        'colors',
        'what_is_included',
        'specification',
        'in_stock',
    ];

      protected $casts = [
        'reviews' => 'array',
        'images_url' => 'array',
        'colors' => 'array',
        'what_is_included' => 'array',
        'specification' => 'array',
        'price' => 'decimal:2',
        'in_stock' => 'boolean',
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

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope to filter products by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

}
