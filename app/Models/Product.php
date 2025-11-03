<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'kategori_id',
        'harga',
        'harga_diskon',
        'stok',
        'deskripsi',
        'foto',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    /**
     * Get the orders for the product.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'produk_id');
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Check if the product is on sale
     */
    public function isOnSale()
    {
        return !is_null($this->harga_diskon) && $this->harga_diskon < $this->harga;
    }

    /**
     * Get the original price or current price if on sale
     */
    public function getFinalPrice()
    {
        return $this->isOnSale() ? $this->harga_diskon : $this->harga;
    }
}
