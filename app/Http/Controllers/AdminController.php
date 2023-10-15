<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ChiTietDonHang;
use App\Models\ChucVu;
use App\Models\DonHang;
use App\Models\ThongTinNguoiNhan;
use App\Models\TraLoiDanhGia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
    public function tongquan()
    {
        return view('admin.pages.tongquan');
    }
    public function postlogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Vui Lòng nhập email',
                'password.required' => 'Vui Lòng nhập mật khẩu',
            ]
        );
        $admin = DB::table('admin')->where('email', $request->email)->first();
        if ($admin) {
            if (password_verify($request->password, $admin->matkhau)) {
                Session::put('admin', $admin);
                return redirect('admin/tongquan');
            } else {
                return redirect('admin/login')->with('thatbai', 'Mật khẩu không đúng');
            }
        } else {
            return redirect('admin/login')->with('thatbai', 'Email không đúng');
        }
    }
    public function quenmatkhau()
    {
        return view('admin.quenmatkhau');
    }
    public function postquenmatkhau(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng'
            ]
        );
        $admin  = Admin::where('email', $request->email)->first();
        if ($admin) {
            $to_name = "Shop Đồ Uống";
            $to_email = $request->email;

            $mailData = array("id" => $admin->id, "tieude" => "Thông Báo Quên Mật Khẩu"); //body of mail.blade.php

            Mail::send('admin.pages.email.quenmatkhau', $mailData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Tin Tài Khoản'); //send this mail with subject
                $message->from($to_email, $to_name); //send from this mail
            });
            return view('admin.postquenmatkhau');
        } else {
            return redirect('admin/quenmatkhau')->with('thatbai', 'Email bạn nhập không đúng');
        }
    }
    public function datlaimatkhau($id)
    {
        return view('admin.datlaimatkhau', ['id' => $id]);
    }
    public function postdatlaimatkhau(Request $request, $id)
    {
        $this->validate($request, [
            'matkhau' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'
        ], [
            'matkhau.required' => 'Vui lòng nhập mật khẩu',
            'matkhau.regex' => 'Mật khẩu phải từ 8 kí tự,phải bao gồm: Chữ hoa,chữ thường,số và kí tự đặc biệt'
        ]);
        $admin = Admin::find($id);
        $admin->matkhau = password_hash($request->matkhau, null);
        $admin->save();
        return redirect('admin/login')->with('thanhcong', 'Đặt lại mật khẩu thành công');
    }
    public function doimatkhau($id)
    {
        return view('admin.doimatkhau', ['id' => $id]);
    }
    public function postdoimatkhau(Request $request, $id)
    {
        $this->validate($request, [
            'matkhaucu' => 'required',
            'matkhaumoi' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'nhaplaimatkhau' => 'same:matkhaumoi'
        ], [
            'matkhaucu.required' => 'Vui lòng nhập mật khẩu cũ',
            'matkhaumoi.required' => 'Vui lòng nhập mật khẩu mới',
            'matkhaumoi.regex' => 'Mật khẩu phải từ 8 kí tự,phải bao gồm: Chữ hoa,chữ thường,số và kí tự đặc biệt',
            'nhaplaimatkhau.same' => 'Nhập lại mật khẩu không đúng',
        ]);
        $admin = Admin::find($id);
        if (password_verify($request->matkhaucu, $admin->matkhau)) {
            $admin->matkhau = password_hash($request->matkhaumoi, null);
            $admin->save();
            return redirect('admin/tongquan')->with('thanhcong', "Đổi mật khẩu thành công");
        } else {
            return redirect('admin/doimatkhau/' . $id)->with('thatbai', 'Mật khẩu cũ không chính xác');
        }
    }
    public function dangxuat()
    {
        Session::forget('admin');
        return redirect('admin/login')->with('thanhcong', 'Đăng xuất thành công');
    }

    //Quản Lí Tài Khoản


    public function danhsach()
    {
        $nhanvien = Admin::all();
        return view('admin.pages.taikhoan.danhsach', ['nhanvien' => $nhanvien]);
    }
    public function them()
    {
        $chucvu = ChucVu::all();
        return view('admin.pages.taikhoan.them', ['chucvu' => $chucvu]);
    }
    public function sua($id){
        $admin = Admin::find($id);
        $chucvu = ChucVu::all();
        return view('admin.pages.taikhoan.sua',['admin'=>$admin,'chucvu'=>$chucvu]);
    }
    public function postsua($id,Request $request){
        $admin = Admin::find($id);
        $admin->machucvu = $request->machucvu;
        $admin->save();
        return redirect('admin/admin/danhsach')->with('thanhcong','Sửa Chức Vụ Thành Công');
    }
    public function postthem(Request $request)
    {
        $this->validate($request, [
            'hoten' => 'required|regex:/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùếúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẾẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i',
            'sodienthoai' => 'required|regex:/^[0-9]{10,14}$/',
            'email' => 'required|email|unique:admin,email',
            'anhdaidien' => 'mimes:jpg,jpeg,png,gif',
            'machucvu' => 'required',
        ], [
            'hoten.required' => 'Vui Lòng Nhập Họ Tên',
            'hoten.regex' => 'Họ Tên Không Được Nhập Số Và Kí Tự Đặc Biệt',
            'sodienthoai.required' => 'Vui Lòng Nhập Số Điện Thoại',
            'email.required' => 'Vui Lòng Nhập Email',
            'email.email' => 'Email Không Đúng Định Dạng',
            'email.unique' => 'Email Đã Tồn Tại',
            'anhdaidien.mimes' => 'File Hình Ảnh Không Đúng',
            'machucvu.required' => 'Vui Lòng Chọn Chức Vụ',
            'sodienthoai.regex' => 'Số Điện Thoại Không Đúng',
        ]);
        $admin = new Admin();
        $admin->hoten = $request->hoten;
        $admin->email = $request->email;
        $matkhau = fake()->regexify('/[A-Z]{2}[a-z]{2}[0-9]{2}[#?!@$%^&*-]{2}/');
        $admin->matkhau = password_hash($matkhau, null);
        $admin->machucvu = $request->machucvu;
        $admin->sodienthoai = $request->sodienthoai;
        if ($request->hasFile('anhdaidien')) {
            $anhdaidien = $request->file('anhdaidien');
            $gio = Carbon::now('Asia/Ho_Chi_Minh');
            $gio = str_replace(':', '_', $gio);
            $gio = str_replace('/', '_', $gio);
            $gio = str_replace(' ', '_', $gio);
            $hinh = $gio . Str::random(6) . '.' . $anhdaidien->getClientOriginalExtension();
            $anhdaidien->move('upload/anhadmin/', $hinh);
            $admin->anhdaidien = $hinh;
        }
        $admin->save();

        $to_name = "Shop Đồ Uống";
        $to_email = $admin->email;

        $mailData = array("email" => $admin->email, "matkhau" => $matkhau, "tieude" => "Gửi Thông Tin Tài Khoản"); //body of mail.blade.php

        Mail::send('admin.pages.email.guitaikhoan', $mailData, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Thông Tin Tài Khoản'); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });
        return redirect('admin/admin/them')->with('thanhcong', 'Thêm Nhân Viên Thành Công');
    }
    public function thongtin($id)
    {
        $nhanvien = Admin::find($id);
        $chucvu = ChucVu::all();
        return view('admin.pages.taikhoan.thongtin', ['chucvu' => $chucvu, 'nhanvien' => $nhanvien]);
    }
    public function postthongtin(Request $request, $id)
    {
        $nhanvien = Admin::find($id);
        if ($request->hoten == $nhanvien->hoten && $request->sodienthoai == $nhanvien->sodienthoai && (!$request->hasFile('anhdaidien') && !isset($nhanvien->anhdaidien))) {
            return redirect('admin/admin/thongtin/' . $id);
        } else {
            $this->validate($request, [
                'hoten' => 'required|regex:/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùếúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẾẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i',
                'sodienthoai' => 'required|regex:/^[0-9]{10,14}$/',
                'anhdaidien' => 'mimes:jpg,jpeg,png,gif',
            ], [
                'hoten.required' => 'Vui Lòng Nhập Họ Tên',
                'hoten.regex' => 'Họ Tên Không Được Nhập Số Và Kí Tự Đặc Biệt',
                'sodienthoai.required' => 'Vui Lòng Nhập Số Điện Thoại',
                'anhdaidien.mimes' => 'File Hình Ảnh Không Đúng',
                'sodienthoai.regex' => 'Số Điện Thoại Không Đúng',
            ]);
            if ($request->hasFile('anhdaidien')) {
                $anhdaidien = $request->file('anhdaidien');
                $gio = Carbon::now('Asia/Ho_Chi_Minh');
                $gio = str_replace(':', '_', $gio);
                $gio = str_replace('/', '_', $gio);
                $gio = str_replace(' ', '_', $gio);
                $hinh = $gio . Str::random(6) . '.' . $anhdaidien->getClientOriginalExtension();
                $anhdaidien->move('upload/anhadmin/', $hinh);
                if (isset($nhanvien->anhdaidien)) {
                    unlink('upload/anhadmin/' . $nhanvien->anhdaidien);
                }
                $nhanvien->anhdaidien = $hinh;
                if (session('admin')->id == $id) {
                    session('admin')->anhdaidien = $hinh;
                }
            } else {
                if (isset($nhanvien->anhdaidien)) {
                    unlink('upload/anhadmin/' . $nhanvien->anhdaidien);
                    $nhanvien->anhdaidien = null;
                    if (session('admin')->id == $id) {
                        session('admin')->anhdaidien = null;
                    }
                }
            }
            $nhanvien->hoten = $request->hoten;
            if (session('admin')->id == $id) {
                session('admin')->hoten = $nhanvien->hoten;
                session('admin')->anhdaidien = $nhanvien->anhdaidien;
            }
            $nhanvien->sodienthoai = $request->sodienthoai;
            $nhanvien->save();
            return redirect('admin/admin/thongtin/' . $id)->with('thanhcong', 'Sửa Thông Tin Thành Công');
        }
    }
    public function xoa($id)
    {
        $nhanvien = Admin::find($id);
        if (isset($nhanvien)) {
            if (isset($nhanvien->anhdaidien)) {
                unlink('upload/anhadmin/' . $nhanvien->anhdaidien);
            }
            $traloidanhgia = TraLoiDanhGia::where('nguoidang',$id)->get();
            if($traloidanhgia){
                foreach($traloidanhgia as $tl){
                    $tl->nguoidang = -1;
                    $tl->save();
                }
            }
            $nhanvien->delete();
            return redirect('admin/admin/danhsach')->with('thanhcong', 'Xóa Nhân Viên Thành Công');
        } else {
            return redirect('admin/admin/danhsach')->with('thatbai', 'Nhân Viên Không Tồn Tại Hoặc Đã Bị Xóa');
        }
    }
    public function thongke()
    {
        $homnay = CarBon::now("Asia/Ho_Chi_Minh");
        $thongkedouong = ChiTietDonHang::where('idsanpham','>',0)->select(DB::raw("sum(soluong * gia) as tongtien,idsanpham,count('idsanpham') as soluong"))
            ->whereExists(function ($query) {
                $ngay = CarBon::now("Asia/Ho_Chi_Minh");
                $query->select("donhang.id")->from("donhang")
                    ->whereDate('giogiao', $ngay)->where('tinhtrangdonhang',3)
                    ->whereRaw("donhang.id = chitietdonhang.iddonhang");
            })->orderBy('tongtien', 'DESC')->groupBy('idsanpham')->get();
        $thongkedoanhthu = DonHang::select(DB::raw("sum(tongtien) as tongtien,hinhthucthanhtoan,count(hinhthucthanhtoan) as soluong"))
            ->whereDate('giogiao', $homnay)->where('tinhtrangdonhang',3)->orderBy('tongtien', 'DESC')->groupBy('hinhthucthanhtoan')->get();
        return view('admin.thongke', ['thongkedouong' => $thongkedouong, 'thongkedoanhthu' => $thongkedoanhthu, 'sosanh' =>  array()]);
    }
    public function postthongke(Request $request)
    {
        if ($request->ngaydau == null && $request->ngaycuoi == null) {
            return redirect('admin/thongke')->with('thatbai', 'vui long chon ngày');
        } else {
            if ($request->ngaydau != null && $request->ngaycuoi != null) {
                $thongkedouong = ChiTietDonHang::where('idsanpham','>',0)->select(DB::raw("sum(soluong * gia) as tongtien,idsanpham,count('idsanpham') as soluong"))
                    ->join('donhang', 'donhang.id', '=', 'chitietdonhang.iddonhang')
                    ->whereDate('giogiao', [$request->ngaydau, $request->ngaycuoi])
                    ->where('tinhtrangdonhang',3)
                    ->orderBy('tongtien', 'DESC')->groupBy('idsanpham')->get();
                $thongkedoanhthu = DonHang::select(DB::raw("sum(tongtien) as tongtien,hinhthucthanhtoan,count(hinhthucthanhtoan) as soluong"))
                ->where('tinhtrangdonhang',3)
                ->whereBetween('giogiao', [$request->ngaydau, $request->ngaycuoi])->orderBy('tongtien', 'DESC')->groupBy('hinhthucthanhtoan')->get();
                $sosanh = DonHang::select(DB::raw("sum(tongtien) as tongtien,Date(giogiao)"))
                ->where('tinhtrangdonhang',3)
                ->whereBetween('giogiao', [$request->ngaydau, $request->ngaycuoi])->orderBy("Date(giogiao)")->groupBy('Date(giogiao)')->get();
                return view('admin.thongke', ['thongkedouong' => $thongkedouong, 'thongkedoanhthu' => $thongkedoanhthu, 'sosanh' => $sosanh]);
            } else {
                if ($request->ngaydau != null) {
                    $sosanh = $request->ngaydau;
                } else {
                    $sosanh = $request->ngaycuoi;
                }
                $thongkedouong = ChiTietDonHang::where('idsanpham','>',0)->select(DB::raw("sum(soluong * gia) as tongtien,idsanpham,count('idsanpham') as soluong"))
                    ->join('donhang', 'donhang.id', '=', 'chitietdonhang.iddonhang')
                    ->whereDate('giogiao', $sosanh)
                    ->where('tinhtrangdonhang',3)
                    ->orderBy('tongtien', 'DESC')->groupBy('idsanpham')->get();
                $thongkedoanhthu = DonHang::select(DB::raw("sum(tongtien) as tongtien,hinhthucthanhtoan,count(hinhthucthanhtoan) as soluong"))
                ->where('tinhtrangdonhang',3)
                ->whereDate('giogiao', $sosanh)->orderBy('tongtien', 'DESC')->groupBy('hinhthucthanhtoan')->get();
                return view('admin.thongke', ['thongkedouong' => $thongkedouong, 'thongkedoanhthu' => $thongkedoanhthu, 'sosanh' => array()]);
            }
        }
    }
}
