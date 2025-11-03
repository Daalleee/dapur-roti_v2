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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp')->after('password')->nullable();
            $table->text('alamat')->after('no_hp')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user')->after('alamat');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'alamat', 'role']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }
};
