<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraLoiDanhGia extends Model
{
    use HasFactory;
    protected $table = 'traloidanhgia';
    public $timestamps = FALSE;
    public function NhanVienTraLoi(){
        return $this->belongsTo(Admin::class,'nguoidang','id');
    }
}
