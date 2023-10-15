<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;
    protected $table = 'chitietdonhang';
    public $timestamps = FALSE; 
    public function SanPham(){
        return $this->belongsTo(SanPham::class,'idsanpham','id');
    }
    public function DonHang(){
        return $this->belongsTo(DonHang::class,'iddonhang','id');
    }

}
