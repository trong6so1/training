<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use App\Models\DichVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function danhsach(){
        $chucvu = ChucVu::all();
        return view('admin.pages.chucvu.danhsach',['chucvu'=>$chucvu]);
    }
    public function them(){
        return view('admin.pages.chucvu.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'tenchucvu'=>'required|min:3|unique:chucvu,chucvu.tenchucvu',
        ],[
            'tenchucvu.required'=>'Vui Lòng Nhập Tên Chức Vụ',
            'tenchucvu.unique'=>'Bộ Phận Này Đã Tồn Tại',
            'tenchucvu.min'=>'Tên Chức Vụ Quá Ngắn Vui Lòng Nhập Chi Tiết Hơn',
        ]);
        if(!empty($request->motachucvu)){
            $this->validate($request,[
                'motachucvu'=>'min:3',
            ],[
                'motachucvu.min'=>'Vui Lòng Mô Tả Chi Tiết Hơn',
            ]);
        }
        $chucvu = new ChucVu();
        $chucvu->tenchucvu = $request->tenchucvu;
        $chucvu->motachucvu = $request->motachucvu;
        $chucvu->save();
        return redirect('admin/chucvu/them')->with('thanhcong','Thêm Chức Vụ Mới Thành Công');
    }
    public function xoa($id){
        $chucvu = ChucVu::find($id);
        if(!empty($chucvu)){
            $chucvu->delete();
            return redirect('admin/chucvu/danhsach')->with('thanhcong','Xóa Chức Vụ Thành Công');
        }
        else{
            return redirect('admin/chucvu/danhsach')->with('thatbai','Đã Xóa Chức Vụ Này Rồi');
        }
    }
    public function sua($id){
        $chucvu = ChucVu::find($id);
        return view('admin.pages.chucvu.sua',['chucvu'=>$chucvu]);
    }
    public function postsua(Request $request,$id){
        $chucvu = ChucVu::find($id);
            if($request->tenchucvu == $chucvu->tenchucvu  && $request->motachucvu == $chucvu->motachucvu){
                return redirect('admin/chucvu/sua/'.$id);
            }
            else{
                if($request->tenchucvu != $chucvu->tenchucvu){
                $this->validate($request,[
                    'tenchucvu'=>'required|min:3|unique:chucvu,chucvu.tenchucvu',
                ],[
                    'tenchucvu.required'=>'Vui Lòng Nhập Tên Chức Vụ',
                    'tenchucvu.unique'=>'Bộ Phận Này Đã Tồn Tại',
                    'tenchucvu.min'=>'Tên Chức Vụ Quá Ngắn Vui Lòng Nhập Chi Tiết Hơn',
                ]);
                }
                if(!empty($request->motachucvu)){
                    $this->validate($request,[
                        'motachucvu'=>'min:3',
                    ],[
                        'motachucvu.min'=>'Vui Lòng Mô Tả Chi Tiết Hơn',
                    ]);
                }
                $chucvu->tenchucvu = $request->tenchucvu;
                $chucvu->motachucvu = $request->motachucvu;
                $chucvu->save();
                return redirect('admin/chucvu/sua/'.$id)->with('thanhcong','Sửa Chức Vụ Thành Công');
            }     
    }
    
}
