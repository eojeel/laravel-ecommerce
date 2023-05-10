<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $with = ['items'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
    ];

    protected $fillable = [
        'total_price',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->BelongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'created_by');
    }

    public function session_id(): HasOne
    {
        return $this->hasOne(Payment::class, 'session_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
