<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanpham1', function (Blueprint $table) {
            $table->id();
            $table->string('TenSanPham');
            $table->string('MoTa');
            $table->string('Gia');
            $table->string('Hinh');
            $table->boolean('TrangThai');
            $table->integer('idDanhMuc');
            $table->integer('idThuongHieu');
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
        Schema::dropIfExists('sanpham1');
    }
};
