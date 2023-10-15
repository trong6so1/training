<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;
    protected $table = 'danhmuc';
    public function SanPham(){
        return $this->hasMany('App\Models\SanPham','idDanhMuc','id');
    }
}
