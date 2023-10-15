<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoaiBaiViet extends Model
{
    use HasFactory;
    protected $table = 'theloaibaiviet';
    public $timestamps = FALSE;
    public function BaiViet(){
        return $this->hasMany(BaiViet::class,'matheloai','id');
    }
}
