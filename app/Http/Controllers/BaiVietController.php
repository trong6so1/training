<?php

namespace App\Http\Controllers;

use App\Models\BaiViet;
use App\Models\ChuongTrinhKhachHang;
use App\Models\TheLoaiBaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class BaiVietController extends Controller
{
    public function danhsach(){
        $baiviet = BaiViet::all();
        return view('admin.pages.baiviet.danhsach',['baiviet'=>$baiviet]);
    }
    public function suahienthi($id){
        $baiviet = BaiViet::find($id);
        if($baiviet->hienthi == 0){
            $baiviet->hienthi = 1;
            $baiviet->save();
        }
        else{
            $baiviet->hienthi = 0;
            $baiviet->save();
        }
        return redirect('admin/baiviet/danhsach')->with('thanhcong','Sửa Trạng Thái Thành Công');
    }
    public function them(){
        $theloai = TheLoaiBaiViet::all();
        return view('admin.pages.baiviet.them',['theloai'=>$theloai]);
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'tenbaiviet'=>'required|min:3',
            'anhbaiviet'=>'required|mimes:png,jpg,jpeg,gif',
            'tomtat'=>'required|min:10',
            'noidung'=>'required|min:30',
            'matheloai'=>'required',
            'hienthi'=>'required',
        ],[
            'tenbaiviet.required'=>'Tên Bài Viết Không Được Bỏ Trống',
            'tenbaiviet.min'=>'Tên Bài Viết Không Hợp lệ',
            'anhbaiviet.required'=>'Ảnh Bài Viết Không Dược Bỏ Trống',
            'anhbaiviet.mimes'=>'Ảnh Không Hợp Lệ',
            'tomtat.required'=>'Vui Lòng Nhập Tóm Tắt',
            'tomtat.min'=>'Tóm Tắt Quá Ngắn Vui Lòng Nhập Chi Tiết Hơn',
            'noidung.required'=>'Nội Dung Không Được Bỏ Trống',
            'noidung.min'=>'Vui Lòng Nhập Chi Tiết Nội Dung',
            'matheloai.required'=>'Vui Lòng Chọn Thể Loại',
            'hienthi.required'=>'Vui Lòng Chọn Trạng Thái Bài Viết',
            
        ]);
        $hientai = Carbon::now('Asia/Ho_Chi_Minh');
        $ngayhientai = str_replace(':','_',$hientai);
        $ngayhientai = str_replace('-','_',$ngayhientai);
        $ngayhientai = str_replace(' ','_',$ngayhientai);
        $anhbaiviet = $request->file('anhbaiviet');
        $tenanh = $ngayhientai.Str::random(6).'.'.$anhbaiviet->getClientOriginalExtension();
        $anhbaiviet->move('upload/anhbaiviet',$tenanh);
        $baiviet = new BaiViet();
        $baiviet->tenbaiviet = $request->tenbaiviet;
        $baiviet->anhbaiviet = $tenanh;
        $baiviet->tomtat = $request->tomtat;
        $baiviet->noidung = $request->noidung;
        $baiviet->matheloai = $request->matheloai;
        $baiviet->hienthi = $request->hienthi;
        $baiviet->ngaydang = $hientai;
        $baiviet->save();
        return redirect('admin/baiviet/them')->with('thanhcong','Thêm Bài Viết Thành Công');
    }
    public function sua($id){
        $baiviet = BaiViet::find($id);
        $theloai = TheLoaiBaiViet::all();
        return view('admin.pages.baiviet.sua',['baiviet'=>$baiviet,'theloai'=>$theloai]);
    }
    public function postsua(Request $request,$id){
        $baiviet = BaiViet::find($id);
        if($request->tenbaiviet == $baiviet->tenbaiviet && !$request->hasFile('anhbaiviet')
            && $request->tomtat == $baiviet->tomtat && $request->noidung == $baiviet->noidung
            && $request->hienthi == $baiviet->hienthi && $request->matheloai == $baiviet->matheloai
        ){
            return redirect('admin/baiviet/sua/'.$id);
        }
        else{
            $this->validate($request,[
                'tenbaiviet'=>'required|min:3',
                'anhbaiviet'=>'mimes:png,jpg,jpeg,gif',
                'tomtat'=>'required|min:10',
                'noidung'=>'required|min:30',
                'matheloai'=>'required',
                'hienthi'=>'required',
            ],[
                'tenbaiviet.required'=>'Tên Bài Viết Không Được Bỏ Trống',
                'tenbaiviet.min'=>'Tên Bài Viết Không Hợp lệ',
                'anhbaiviet.mimes'=>'Ảnh Không Hợp Lệ',
                'tomtat.required'=>'Vui Lòng Nhập Tóm Tắt',
                'tomtat.min'=>'Tóm Tắt Quá Ngắn Vui Lòng Nhập Chi Tiết Hơn',
                'noidung.required'=>'Nội Dung Không Được Bỏ Trống',
                'noidung.min'=>'Vui Lòng Nhập Chi Tiết Nội Dung',
                'matheloai.required'=>'Vui Lòng Chọn Thể Loại',
                'hienthi.required'=>'Vui Lòng Chọn Trạng Thái Bài Viết',
            ]);
            $hientai = Carbon::now('Asia/Ho_Chi_Minh');
            if($request->hasFile('anhbaiviet')){
                $ngayhientai = str_replace(':','_',$hientai);
                $ngayhientai = str_replace('-','_',$ngayhientai);
                $ngayhientai = str_replace(' ','_',$ngayhientai);
                $anhbaiviet = $request->file('anhbaiviet');
                $tenanh = $ngayhientai.Str::random(6).'.'.$anhbaiviet->getClientOriginalExtension();
                unlink('upload/anhbaiviet/'.$baiviet->anhbaiviet);
                $anhbaiviet->move('upload/anhbaiviet',$tenanh);
                $baiviet->anhbaiviet = $tenanh;
            }
            $baiviet->tenbaiviet = $request->tenbaiviet;
            $baiviet->tomtat = $request->tomtat;
            $baiviet->noidung = $request->noidung;
            $baiviet->matheloai = $request->matheloai;
            $baiviet->hienthi = $request->hienthi;
            $baiviet->ngaydang = $hientai;
            $baiviet->save();
            return redirect('admin/baiviet/sua/'.$id)->with('thanhcong','Sửa Bài Viết Thành Công');
        }
    }
    public function xoa($id){
        $baiviet = BaiViet::find($id);
        if(isset($baiviet)){
            unlink('upload/anhbaiviet/'.$baiviet->anhbaiviet);
            $baiviet->delete();
            return redirect('admin/baiviet/danhsach')->with('thanhcong','Thêm Bài Viết Thành Công');
        }
        else{
            return redirect('admin/baiviet/danhsach')->with('thatbai','Bài Viết Không Tồn Tại Hoặc Đã Bị Xóa');
        }
    }
}
