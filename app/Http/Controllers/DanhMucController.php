<?php

namespace App\Http\Controllers;

use App\Models\ChiTietDonHang;
use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\GiamGiaSanPham;
use App\Models\SanPham;
use App\Models\TraLoiDanhGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DanhMucController extends Controller
{
    public function danhsach()
    {
        $danhmuc = DB::table('danhmuc')->get();
        return view('admin.pages.danhmuc.danhsach', ['danhmuc' => $danhmuc]);
    }
    public function suahienthi($id)
    {
        $danhmuc = DanhMuc::find($id);
        $danhmuc->Hien = !($danhmuc->Hien);
        $sanpham = SanPham::where('idDanhMuc', $id)->get();
        if ($sanpham) {
            foreach ($sanpham as $sp) {
                if ($danhmuc->Hien == 0) {
                    $sp->TrangThai = 0;
                    $sp->save();
                } else {
                    $sp->TrangThai = 1;
                    $sp->save();
                }
            }
        }
        $danhmuc->save();
        return redirect('admin/danhmuc/danhsach')->with('thanhcong', 'Sửa hiển thị thành công');
    }
    public function xoa($id)
    {
        $sanphamtheodanhmuc = SanPham::where('iddanhmuc', $id)->get();
        if ($sanphamtheodanhmuc) {
            foreach ($sanphamtheodanhmuc as $sanpham) {
                File::copy("upload/sanpham/" . $sanpham->Hinh, "upload/daxoa/sanpham/" . $sanpham->Hinh);
                $giamgia = GiamGiaSanPham::where('masanpham', $id)->get();
                foreach ($giamgia as $gg) {
                    $gg->delete();
                }
                $chitietdonhang = ChiTietDonHang::where('idsanpham', $id)->get();
                foreach ($chitietdonhang as $ct) {
                    $ct->idsanpham = 0;
                    $ct->hinhxoa = $sanpham->TenSanPham . '/' . $sanpham->Hinh;
                    $ct->save();
                    $danhgia = DanhGia::where('masanpham', $ct->id)->first();
                    if ($danhgia) {
                        $traloidanhgia = TraLoiDanhGia::where('madanhgia', $danhgia->id)->first();
                        if ($traloidanhgia) {
                            $traloidanhgia->delete();
                        }
                        $danhgia->delete();
                    }
                }
                $sanpham->delete();
            }
        }
        $danhmuc = DanhMuc::find($id);
        $danhmuc->delete();
        return redirect('admin/danhmuc/danhsach')->with('thanhcong', 'Xóa Thành Công');
    }
    public function them()
    {
        return view('admin.pages.danhmuc.them');
    }
    public function postthem(Request $request)
    {
        $this->validate($request, [
            'TenDanhMuc' => 'required',
            'Hien' => 'required'
        ], [
            'TenDanhMuc.required' => 'Vui Lòng Nhập Tên',
            'Hien.required' => 'Trạng Thái không được để trống',
        ]);
        $data = array();
        $data['TenDanhMuc'] = $request->TenDanhMuc;
        $data['Hien'] = $request->Hien;
        $data['created_at'] = Carbon::now();
        DB::table('danhmuc')->insert($data);
        return redirect('admin/danhmuc/them')->with('thanhcong', 'Thêm Thành Công');
    }
    public function chinhsua($id)
    {
        $danhmuc = DanhMuc::find($id);
        return view('admin.pages.danhmuc.chinhsua', ['danhmuc' => $danhmuc]);
    }
    public function postchinhsua(Request $request, $id)
    {
        $this->validate($request, [
            'TenDanhMuc' => 'required',
            'Hien' => 'required'
        ], [
            'TenDanhMuc.required' => 'Vui Lòng Nhập Tên',
            'Hien.required' => 'Trạng Thái không được để trống',
        ]);
        $data = array();
        $data['TenDanhMuc'] = $request->TenDanhMuc;
        $data['MoTa'] = $request->MoTa;
        $data['Hien'] = $request->Hien;
        $create = Carbon::now('Asia/Ho_Chi_Minh');
        $data['created_at'] = $create;
        DB::table('danhmuc')->where('id', $id)->update($data);
        return redirect('admin/danhmuc/chinhsua/' . $id)->with('thanhcong', 'Sửa Thành Công');
    }
}
