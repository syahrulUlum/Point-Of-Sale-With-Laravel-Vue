<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('transaksi_id');
            $table->integer('qty');
            $table->unsignedInteger('diskon');
            $table->integer('total_harga');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('no action');
            $table->foreign('transaksi_id')->references('id')->on('transaksis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_details');
    }
}
