<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DanhGia;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\TraLoiDanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class KhachHangController extends Controller
{
    public function danhsach(){
        $khachhang = KhachHang::all();
        if($khachhang){
            foreach($khachhang as $kh){
                $sodonhuy[$kh->id] = DonHang::where('idkhachhang',$kh->id)
                ->where('tinhtrangdonhang',-1)->get();
            }
        }
        return view('admin.pages.khachhang.danhsach',['khachhang'=>$khachhang,'sodonhuy'=>$sodonhuy]);
    }
    public function xoa($id){
        $khachhang = KhachHang::find($id);
        if($khachhang){
            $danhgia = DanhGia::where('nguoidang',$id)->get();
            if($danhgia){
                foreach($danhgia as $dg){
                    $traloi = TraLoiDanhGia::where('madanhgia',$dg->id)->get();
                    if($traloi){
                        foreach($traloi as $tl){
                            $tl->delete();
                        }
                    }
                    $dg->delete();
                }
            }
            $donhangdanglam = DonHang::where('idkhachhang',$id)->where('tinhtrangdonhang','>=',0)
                                ->where('tinhtrangdonhang','<',3)->get();
            if($donhangdanglam){
                foreach($donhangdanglam as $don){
                    $chitietdonhang = ChiTietDonHang::where('madon',$don->id)->get();
                    foreach($chitietdonhang as $ct){
                        $ct->delete();
                    }
                    $don->delete();
                }
            }
            $donhang = DonHang::where('idkhachhang',$id)->get();
            if($donhang){
                foreach($donhang as $dh){
                    $dh->idkhachhang = 0;
                    $dh->save();
                }
            }
            $khachhang->delete();
        }
        return redirect('admin/khachhang/danhsach')->with('thanhcong','Xóa Khách Hàng Thành Công');
    }
}
