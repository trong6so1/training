<?php

namespace App\Http\Controllers;

use App\Models\KhuyenMai;
use App\Models\ThongBao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KhuyenMaiController extends Controller
{
    public function danhsach(){
        $khuyenmai = KhuyenMai::all();
       return view('admin.pages.khuyenmai.danhsach',['khuyenmai'=>$khuyenmai]);
    }
    public function them(){
        return view('admin.pages.khuyenmai.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'noidung'=>'required',
            'makhuyenmai'=>'required|unique:khuyenmai,makhuyenmai',
            'soluong'=>'required|min:1',
            'loaikhuyenmai'=>'required',
            'giatri'=>'required|min:1',
            'ngaybatdau'=>'required',
            'ngayketthuc'=>'required|after:ngaybatdau',
        ],[
            'noidung.required'=>'Nội dung khuyến mãi không được bỏ trống',
            'makhuyenmai.required'=>'Mã khuyến mãi không được bỏ trống',
            'makhuyenmai.unique'=>'Mã khuyến mãi đã tồn tại',
            'soluong.required'=>'Vui lòng nhập số luọng',
            'soluong.min'=>'Số lượng phải lớn hơn hoặc bằng 1',
            'loaikhuyenmai.required'=>'Vui lòng chọn hình thức khuyến mãi',
            'giatri.required'=>'Vui lòng nhập số tiền khuyến mãi',
            'giatri.min'=>'Số tiền khuyến mãi phải là số dương',
            'ngaybatdau.required'=>'Vui lòng nhập ngày bắt đầu',
            'ngayketthuc.required'=>'Vui lòng nhập ngày kết thúc',
            'ngayketthuc.after'=>'Ngày kết thúc phải sau ngày bắt đầu'
        ]);
        $khuyenmai = new KhuyenMai();
        $khuyenmai->noidung = $request->noidung;
        $khuyenmai->makhuyenmai = $request->makhuyenmai;
        $khuyenmai->soluong = $request->soluong;
        $khuyenmai->loaikhuyenmai = $request->loaikhuyenmai;
        $khuyenmai->sotien = $request->giatri;
        $khuyenmai->nguoisudung = "";
        $khuyenmai->ngaybatdau = $request->ngaybatdau;
        $khuyenmai->ngayketthuc = $request->ngayketthuc;
        $khuyenmai->save();
        $thongbao = new ThongBao();
        $thongbao->tieude = "Mã Giảm Giá Mới:".$khuyenmai->makhuyenmai;
        $thongbao->noidung = "<p>".$khuyenmai->noidung."</p>";
        $thongbao->loaithongbao = 3;
        $thongbao->idkhachhang = null;
        $gio = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
        $thongbao->ngayketthuc = $gio->addDay(7);
        $thongbao->hinhanh = "khuyenmai.png";
        $thongbao->save();
        return redirect('admin/khuyenmai/them')->with('thanhcong','Thêm mã khuyến mãi thành công');
    }
    public function xoa($id){
        $khuyenmai = KhuyenMai::find($id);
        if($khuyenmai){
            $khuyenmai->delete();
            return redirect('admin/khuyenmai/danhsach')->with('thanhcong','Xóa Mã Thành Công');
        }
        else{
            return redirect('admin/khuyenmai/danhsach')->with('thatbai','Mã Khuyến Mãi Bạn Cần Xóa Không Tồn Tại Hoặc Đã Bị Xóa');
        }
    }
}
