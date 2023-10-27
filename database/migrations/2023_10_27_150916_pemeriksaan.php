<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\AcceptHeader;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pemeriksaan');
            $table->string('nama_pemeriksaan')->nullable();
            $table->string('hasil_pemeriksaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->bigInteger('peserta_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
