<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiamGiaSanPham extends Model
{
    use HasFactory;
    protected $table = 'giamgiasanpham';
    public $timestamps = FALSE;
    public function SanPham(){
        return $this->BelongsTo(SanPham::class,'masanpham','id');
    }
}
