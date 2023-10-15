<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    public function chucvu(){
        return $this->belongsTo(ChucVu::class,'machucvu','id');
    }
}
