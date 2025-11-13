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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_invoice')->unique();
            $table->foreignId('id_pelanggan')
                ->constrained('pelanggan')
                ->onDelete('cascade');
            $table->date('tgl_masuk');
            $table->date('tgl_selesai')->nullable();
            $table->enum('status', ['Proses', 'Selesai', 'Diambil'])->default('Proses');
            $table->enum('dibayar', ['Belum', 'Sudah'])->default('Belum');
            $table->string('foto')->nullable();
            $table->integer('total')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
        $table->dropColumn('foto');
    }
};
