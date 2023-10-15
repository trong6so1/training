<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\GiamGiaSanPham;
use App\Models\SanPham;
use App\Models\ThongBao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GiamGiaSanPhamController extends Controller
{
    public function them(){
        $danhmuc = DanhMuc::all();
        $danhmucdau = DanhMuc::first();
        $sanpham = SanPham::where('idDanhMuc',$danhmucdau->id)->get();
        return view('admin.pages.giamgiasanpham.them',['sanpham'=>$sanpham,'danhmuc'=>$danhmuc,'danhmucdau'=>$danhmucdau->id]);
    }        
    public function postthem(Request $request){
        $this->validate($request,[
            'masanpham'=>'required',
            'giakhuyenmai'=>'required',
            'soluong'=>'required|min:1',
            'hienthi'=>'required',
            'tieude'=>'required',
            'noidung'=>'required',
            'ngaybatdau'=>'required',
            'ngayketthuc'=>'required|after:ngaybatdau',
        ],[
            'masanpham.required'=>'Vui Lòng Chọn Sản Phẩm',
            'giakhuyenmai.required'=>'Vui Lòng Nhập Giá Khuyến Mãi',
            'soluong.required'=>'Số Lượng Không Được Bỏ Trống',
            'soluong.min'=>'Số Lượng Phải Lớn Hơn 0',
            'hienthi.required'=>'Vui Lòng Chọn Hình Thức Hiển Thị',
            'tieude.required'=>'Vui Lòng Nhập Tiêu Đề Khuyến Mãi',
            'noidung.required'=>'Vui Lòng Nhập Nội Dung Khuyến Mãi',
            'ngaybatdau.required'=>'Vui Lòng Nhập Ngày Bắt Đầu Khuyến Mãi',
            'ngayketthuc.required'=>'Vui Lòng Nhập Ngày Kết Thúc Khuyến Mãi',
            'ngayketthuc.after'=>'Ngày Kết Thúc Không Hợp Lệ',
        ]);
        if($request->giakhuyenmai > $request->giagoc){
            return redirect('admin/giamgiasanpham/them')->with('thatbai','Giá Khuyến Mãi Không Được Lớn Hơn Giá Gốc');
        }
        $giamgiasanpham = new GiamGiaSanPham();
        $giamgiasanpham->masanpham = $request->masanpham;
        $giamgiasanpham->giakhuyenmai = $request->giakhuyenmai;
        $giamgiasanpham->soluong = $request->soluong;
        $giamgiasanpham->hienthi = $request->hienthi;
        $giamgiasanpham->tieude = $request->tieude;
        $giamgiasanpham->noidung = $request->noidung;
        $giamgiasanpham->ngaybatdau = $request->ngaybatdau;
        $giamgiasanpham->ngayketthuc = $request->ngayketthuc;
        $giamgiasanpham->save();
        $thongbao = new ThongBao();
        $sanpham = SanPham::find($request->masanpham);
        $thongbao->tieude = $giamgiasanpham->tieude;
        $thongbao->noidung = $giamgiasanpham->noidung;
        $thongbao->loaithongbao = 1;
        $thongbao->hinhanh = "sanpham/".$sanpham->Hinh;
        $thongbao->ngaydang =Carbon::now('Asia/Ho_Chi_Minh');
        $thongbao->ngayketthuc = $request->ngayketthuc;
        $thongbao->save();
        return redirect('admin/giamgiasanpham/them')->with('thanhcong','Thêm Sản Phẩm Giảm Giá Thành Công');
    }
    public function  timgiasanpham($id){
        $sanpham = SanPham::find($id);
        return $sanpham->Gia;
    }
    public function timsanpham($id){
        $sanpham = SanPham::where('idDanhMuc',$id)->get();
        return $sanpham;
    }
    public function danhsach(){
        $giamgiasanpham  = GiamGiaSanPham::all();
        return view('admin.pages.giamgiasanpham.danhsach',['giamgiasanpham'=>$giamgiasanpham]);
    }
    public function suahienthi($id){
        $giamgiasanpham = GiamGiaSanPham::find($id);
        $giamgiasanpham->hienthi = !$giamgiasanpham->hienthi;
        $giamgiasanpham->save();
        return redirect('admin/giamgiasanpham/danhsach')->with('thanhcong','Sửa Trạng Thái Thành Công');
    }
    public function xoa($id){
        $giamgiasanpham = GiamGiaSanPham::find($id);
        $giamgiasanpham->delete();
        return redirect('admin/giamgiasanpham/danhsach')->with('thanhcong','Xóa Sản Phẩm Thành Công');
    }
}
