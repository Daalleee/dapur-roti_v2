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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');      // According to spec
            $table->unsignedBigInteger('kategori_id'); // Foreign key to categories
            $table->integer('harga');           // According to spec
            $table->integer('harga_diskon')->nullable(); // According to spec
            $table->integer('stok');            // According to spec
            $table->text('deskripsi');          // According to spec
            $table->string('foto')->nullable(); // According to spec
            $table->timestamps();
            
            $table->foreign('kategori_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
