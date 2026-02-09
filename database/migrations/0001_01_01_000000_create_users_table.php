<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Matikan sementara agar tidak bentrok dengan tabel lama saat migrate:fresh
        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary Key Normal (BigInt Auto-Increment)
            $table->string('username', 50)->unique(); // Username tetap ada tapi sebagai Unique Key
            $table->string('password');
            $table->string('nama', 100);
            $table->string('email')->unique()->nullable(); // Tambahkan email agar standar Laravel terpenuhi
            $table->enum('level', ['admin', 'petugas', 'pelanggan'])->default('pelanggan');
            $table->string('foto', 255)->default('default.png');
            $table->rememberToken();
            $table->timestamps(); // Mengaktifkan kembali created_at & updated_at agar lebih profesional
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};