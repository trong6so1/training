<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public $sanpham = null;
    public $tongsoluong = 0;
    public $tonggiatien = 0;
    function __construct($cart)
    {
        if($cart){
        $this->sanpham = $cart->sanpham;
        $this->tongsoluong =$cart->tongsoluong;
        $this->tonggiatien = $cart->tonggiatien;
        }
    }
    public function themvaogio($sanpham,$id,$soluong){
        $giohang=['soluong'=>0,'sanpham'=>$sanpham,'idkhuyenmai'=>""];
        if($this->sanpham){
            if(array_key_exists($id,$this->sanpham)){
                $giohang = $this->sanpham[$id];                    
            }
        }
        $giohang['soluong'] += $soluong;
        $this->sanpham[$id] = $giohang;
        $this->tongsoluong += $soluong;
        $this->tonggiatien += $sanpham['Gia'] * $soluong;

    }
    public function themgiamgiavaogio($sanpham,$id,$soluong,$gia,$idgiamgia){
        $giohang=['soluong'=>0,'sanpham'=>$sanpham,'idkhuyenmai'=>""];
        if($this->sanpham){
            if(array_key_exists($id,$this->sanpham)){
                $giohang = $this->sanpham[$id];                    
            }
        }
        if($giohang['idkhuyenmai']==""){
            $giohang['idkhuyenmai'].=' '.$idgiamgia;
            $this->sanpham[$id] = $giohang;
            $this->tongsoluong += 1;
            $this->tonggiatien += $gia;
        }
        else{
            if(substr_count($giohang['idkhuyenmai'],(string)$idgiamgia)>0){
                $giohang['soluong'] += 1;
                $this->sanpham[$id] = $giohang;
                $this->tongsoluong += $soluong;
                $this->tonggiatien += $sanpham['Gia'] * $soluong;
            }
            else{
                $giohang['idkhuyenmai'].=' '.$idgiamgia;
                $this->sanpham[$id] = $giohang;
                $this->tongsoluong += 1;
                $this->tonggiatien += $gia;
            }
        }
        

    }
    public function trugiohang($id){
        //$giohang=['soluong'=>0,'sanpham'=>$sanpham];
        if(array_key_exists($id,$this->sanpham)){
            $giohang = $this->sanpham[$id];
            $giohang['soluong']--;
            $this->sanpham[$id] = $giohang;
            $this->tongsoluong --;
            $this->tonggiatien -= $giohang['sanpham']['Gia'];
        }

    }
    public function xoagiohang($id){
        if(array_key_exists($id,$this->sanpham)){
            $giohang = $this->sanpham[$id];
            unset($this->sanpham[$id]);
            $this->tongsoluong -= $giohang['soluong'];
            $this->tonggiatien -= $giohang['soluong'] * $giohang['sanpham']['Gia'];
        }
    }
    public function xoagiamgiagiohang($id,$idgiamgia,$giakhuyenmai){
        if(array_key_exists($id,$this->sanpham)){
            $giohang = $this->sanpham[$id];
            $giohang['idkhuyenmai'] = str_replace(' '.$idgiamgia,'',$giohang['idkhuyenmai']);
            $this->sanpham[$id] = $giohang;
            $this->tongsoluong -= 1;
            $this->tonggiatien -= $giakhuyenmai;
        }
    }
}
