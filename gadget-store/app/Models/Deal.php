<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Deal",
 *     type="object",
 *     title="Deal",
 *     description="Deal model for flash deals",
 *     @OA\Property(property="id", type="string", example="68b74ba7002cda59000d800c"),
 *     @OA\Property(property="product_name", type="string", example="MacBook Pro 16\""),
 *     @OA\Property(property="category_id", type="string", nullable=true, example="68b74ba7002cda59000d800d"),
 *     @OA\Property(property="price", type="number", format="float", example=2499000),
 *     @OA\Property(property="old_price", type="number", format="float", example=2999000),
 *     @OA\Property(property="overview", type="string", nullable=true, example="Latest MacBook with advanced features"),
 *     @OA\Property(property="description", type="string", nullable=true, example="Detailed product description"),
 *     @OA\Property(property="about", type="string", nullable=true, example="About this product"),
 *     @OA\Property(property="reviews", type="array", @OA\Items(type="object"), nullable=true),
 *     @OA\Property(property="images_url", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="colors", type="array", @OA\Items(type="object"), nullable=true),
 *     @OA\Property(property="what_is_included", type="array", @OA\Items(type="string"), nullable=true),
 *     @OA\Property(property="specification", type="object", nullable=true),
 *     @OA\Property(property="in_stock", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */

class Deal extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    // Fillable fields for mass assignment
    protected $fillable = [
        'id',
        'product_name',
        'category_id',
        'reviews',
        'price',
        'old_price',
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
        'old_price' => 'decimal:2',
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

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope to filter deals in stock
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    // Scope to filter deals by category
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
