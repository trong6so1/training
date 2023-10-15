<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangXaHoi extends Model
{
    use HasFactory;

    protected $table = 'mangxahoi';
    public function khachhang(){
        return $this->belongsTo('App\Models\khachhang','idkhachhang','id');
    }
}
