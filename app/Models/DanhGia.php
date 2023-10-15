<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $table = 'danhgia';
    public $timestamps = FALSE;
    public function NguoiDang(){
        return $this->belongsTo(KhachHang::class,'nguoidang','id');
    }
    public function TraLoi(){
        return $this->hasOne(TraLoiDanhGia::class,'madanhgia','id');
    }
    // public function SanPham(){
    //     return $this->belongsTo(SanPham::class,'masanpham','id');
    // }
    public function ChiTiet(){
        return $this->belongsTo(ChiTietDonHang::class,'masanpham','id');
    }
    public function DonHang(){
        return $this->belongsTo(DonHang::class,'madon','id');
    }
}
