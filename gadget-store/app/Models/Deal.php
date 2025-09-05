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
        'storage_options',
        'in_stock',
        'product_status',
    ];

    protected $casts = [
        'reviews' => 'array',
        'images_url' => 'array',
        'colors' => 'array',
        'what_is_included' => 'array',
        'specification' => 'array',
        'storage_options' => 'array',
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'in_stock' => 'boolean',
    ];

    protected $appends = ['storage_options', 'display_price', 'default_storage'];

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

    // Get storage options with pricing
    public function getStorageOptionsAttribute()
    {
        // If storage options are explicitly set in the database, use them
        if (isset($this->attributes['storage_options']) && $this->attributes['storage_options']) {
            $storedOptions = json_decode($this->attributes['storage_options'], true);
            if (is_array($storedOptions) && !empty($storedOptions)) {
                return $storedOptions;
            }
        }

        // Fallback to category-based defaults for backward compatibility
        $categoryName = $this->category ? $this->category->name : '';
        $basePrice = $this->price;

        // Define storage options with prices based on deal category
        if (stripos($categoryName, 'phone') !== false || stripos($categoryName, 'smartphone') !== false) {
            return [
                ['storage' => '128GB', 'price' => $basePrice],
                ['storage' => '256GB', 'price' => $basePrice + 50000], // +50k for 256GB
                ['storage' => '512GB', 'price' => $basePrice + 120000], // +120k for 512GB
                ['storage' => '1TB', 'price' => $basePrice + 250000], // +250k for 1TB
            ];
        } elseif (stripos($categoryName, 'laptop') !== false || stripos($categoryName, 'computer') !== false) {
            return [
                ['storage' => '256GB SSD', 'price' => $basePrice],
                ['storage' => '512GB SSD', 'price' => $basePrice + 80000], // +80k for 512GB
                ['storage' => '1TB SSD', 'price' => $basePrice + 180000], // +180k for 1TB
                ['storage' => '2TB SSD', 'price' => $basePrice + 350000], // +350k for 2TB
            ];
        } elseif (stripos($categoryName, 'tablet') !== false) {
            return [
                ['storage' => '64GB', 'price' => $basePrice],
                ['storage' => '128GB', 'price' => $basePrice + 30000], // +30k for 128GB
                ['storage' => '256GB', 'price' => $basePrice + 70000], // +70k for 256GB
                ['storage' => '512GB', 'price' => $basePrice + 140000], // +140k for 512GB
            ];
        }

        return [];
    }

    // Get display price (first storage option price if storage exists, otherwise base price)
    public function getDisplayPriceAttribute()
    {
        $storageOptions = $this->storage_options;
        if (!empty($storageOptions)) {
            return $storageOptions[0]['price'];
        }
        return $this->price;
    }

    // Get default storage (first storage option)
    public function getDefaultStorageAttribute()
    {
        $storageOptions = $this->storage_options;
        if (!empty($storageOptions)) {
            return $storageOptions[0]['storage'];
        }
        return null;
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
