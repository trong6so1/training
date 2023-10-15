<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DonHang;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DonHangController extends Controller
{
    public function danhsach(){
        $donhang = DonHang::where('tinhtrangdonhang',3)->get();
        return view('admin.donhang.danhsachdonhang',['donhang'=>$donhang]);
    }
    public function danglam(){
        $donhang = DonHang::where('tinhtrangdonhang','<',2)->get();
        return view('admin.donhang.danglam',['donhang'=>$donhang]);
    }
    public function chitietdonhang($id){
        $chitiet = ChiTietDonHang::where('iddonhang',$id)->get();
        $donhang = DonHang::find($id);
        return view('admin.donhang.chitietdonhang',['chitiet'=>$chitiet,'donhang'=>$donhang]);
    }
    public function xacnhandon($id){
            $donhang = DonHang::find($id);
            $donhang->tinhtrangdonhang = 1;
            $donhang->save();
            $thongbao = new ThongBao();
            $thongbao->tieude = "Đơn Hàng Đã Được Xác Nhận";
            $thongbao->noidung = "<p>Đơn Hàng Có Mã Số:<b>".$donhang->id."</b> Đã Được Cửa Hàng Xác Nhận</p>";
            $thongbao->loaithongbao = 2;
            $thongbao->idkhachhang = $donhang->idkhachhang;
            $gio = Carbon::now("Asia/Ho_Chi_Minh");
            $thongbao->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
            $thongbao->ngayketthuc = $gio->addDay(7);
            $chitietdonhang = ChiTietDonHang::where('iddonhang',$donhang->id)->first();
            $thongbao->hinhanh = 'sanpham/'.$chitietdonhang->SanPham->Hinh;
            $thongbao->save();
            return redirect('admin/donhang/chitietdonhang/'.$id)->with('thanhcong','Xác Nhận Đơn Hàng Thành Công');
    }
    public function hoanthanh($id){
        $donhang = DonHang::find($id);
        $donhang->tinhtrangdonhang = 3;
        $donhang->giogiao = Carbon::now('Asia/Ho_Chi_Minh');
        $donhang->save();
        $thongbao = new ThongBao();
        $thongbao->tieude = "Đơn Hàng Đã Hoàn Thành";
        $thongbao->noidung = "<p>Đơn Hàng Có Mã Số:<b>".$donhang->id."</b> Đã Được Giao Đến.Vào Phần Đánh Giá Để Đánh Giá Sản Phẩm</p>";
        $thongbao->loaithongbao = 2;
        $thongbao->idkhachhang = $donhang->idkhachhang;
        $gio = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngayketthuc = $gio->addDay(7);
        $chitietdonhang = ChiTietDonHang::where('iddonhang',$donhang->id)->first();
        $thongbao->hinhanh = 'sanpham/'.$chitietdonhang->SanPham->Hinh;
        $thongbao->save();
        return redirect('admin/donhang/danglam')->with('thanhcong','Đã Hoàn Thành Đơn');
    }
    public function huydon($id){
        $donhang = DonHang::find($id);
        $donhang->tinhtrangdonhang = -1;
        $donhang->giogiao = CarBon::now("Asia/Ho_Chi_Minh");
        $donhang->save();
        $thongbao = new ThongBao();
        $thongbao->tieude = "Bạn Có Đơn Hàng Hủy";
        $thongbao->noidung ="<p>Đơn Hàng Có Mã Số:<b>".$donhang->id."</b> Đã Bị Hủy. Liên Hệ Chúng Tôi Để Biết Thêm Thông Tin</p>";
        $thongbao->loaithongbao = 2;
        $thongbao->idkhachhang = $donhang->idkhachhang;
        $gio = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngayketthuc = $gio->addDay(7);
        $chitietdonhang = ChiTietDonHang::where('iddonhang',$donhang->id)->first();
        $thongbao->hinhanh = 'sanpham/'.$chitietdonhang->SanPham->Hinh;
        $thongbao->save();
        return redirect('admin/donhang/danglam')->with('thanhcong','Đơn Đã Bị Hủy');

    }
}
