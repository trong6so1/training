<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;
    protected $table = 'baiviet';
    public $timestamps = FALSE;
    public  function TheLoaiBaiViet(){
        return $this->belongsTo(TheLoaiBaiViet::class,'matheloai','id');
    }
    public function NhanVien(){
        return $this->belongsTo(Admin::class,'nhanvien','id');
    }
}
