<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    public function danhsach(){
        $slide = Slide::all();
        return view('admin.pages.slide.danhsach',['slide'=>$slide]);
    }
    public function them(){
        return view('admin.pages.slide.them');
    }
    public function postthem(Request $request){
        $this->validate($request,[
            'anh'=>'required|mimes:png,jpg,jpeg,gif'
        ],[
            'anh.required'=>'Vui Lòng Chọn Ảnh',
            'anh.mimes'=>'Hình Ảnh Không Phù Hợp',
        ]);
        $gio = Carbon::now('Asia/Ho_Chi_Minh');
        $gio = str_replace(':','_',$gio);
        $gio = str_replace('-','_',$gio);
        $gio = str_replace(' ','_',$gio);
        $anh = $request->file('anh');
        $tenanh = $gio.Str::random(6).'.'.$anh->getClientOriginalExtension();
        $slide = new Slide();
        $anh->move('upload/slide',$tenanh);
        $slide->anh = $tenanh;
        $slide->save();
        return redirect('admin/slide/them')->with('thanhcong','Thêm Slide Thành Công');
    }
    public function sua($id)
    {
        $slide = Slide::find($id);
        return view('admin.pages.slide.sua',['slide'=>$slide]);
    }
    public function postsua(Request $request,$id)
    {
        $slide = Slide::find($id);
        if($request->hasFile('anh')){
            $this->validate($request,[
                'anh'=>'mimes:png,jpg,jpeg,gif'
            ],[
                'anh.mimes'=>'Hình Ảnh Không Phù Hợp',
            ]);
            
            $gio = Carbon::now('Asia/Ho_Chi_Minh');
            $gio = str_replace(':','_',$gio);
            $gio = str_replace('-','_',$gio);
            $gio = str_replace(' ','_',$gio);
            $anh = $request->file('anh');
            $tenanh = $gio.Str::random(6).'.'.$anh->getClientOriginalExtension();
            $anh->move('upload/slide',$tenanh);
            unlink('upload/slide/'.$slide->anh);
            $slide->anh = $tenanh;
            $slide->save();
            return redirect('admin/slide/sua/'.$id)->with('thanhcong','Sửa Slide Thành Công');
        }
        else{
            return redirect('admin/slide/sua/'.$id);

        }
    }
    public function xoa($id){
        $slide = Slide::find($id);
        if(isset($slide)){
            unlink('upload/slide/'.$slide->anh);
            $slide->delete();
            return redirect('admin/slide/danhsach')->with('thanhcong','Xóa Slide Thành Công');
        }
        else{
            return redirect('admin/slide/danhsach')->with('thatbai','Slide Đã Bị Xóa');
        }
    }    
}
