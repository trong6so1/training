<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;
    protected $table = 'sanpham1';
    public function DanhMuc(){
        return $this->belongsTo('App\Models\DanhMuc','idDanhMuc','id');
    }
    public function ThuongHieu(){
        return $this->belongsTo('App\Models\ThuongHieu','idThuongHieu','id');
    }
}
