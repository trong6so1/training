<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThuongHieu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ThuongHieuController extends Controller
{
    public function danhsach(){
        $thuonghieu = DB::table('thuonghieu')->get();
        return view('admin.pages.thuonghieu.danhsach',['thuonghieu'=>$thuonghieu]);
    }
    public function suahienthi($id){
        $thuonghieu = ThuongHieu::find($id);
        $thuonghieu->Hien = !($thuonghieu->Hien);
        $thuonghieu->save();
        return redirect('admin/thuonghieu/danhsach')->with('thanhcong','Sửa hiển thị thành công');
    }
    public function xoa($id){
        DB::table('thuonghieu')->where('id',$id)->delete();
        return redirect('admin/thuonghieu/danhsach')->with('thanhcong','Xóa Thành Công');
    }
    public function them(){
        return view('admin.pages.thuonghieu.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'TenThuongHieu'=>'required',
            'MoTa'=>'required',
            'Hien'=>'required'
        ],[
            'TenThuongHieu.required'=>'Vui Lòng Nhập Tên',
            'MoTa.required'=>'Vui lòng Nhập Mô Tả',
            'Hien.required'=>'Trạng Thái không được để trống',
        ]);
        $data = array();
        $data['TenThuongHieu'] = $request->TenThuongHieu;
        $data['MoTa'] = $request->MoTa;
        $data['Hien'] = $request->Hien;
        $data['created_at'] = Carbon::now();
        DB::table('thuonghieu')->insert($data);
        return redirect('admin/thuonghieu/them')->with('thanhcong','Thêm Thành Công');
    }
    public function chinhsua($id){
        $thuonghieu = ThuongHieu::find($id);
        return view('admin.pages.thuonghieu.chinhsua',['thuonghieu'=>$thuonghieu]);
    }
    public function postchinhsua(Request $request,$id){
        $this->validate($request,[
            'TenThuongHieu'=>'required',
            'MoTa'=>'required',
            'Hien'=>'required'
        ],[
            'TenThuongHieu.required'=>'Vui Lòng Nhập Tên',
            'MoTa.required'=>'Vui lòng Nhập Mô Tả',
            'Hien.required'=>'Trạng Thái không được để trống',
        ]);
        $data = array();
        $data['TenThuongHieu'] = $request->TenThuongHieu;
        $data['MoTa'] = $request->MoTa;
        $data['Hien'] = $request->Hien;
        $create = Carbon::now('Asia/Ho_Chi_Minh');
        $data['created_at'] = $create;
        DB::table('thuonghieu')->where('id',$id)->update($data);
        return redirect('admin/thuonghieu/chinhsua/'.$id)->with('thanhcong','Sửa Thành Công');
    }
}
