<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('custom_order_id')->unique()->after('id');
        });

        // Generate custom order IDs for existing orders
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $customId = $this->generateCustomOrderId();
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['custom_order_id' => $customId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('custom_order_id');
        });
    }

    private function generateCustomOrderId(): string
    {
        // Generate format like AB830 or AB939MJ
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $prefix = $letters[rand(0, strlen($letters) - 1)] . $letters[rand(0, strlen($letters) - 1)];
        
        if (rand(0, 1) === 0) {
            // Format: AB + 3 digits (e.g., AB830)
            $numbers = rand(100, 999);
            return $prefix . $numbers;
        } else {
            // Format: AB + 3 digits + 2 letters (e.g., AB939MJ)
            $numbers = rand(100, 999);
            $suffix = $letters[rand(0, strlen($letters) - 1)] . $letters[rand(0, strlen($letters) - 1)];
            return $prefix . $numbers . $suffix;
        }
    }
};
