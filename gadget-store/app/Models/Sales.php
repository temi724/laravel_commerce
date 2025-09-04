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
        'order_id',
        'username',
        'emailaddress',
        'phonenumber',
        'location',
        'state',
        'city',
        'product_ids',
        'quantity',
        'order_status',
        'order_type',
        'payment_status',
        'completed_at',
        'approved_by_admin',
        'payment_approved_at'
    ];

    protected $casts = [
        'product_ids' => 'array',
        'order_status' => 'boolean',
        'quantity' => 'integer',
        'payment_status' => 'string',
        'completed_at' => 'datetime',
        'payment_approved_at' => 'datetime'
    ];

    // Generate MongoDB-like ObjectId
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = self::generateObjectId();
            }
            if (empty($model->order_id)) {
                $model->order_id = self::generateOrderId();
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

    public static function generateOrderId()
    {
        do {
            // Generate order ID format: ORD-YYYYMMDD-XXXXXX (e.g., ORD-20250904-123456)
            $orderId = 'ORD-' . date('Ymd') . '-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('order_id', $orderId)->exists());

        return $orderId;
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

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_COMPLETED = 'completed';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

    // Payment status helper methods
    public function isPending()
    {
        return $this->payment_status === self::PAYMENT_PENDING;
    }

    public function isCompleted()
    {
        return $this->payment_status === self::PAYMENT_COMPLETED;
    }

    public function isFailed()
    {
        return $this->payment_status === self::PAYMENT_FAILED;
    }

    public function isRefunded()
    {
        return $this->payment_status === self::PAYMENT_REFUNDED;
    }

    public function markAsPending()
    {
        $this->payment_status = self::PAYMENT_PENDING;
        return $this->save();
    }

    public function markAsCompleted($adminName = null)
    {
        $this->payment_status = self::PAYMENT_COMPLETED;
        $this->payment_approved_at = now();
        if ($adminName) {
            $this->approved_by_admin = $adminName;
        }
        return $this->save();
    }

    public function markAsFailed()
    {
        $this->payment_status = self::PAYMENT_FAILED;
        return $this->save();
    }

    public function markAsRefunded()
    {
        $this->payment_status = self::PAYMENT_REFUNDED;
        return $this->save();
    }

    // Order completion methods
    public function markOrderAsCompleted($adminName = null)
    {
        $this->order_status = true;
        $this->completed_at = now();
        if ($adminName) {
            $this->approved_by_admin = $adminName;
        }
        return $this->save();
    }

    // Check if order is completed
    public function isOrderCompleted()
    {
        return $this->order_status === true;
    }

    // Get formatted completion date
    public function getFormattedCompletedDateAttribute()
    {
        return $this->completed_at ? $this->completed_at->format('M d, Y h:i A') : null;
    }

    // Get formatted payment approval date
    public function getFormattedPaymentApprovedDateAttribute()
    {
        return $this->payment_approved_at ? $this->payment_approved_at->format('M d, Y h:i A') : null;
    }

}
