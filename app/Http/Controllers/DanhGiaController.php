<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\ThongBao;
use App\Models\TraLoiDanhGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;

class DanhGiaController extends Controller
{
    public function traloidanhgia($id){
        $danhgia = DanhGia::find($id);
        return view('admin.pages.danhgia.traloi',['danhgia'=>$danhgia]);
    }
    public function sua($id){
        $danhgia = DanhGia::find($id);
        $traloi = TraLoiDanhGia::where('madanhgia',$id)->first();
        return view('admin.pages.danhgia.sua',['danhgia'=>$danhgia,'traloi'=>$traloi]);
    }
    public  function posttraloidanhgia(Request $request,$id){
        $this->validate($request,[
            'noidung'=>'required',
        ],[
            'noidung.required'=>'Vui Lòng Nhập Nội Dung Trả Lời'
        ]);
        $gio = Carbon::now("Asia/Ho_Chi_Minh");
        $traloidanhgia = new TraLoiDanhGia();
        $traloidanhgia->madanhgia = $id;
        $traloidanhgia->noidung = $request->noidung;
        $traloidanhgia->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
        $traloidanhgia->nguoidang = session('admin')->id;
        $traloidanhgia->save();
        $danhgia = DanhGia::find($id);
        $thongbao = new ThongBao();
        $thongbao->tieude = "Shop Đồ Uống Đã Trả Lời Bình Luận Của Bạn";
        $thongbao->noidung = "Hãy Xem Câu Trả Lời Của Họ Và Cập Nhật Bài Đánh Giá Của Bạn";
        $thongbao->loaithongbao = 2;
        $thongbao->idkhachhang = $danhgia->nguoidang;
        $thongbao->hinhanh = 'sanpham/'.$danhgia->ChiTiet->SanPham->Hinh;
        $thongbao->ngaydang = $traloidanhgia->ngaydang;
        $thongbao->ngayketthuc =  $gio->addDay(7);
        $thongbao->save();
        return redirect('admin/danhgia/danhsach')->with('thanhcong','Trả Lời Đánh Giá Thành Công');

    }
    public function postsua($id,Request $request){
        $this->validate($request,[
            'noidung'=>'required',
        ],[
            'noidung.required'=>'Vui Lòng Nhập Nội Dung Trả Lời'
        ]);
        $traloidanhgia = TraLoiDanhGia::find($id);
        $traloidanhgia->noidung = $request->noidung;
        $traloidanhgia->ngaydang = Carbon::now("Asia/Ho_Chi_Minh");
        $traloidanhgia->nguoidang = session('admin')->id;
        $traloidanhgia->save();
        return redirect('admin/danhgia/sua/'.$id)->with('thanhcong','Sửa Trả Lời Đánh Giá Thành Công');
    }
    public function xoa($id){
        $traloi = TraLoiDanhGia::where('madanhgia',$id)->first();
        if($traloi){
            $traloi->delete();
            return redirect('admin/danhgia/danhsach')->with('thanhcong','Xóa Đơn Hàng Thành Công');
        }
    }
}
