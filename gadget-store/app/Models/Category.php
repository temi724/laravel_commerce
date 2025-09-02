<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Disable auto-incrementing since we're using custom IDs
    public $incrementing = false;

    // Set key type to string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
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

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
