<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'donhang';
    public $timestamps = FALSE;
    public function KhachHang(){
        return $this->belongsTo('App\Models\KhachHang','idkhachhang','id');
    }
    public function NguoiNhan(){
        return $this->belongsTo('App\Models\ThongTinNguoiNhan','idnguoinhan','id');
    }
    public function DanhGia(){
        return $this->hasOne(DanhGia::class,'madon','id');
    }
}
