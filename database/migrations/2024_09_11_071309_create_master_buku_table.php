<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('master_buku', function (Blueprint $table) {
        $table->id('id_buku');
        $table->string('nama_buku');
        $table->string('pengarang');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('master_buku');
}

};
