<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    protected $table = 'khachhang';
    public function DonHang(){
        return $this->hasMany(DonHang::class,'idkhachhang','id');
    }
}
