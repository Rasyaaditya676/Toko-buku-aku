<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'recipient_name',
        'recipient_phone',
        'shipping_address',
        'city',
        'postal_code',
        'notes',
        'subtotal',
        'shipping_fee',
        'total_price',
        'payment_method',
        'payment_status',
        'status',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'shipping_fee' => 'integer',
        'total_price' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Menunggu Konfirmasi' => 'bg-amber-100 text-amber-800 border-amber-200',
            'Diproses' => 'bg-blue-100 text-blue-800 border-blue-200',
            'Dikirim' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'Selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'Dibatalkan' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-slate-100 text-slate-800 border-slate-200',
        };
    }
}
