<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'custom_order_id',
        'user_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'bukti_pembayaran',
        'status',
        'alamat_pengiriman',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for the order.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }

    /**
     * Check if order is pending
     */
    public function isPending()
    {
        return $this->status === 'Menunggu';
    }

    /**
     * Check if order is being processed
     */
    public function isProcessing()
    {
        return $this->status === 'Diproses';
    }

    /**
     * Check if order is shipped
     */
    public function isShipped()
    {
        return $this->status === 'Dikirim';
    }

    /**
     * Check if order is completed
     */
    public function isCompleted()
    {
        return $this->status === 'Selesai';
    }
}
