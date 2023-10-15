<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\GiamGiaSanPham;
use App\Models\SanPham;
use App\Models\Slide;
use App\Models\ThuongHieu;
use App\Models\TraLoiDanhGia;
use CKSource\CKFinder\Command\MoveFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SanPhamController extends Controller
{
    
    public function danhsach(){
        $sanpham = SanPham::all();
        return view('admin.pages.sanpham.danhsach',['sanpham'=>$sanpham]);
    }
    public function suatrangthai($id){
        $sanpham = SanPham::find($id);
        $sanpham->TrangThai = !($sanpham->TrangThai);
        $giamgiasanpham = GiamGiaSanPham::where('masanpham',$id)->get();
        if($giamgiasanpham){
            foreach($giamgiasanpham as $gg){
                if($sanpham->TrangThai == 0){
                    $gg->hienthi = 0;
                    $gg->save();
                }
                else{
                    $gg->hienthi = 1;
                    $gg->save();
                }
            }
        }
        $sanpham->save();
        return redirect('admin/sanpham/danhsach')->with('thanhcong','Sửa Trạng Thái Thành công');
    }
    public function them(){
        $danhmuc = DanhMuc::all();
        return view('admin.pages.sanpham.them',['danhmuc'=>$danhmuc]);
    }
    public function chinhsua($id){
        $danhmuc = DanhMuc::all();
        $sanpham = SanPham::find($id);
        return view('admin.pages.sanpham.chinhsua',['danhmuc'=>$danhmuc,'sanpham'=>$sanpham]);
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'TenSanPham'=>'required',
            'MoTa'=>'required',
            'Hinh'=>'required|mimes:png,jpg,jpeg,webp',
            'Gia'=>'required',
            'TrangThai'=>'required',
        ],[
            'TenSanPham.required'=>'Vui Lòng Nhập Tên Sản Phẩm',
            'MoTa.required'=>'Vui Lòng Nhập Mô Tả',
            'Hinh.required'=>'Vui Lòng Nhập Hình Ảnh',
            'Gia.required'=>'Vui Lòng Nhập Giá',
            'TrangThai.required'=>'Vui Lòng Chọn Trạng Thái',
            'Hinh.mines'=>'Vui Lòng Chọn Hình Ảnh',
        ]);
        $name = $request->file('Hinh');
        $Hinh = Carbon::now().$name->getClientOriginalName();
        $Hinh = str_replace('-','_',$Hinh);
        $Hinh = str_replace(':','_',$Hinh);
        $name->move('upload/sanpham',$Hinh);
        $sanpham = new SanPham();
        $sanpham->TenSanPham = $request->TenSanPham;
        $sanpham->MoTa = $request->MoTa;
        $sanpham->Gia = $request->Gia;
        $sanpham->TrangThai=$request->TrangThai;
        $sanpham->idDanhMuc = $request->idDanhMuc;
        $sanpham->Hinh = $Hinh;
        $sanpham->TuKhoa = $sanpham->TenSanPham;
        $sanpham->save();
        return redirect('admin/sanpham/them')->with('thanhcong','Thêm sản phẩm thành công');
    }

    public function postchinhsua($id,Request $request){
        $this->validate($request,[
            'TenSanPham'=>'required',
            'MoTa'=>'required',
            'Hinh'=>'mimes:png,jpg,jpeg,webp',
            'Gia'=>'required',
        ],[
            'TenSanPham.required'=>'Vui Lòng Nhập Tên Sản Phẩm',
            'MoTa.required'=>'Vui Lòng Nhập Mô Tả',
            'Gia.required'=>'Vui Lòng Nhập Giá',
            'Hinh.mines'=>'Vui Lòng Chọn Hình Ảnh',
        ]);
        $sanpham = SanPham::find($id);
        if($request->has('Hinh')){
            $name = $request->file('Hinh');
            $Hinh = Carbon::now().$name->getClientOriginalName();
            $Hinh = str_replace('-','_',$Hinh);
            $Hinh = str_replace(':','_',$Hinh);
            $name->move('upload/sanpham',$Hinh);
            unlink('upload/sanpham/'.$sanpham->Hinh);
            $sanpham->Hinh = $Hinh;
        }
        
        
        $sanpham->TenSanPham = $request->TenSanPham;
        $sanpham->MoTa = $request->MoTa;
        $sanpham->Gia = $request->Gia;
        $sanpham->TrangThai=$request->TrangThai;
        $sanpham->idDanhMuc = $request->idDanhMuc;
        $sanpham->save();
        return redirect('admin/sanpham/chinhsua/'.$id)->with('thanhcong','Sửa Thành Công');
    }
    public function xoa($id){
        $sanpham = SanPham::find($id);
        File::copy("upload/sanpham/".$sanpham->Hinh,"upload/daxoa/sanpham/".$sanpham->Hinh);
        $giamgia = GiamGiaSanPham::where('masanpham',$id)->get();
        foreach($giamgia as $gg){
            $gg->delete();
        }
        $chitietdonhang = ChiTietDonHang::where('idsanpham',$id)->get();
        foreach($chitietdonhang as $ct){
            $ct->idsanpham = 0;
            $ct->hinhxoa = $sanpham->TenSanPham.'/'.$sanpham->Hinh;
            $ct->save();
            $danhgia = DanhGia::where('masanpham',$ct->id)->first();
            if($danhgia){
                $traloidanhgia = TraLoiDanhGia::where('madanhgia',$danhgia->id)->first();
                if($traloidanhgia){
                    $traloidanhgia->delete();
                }
                $danhgia->delete();
            }
        }
        
        $sanpham->delete();
        return redirect('admin/sanpham/danhsach')->with('thanhcong','Xóa Sản Phẩm Thành Công');
    }
    public function xemdanhgia(){
        $danhgia = DanhGia::all();
        return view('admin.pages.danhgia.danhsach',['danhgia'=>$danhgia]);
    }
}
