<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\DanhMuc;
use App\Models\GiamGiaSanPham;
use App\Models\SanPham;
use App\Models\TheLoaiBaiViet;
use App\Models\ThuongHieu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class CartController extends Controller
{
    function __construct()
    {
        $danhmuc = DanhMuc::where('Hien',1)->get();
        $theloaibaiviet = TheLoaiBaiViet::all();
        view()->share('theloaibaiviet',$theloaibaiviet);
        view()->share('danhmuc',$danhmuc);
    }
    public function xemgiohang(Request $request){
        $sanphamkhuyenmai = array();
        if(Session::has('giohang')){
            foreach (session('giohang')->sanpham as $giohang){
                if($giohang['idkhuyenmai']!=""){
                    $idsanpham = trim($giohang['idkhuyenmai']);
                    $idsanpham = explode(' ',$giohang['idkhuyenmai']);
                    foreach($idsanpham as $id){
                        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
                        $giamgia = GiamGiaSanPham::where("soluong",'>',0)->where('id',$id)->where('ngaybatdau','<=',$ngayhomnay)->where('ngayketthuc','>',$ngayhomnay)->first();
                        if($giamgia){
                            array_push($sanphamkhuyenmai,$giamgia);
                        }
                    }
                }
            }
        }
        else{
            $sanphamkhuyenmai = null;
        }
        return view('pages.giohang',['sanphamgiamgia'=>$sanphamkhuyenmai]);
    }
    public function themvaogio(Request $request,$id){
        $url =url()->previous();
        $sp = SanPham::find($id);
        if($request->has('SoLuong')){
            $soluong = $request->SoLuong;
        }
        else{
            $soluong = 1;
        }
            $old_cart = session('giohang')?session('giohang'):null;
            $cart = new Cart($old_cart);
            $cart->themvaogio($sp,$id,$soluong);
            Session::put('giohang',$cart);
        return redirect($url)->with('thanhcong','Thêm Vào Giỏ Hàng Thành Công');
    }
    public function themgiamgiavaogio($id){
        $url =url()->previous();
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        $giamgia = GiamGiaSanPham::where("soluong",'>',0)->where('id',$id)->where('ngaybatdau','<=',$ngayhomnay)->where('ngayketthuc','>',$ngayhomnay)->first();
        if($giamgia){
            $sp = SanPham::find($giamgia->masanpham);
            $old_cart = session('giohang')?session('giohang'):null;
            $soluong = 1;
            $cart = new Cart($old_cart);
            $cart->themgiamgiavaogio($sp,$giamgia->masanpham,$soluong,$giamgia->giakhuyenmai,$id);
            Session::put('giohang',$cart);
            return redirect($url)->with('thanhcong','Thêm Vào Giỏ Hàng Thành Công');
        }
        else{
            return redirect($url)->with('thanhcong','Thêm Vào Giỏ Hàng Thất Bại,Sản Phẩm Đã Hết Giảm Giá');
        }



    }
    public function trugiohang($id){
        if(Session::has('giohang')){
            $old_cart = session('giohang');
            $cart = new Cart($old_cart);
            if($cart->sanpham[$id]['soluong']>1){
                $cart->trugiohang($id);
                Session::put('giohang',$cart);
                return redirect('giohang');
            }
            else{
                return redirect('giohang/xoagiohang/'.$id);
            }
            
        }
    }
    public function xoagiohang($id){
        if(Session::has('giohang')){
            $old_cart = session('giohang');
            $cart = new Cart($old_cart);
            $cart->xoagiohang($id);
            if($cart->tongsoluong !== 0){
                Session::put('giohang',$cart);
            }
            else{
                Session::flush();
            }
        }
        return redirect('giohang');
    }
    public function xoagiamgiagiohang($id){
        if(Session::has('giohang')){
            $giamgia = GiamGiaSanPham::find($id);
            $old_cart = session('giohang');
            $cart = new Cart($old_cart);
            $cart->xoagiamgiagiohang($giamgia->masanpham,$id,$giamgia->giakhuyenmai);
            if($cart->tongsoluong !== 0){
                Session::put('giohang',$cart);
            }
            else{
                Session::flush();
            }
        }
        return redirect('giohang');
    }
}
