<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use App\Models\TheLoaiBaiViet;
use Illuminate\Http\Request;

class TheLoaiBaiVietController extends Controller
{
    public function danhsach(){
        $theloai = TheLoaiBaiViet::all();
        return view('admin.pages.theloaibaiviet.danhsach',['theloai'=>$theloai]);
    }
    public function them(){
        return view('admin.pages.theloaibaiviet.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'tentheloai'=>'required|unique:theloaibaiviet,tentheloai',
        ],[
            'tentheloai.required'=>'Tên Thể Loại Không Được Bỏ Trống',
            'tentheloai.unique'=>'Thể Loại Này Đã Tồn Tại',
        ]);
        $theloai= new TheLoaiBaiViet();
        $theloai->tentheloai = $request->tentheloai;
        $theloai->save();
        return redirect('admin/theloaibaiviet/them')->with('thanhcong','Thêm Thể Loại Mới Thành Công');
    }
    public function sua($id){
        $theloai = TheLoaiBaiViet::find($id);
        return view('admin.pages.theloaibaiviet.sua',['theloai'=>$theloai]);
    }
    public function postsua(Request $request,$id){
        $theloai = TheLoaiBaiViet::find($id);
        if($theloai->tentheloai == $request->tentheloai){
            return redirect('admin/theloaibaiviet/sua/'.$id);
        }
        else{
            $this->validate($request,[
                'tentheloai'=>'required|unique:theloaibaiviet,tentheloai',
            ],[
                'tentheloai.required'=>'Tên Thể Loại Không Được Bỏ Trống',
                'tentheloai.unique'=>'Thể Loại Này Đã Tồn Tại',
            ]);
            $theloai= new TheLoaiBaiViet();
            $theloai->tentheloai = $request->tentheloai;
            $theloai->save();
            return redirect('admin/theloaibaiviet/sua/'.$id)->with('thanhcong','Sửa Thể Loại Thành Công');
        }
    }
    public function xoa($id){
        $theloai = TheLoaiBaiViet::find($id);
        if(isset($theloai)){
            $baiviet = BaiViet::where('matheloai',$id)->get();
            if($baiviet){
                foreach($baiviet  as $bv){
                    $bv->delete();
                }
            }
            $theloai->delete();
            return redirect('admin/theloaibaiviet/danhsach')->with('thanhcong','Xóa Thể Loại Thành Công');
        }
        else{
            return redirect('admin/theloaibaiviet/danhsach')->with('thatbai','Thể Loại Không Tồn Tại Hoặc Đã Bị Xóa');
        }
    }
}
