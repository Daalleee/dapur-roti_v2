<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');        // Foreign key to users
            $table->unsignedBigInteger('produk_id');      // Foreign key to products
            $table->integer('jumlah');                    // According to spec
            $table->integer('total_harga');               // According to spec
            $table->string('bukti_pembayaran')->nullable(); // According to spec
            $table->enum('status', ['Menunggu', 'Diproses', 'Dikirim', 'Selesai'])->default('Menunggu'); // According to spec
            $table->text('alamat_pengiriman');            // According to spec
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
