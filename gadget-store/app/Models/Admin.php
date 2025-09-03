<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Schema(
 *     schema="Admin",
 *     type="object",
 *     title="Admin",
 *     description="Admin model",
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         description="MongoDB-like ObjectId",
 *         example="68b74ba7002cda59000d800c"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Admin name",
 *         example="John Smith"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Admin email address",
 *         example="john.smith@admin.com"
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="Admin phone number",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2025-09-02T20:30:15.000000Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2025-09-02T20:30:15.000000Z"
 *     )
 * )
 */

class Admin extends Model
{
    use HasFactory;

    // Disable auto-incrementing since we're using custom IDs
    public $incrementing = false;

    // Set key type to string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'phone_number',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
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

    /**
     * Verify admin password
     */
    public function checkPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }
}
