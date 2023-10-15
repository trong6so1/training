<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use Illuminate\Http\Request;

class DiaChiConTroller extends Controller
{
    public function danhsach(){
        $diachi = DiaChi::all();
        return view('admin.pages.diachi.danhsach',['diachi'=>$diachi]);
    }
    public function them(){
        return view('admin.pages.diachi.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'tenphuong'=>'required|unique:ship,tenphuong',
            'gia'=>'required|min:0',
        ],[
            'tenphuong.required'=>'Vui Lòng Nhập Tên Phường',
            'tenphuong.unique'=>'Tên Phường Đã Tồn Tại',
            'gia.required'=>'Vui Lòng Nhập Giá',
            'gia.min'=>'Giá Ship Không Hợp Lệ',
        ]);
        $diachi = new DiaChi();
        $diachi->tenphuong = $request->tenphuong;
        $diachi->gia = $request->gia;
        $diachi->save();
        return redirect('admin/diachi/them')->with('thanhcong','Thêm Địa Chỉ Thành Công');
    }
    public function xoa($id){
        $diachi = DiaChi::find($id);
        if($diachi){
            $diachi->delete();
            return redirect('admin/diachi/danhsach')->with('thanhcong','Xóa Địa Chỉ Thành Công');
        }
        else{
            return redirect('admin/diachi/danhsach')->with('thatbai','Địa Chỉ Không Tồn Tại Hoặc Đã Bị Xóa');
        }
    }
    public function sua($id){
        $diachi = DiaChi::find($id);
        return view('admin.pages.diachi.sua',['diachi'=>$diachi]);
    }
    public function postsua(Request $request,$id){
        $diachi = DiaChi::find($id);
        if($request->tenphuong == $diachi->tenphuong && $request->gia == $diachi->gia){
            return redirect('admin/diachi/sua/'.$id);
        }
        else{
            if($request->tenphuong != $diachi->tenphuong){
                $this->validate($request,[
                    'tenphuong'=>'required|unique:ship,tenphuong',
                ],[
                    'tenphuong.required'=>'Vui Lòng Nhập Tên Phường',
                    'tenphuong.unique'=>'Tên Phường Đã Tồn Tại',
                ]);
            }
            $this->validate($request,[
                'gia'=>'required|min:0',
            ],[
                'gia.required'=>'Vui Lòng Nhập Giá',
                'gia.min'=>'Giá Ship Không Hợp Lệ',
            ]);
            $diachi->tenphuong = $request->tenphuong;
            $diachi->gia = $request->gia;
            $diachi->save();
            return redirect('admin/diachi/sua/'.$id)->with('thanhcong','Sửa Địa Chỉ Thành Công');
            
        }
    }

}
