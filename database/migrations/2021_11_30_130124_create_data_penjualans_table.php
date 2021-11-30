<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('stok')->unsigned();
            $table->integer('jumlah_terjual')->unsigned();
            $table->enum('jenis_barang', ['Konsumsi', 'Pembersih']);
            $table->date('tanggal_transaksi');
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
        Schema::dropIfExists('data_penjualans');
    }
}
