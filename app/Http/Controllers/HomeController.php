<?php

namespace App\Http\Controllers;

use App\Http\Middleware\khachhang as MiddlewareKhachhang;
use App\Models\BaiViet;
use App\Models\ChiTietDonHang;
use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\GiamGiaSanPham;
use App\Models\KhachHang;
use App\Models\KhuyenMai;
use App\Models\MangXaHoi;
use App\Models\SanPham;
use App\Models\Slide;
use App\Models\TheLoaiBaiViet;
use App\Models\ThongBao;
use App\Models\ThongTinNguoiNhan;
use App\Models\ThuongHieu;
use App\Models\TraLoiDanhGia;
use Carbon\CarbonTimeZone;
use DateTime;
use Doctrine\Common\Annotations\Annotation\Required;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite as FacadesSocialite;
use Socialite;

class HomeController extends Controller
{
    function __construct()
    {
        $danhmuc = DanhMuc::where('Hien', 1)->get();
        $slidenoibat = Slide::first();
        $slide = Slide::all()->skip(1);
        $theloaibaiviet = TheLoaiBaiViet::all();
        view()->share('theloaibaiviet', $theloaibaiviet);
        view()->share('danhmuc', $danhmuc);
        view()->share('slide', $slide);
        view()->share('slidenoibat', $slidenoibat);
    }
    public function home()
    {
        $bannhieunhat = ChiTietDonHang::select(DB::raw('Count(idsanpham) as solan , idsanpham'))
            ->where('idsanpham', '>', 0)->groupBy('idsanpham')
            ->whereExists(function($query){
                $query->select('sanpham1.id')->from('sanpham1')
                ->where('TrangThai',1)->whereRaw('chitietdonhang.idsanpham = sanpham1.id');
            })
            ->orderBY('solan', 'DESC')->take(6)->get();
        $sanphambannhieu = array();
        foreach ($bannhieunhat as $bnn) {
            $sanpham = SanPham::find($bnn->idsanpham);
            array_push($sanphambannhieu, $sanpham);
        }
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        $sanphammoinhat = SanPham::orderBy('created_at', 'DESC')->where('TrangThai',1)->take(6)->get();
        $giamgia = GiamGiaSanPham::where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)
            ->where('ngayketthuc', '>', $ngayhomnay)->where('hienthi', 1)->orderBy('ngayketthuc', 'ASC')->take(6)->get();
        return view('pages.index', ['sanphammoinhat' => $sanphammoinhat, 'sanphambannhieu' => $sanphambannhieu, 'giamgia' => $giamgia, 'giohientai' => $ngayhomnay]);
    }
    public function hiensanphamgiamgia()
    {
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        $giamgia = GiamGiaSanPham::where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)
            ->where('ngayketthuc', '>', $ngayhomnay)->where('hienthi', 1)->orderBy('ngayketthuc', 'ASC')->get();
        return view('pages.sanphamgiamgia', ['giamgia' => $giamgia]);
    }
    public function sanphamgiamgiatrangsanpham()
    {
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $giamgia = GiamGiaSanPham::join('sanpham1', 'giamgiasanpham.masanpham', '=', 'sanpham1.id')
            ->where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('hienthi', 1)
            ->where('ngayketthuc', '>', $ngayhomnay)->select('giamgiasanpham.id as id', 'Gia', 'TenSanPham', 'giakhuyenmai', 'Hinh', 'soluong', 'ngayketthuc')
            ->orderBy('ngayketthuc', 'DESC')->get();
        if (count($giamgia) > 0) {
            foreach ($giamgia as $gg) {
                $ngayketthuc = Carbon::create($gg->ngayketthuc);
                $ngayketthuc = $ngayketthuc->diff($ngayhomnay);
                if ($ngayketthuc->d > 0) {
                    $gg->ngayketthuc = $ngayketthuc->d . 'Ngày';
                } else {
                    $gg->ngayketthuc = $ngayketthuc->h . ':' . $ngayketthuc->i . ':' . $ngayketthuc->s;
                }
            }
        }
        return $giamgia;
    }
    public function sanphamgiamgia()
    {
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $giamgia = GiamGiaSanPham::join('sanpham1', 'giamgiasanpham.masanpham', '=', 'sanpham1.id')
            ->where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('hienthi', 1)
            ->where('ngayketthuc', '>', $ngayhomnay)->select('giamgiasanpham.id as id', 'Gia', 'TenSanPham', 'giakhuyenmai', 'Hinh', 'soluong', 'ngayketthuc')
            ->orderBy('ngayketthuc', 'DESC')->take(6)->get();
        if (count($giamgia) > 0) {
            foreach ($giamgia as $gg) {
                $ngayketthuc = Carbon::create($gg->ngayketthuc);
                $ngayketthuc = $ngayketthuc->diff($ngayhomnay);
                if ($ngayketthuc->d > 0) {
                    $gg->ngayketthuc = $ngayketthuc->d . 'Ngày';
                } else {
                    $gg->ngayketthuc = $ngayketthuc->h . ':' . $ngayketthuc->i . ':' . $ngayketthuc->s;
                }
            }
        }
        return $giamgia;
    }
    public function laysanphamtheodanhmuc($id, $trang)
    {
        $tendanhmuc = DanhMuc::where('id', $id)->first();
        $sanphamtheodanhmuc = SanPham::where('idDanhMuc', $id)->where('TrangThai',1)->get()->skip(9 * ($trang - 1))->take(9);
        $sosanpham = SanPham::select(DB::raw('COUNT(id) as sosanpham'))->where('TrangThai',1)->where('idDanhMuc', $id)->first();
        return view('pages.danhmuc', ['tendanhmuc' => $tendanhmuc, 'sanphamtheodanhmuc' => $sanphamtheodanhmuc, 'sosanpham' => $sosanpham->sosanpham]);
    }
    public function chitietsanpham($id)
    {
        $chitietsanpham = SanPham::find($id);
        $sanphamlienquan = SanPham::where('idDanhMuc', $chitietsanpham->idDanhMuc)->where('TrangThai',1)->where('id', '!=', $id)->get();
        $danhgia[0] = DanhGia::join('chitietdonhang', 'danhgia.masanpham', '=', 'chitietdonhang.id')->where('idsanpham', $id)
                        ->select(DB::raw("danhgia.id,sosao,masanpham,nguoidang,ngaydang,noidung"))
                        ->get();
        $saotrungbinh = number_format(DanhGia::join('chitietdonhang', 'danhgia.masanpham', '=', 'chitietdonhang.id')->where('idsanpham', $id)->avg('sosao'), 1);
        for ($i = 1; $i <= 5; $i++) {
            if ($i > 0) {
                $danhgia[$i] = DanhGia::join('chitietdonhang', 'danhgia.masanpham', '=', 'chitietdonhang.id')
                                ->select(DB::raw("danhgia.id,sosao,masanpham,nguoidang,ngaydang,noidung"))
                                ->where('idsanpham', $id)->where('sosao', $i)->get();
            }
        }
        

        return view('pages.chitietsanpham', ['sanphamlienquan' => $sanphamlienquan, 'chitietsanpham' => $chitietsanpham, 'danhgia' => $danhgia, 'saotrungbinh' => $saotrungbinh]);
    }
    public function login()
    {
        if (url()->current() !== url()->previous() && url()->previous() != route('dangki')) {
            Session::put('trang', url()->previous());
        }
        return view('pages.login');
    }
    public function dangki()
    {
        return view('pages.dangki');
    }
    public function postdangki(Request $request)
    {
        $this->validate($request, [
            'tennguoidung' => 'required|regex:/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùếúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẾẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i',
            'email' => 'required|email|unique:khachhang,email',
            'matkhau' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'nhaplaimatkhau' => 'same:matkhau',
            'sodienthoai' => 'required|regex:/^[0-9]{10,14}$/',
            'anhdaidien' => 'mimes:jpeg,jpg,png,gif'
        ], [
            'tennguoidung.required' => 'Vui Lòng Nhập Tên Người Dùng',
            'tennguoidung.regex' => 'Họ Tên Không Được Nhập Số Hoặc Kí Tự Đặc Biệt',
            'email.required' => 'Vui Lòng Nhập Email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'matkhau.required' => 'Vui Lòng Nhập Mật Khẩu',
            'matkhau.regex' => 'Mật khẩu phải từ 8 kí tự và phải bao gồm: Chữ hoa, chữ thường, số và kí tự đặc biệt',
            'nhaplaimatkhau.same' => 'Nhập lại mật khẩu không đúng',
            'sodienthoai.required' => 'Vui Lòng Nhập số điện thoại',
            'sodienthoai.regex' => 'Số Điện Thoại Không Đúng',
            'anhdaidien.mimes' => 'Ảnh Đại Diện Không Phù Hợp',
        ]);
        $khachhang = new KhachHang();
        $khachhang->tennguoidung = $request->tennguoidung;
        $khachhang->email = $request->email;
        $khachhang->sodienthoai = $request->sodienthoai;
        $khachhang->matkhau = password_hash($request->matkhau,null);
        $khachhang->created_at = Carbon::now();
        if ($request->hasFile('anhdaidien')) {
            $anhdaidien = $request->file('anhdaidien');
            $gio = Carbon::now('Asia/Ho_Chi_Minh');
            $gio = str_replace(':', '_', $gio);
            $gio = str_replace('/', '_', $gio);
            $gio = str_replace(' ', '_', $gio);
            $hinh = $gio . Str::random(6) . '.' . $anhdaidien->getClientOriginalExtension();
            $anhdaidien->move('upload/anhkhachhang/', $hinh);
            $khachhang->anhdaidien = $hinh;
        }
        $khachhang->save();
        return redirect('login')->with('thanhcong', 'Đăng Kí Thành Công')->with('email', $request->email)->with('matkhau', $request->password);
    }
    public function quenmatkhau()
    {
        return view('pages.quenmatkhau');
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
        $khachhang  = KhachHang::where('email', $request->email)->first();
        if ($khachhang) {
            $to_name = "Shop Đồ Uống";
            $to_email = $request->email;

            $mailData = array("id" => $khachhang->id, "tieude" => "Thông Báo Quên Mật Khẩu"); //body of mail.blade.php

            Mail::send('pages.email.quenmatkhau', $mailData, function ($message) use ($to_name, $to_email) {
                $message->to($to_email)->subject('Thông Tin Tài Khoản'); //send this mail with subject
                $message->from($to_email, $to_name); //send from this mail
            });
            return view('pages.postquenmatkhau');
        } else {
            return redirect('quenmatkhau')->with('thatbai', 'Email bạn nhập không đúng');
        }
    }
    public function datlaimatkhau($id)
    {
        return view('pages.datlaimatkhau', ['id' => $id]);
    }
    public function postdatlaimatkhau(Request $request, $id)
    {
        $this->validate($request, [
            'matkhau' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'
        ], [
            'matkhau.required' => 'Vui lòng nhập mật khẩu',
            'matkhau.regex' => 'Mật khẩu phải từ 8 kí tự,phải bao gồm: Chữ hoa,chữ thường,số và kí tự đặc biệt'
        ]);
        $khachhang = KhachHang::find($id);
        $khachhang->matkhau = password_hash($request->matkhau, null);
        $khachhang->save();
        Session::put('khachhang', $khachhang);
        return redirect('trangchu');
    }
    public function dangnhap(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Vui Lòng Nhập Email',
            'password.required' => 'Vui Lòng Nhập Mật Khẩu',
        ]);

        $khachhang = DB::table('khachhang')->where('email', '=', $request->email)->first();
        if ($khachhang) {
            //Hash::check(input,hash)
            if (password_verify($request->password, $khachhang->matkhau)) {
                Session::put('khachhang', $khachhang);
                if (Session::has('trang')) {
                    $trang = session('trang');
                    Session::forget('trang');
                    return redirect($trang);
                } else {
                    return redirect('trangchu');
                }
            } else {
                return redirect('login')->with('thatbai', 'Mật khẩu không đúng');
            }
        } else {
            return redirect('login')->with('thatbai', 'Email không tồn tại');
        }
    }
    public function dangxuat()
    {
        Session::forget('khachhang');
        return redirect('login')->with('thanhcong', 'Đăng Xuất Thành Công');
    }
    public function thanhtoan()
    {
        $diachi = DiaChi::all();
        $sanphamkhuyenmai = array();
        if (Session::has('giohang')) {
            foreach (session('giohang')->sanpham as $giohang) {
                if ($giohang['idkhuyenmai'] != "") {
                    $idsanpham = trim($giohang['idkhuyenmai']);
                    $idsanpham = explode(' ', $giohang['idkhuyenmai']);
                    foreach ($idsanpham as $id) {
                        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
                        $giamgia = GiamGiaSanPham::where("soluong", '>', 0)->where('id', $id)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->first();
                        if ($giamgia) {
                            array_push($sanphamkhuyenmai, $giamgia);
                        }
                    }
                }
            }
        } else {
            $sanphamkhuyenmai = null;
        }
        if (session('giamgia')) {
            Session::forget('giamgia');
        }
        if (session('muangay')) {
            Session::forget('muangay');
        }

        return view('pages.thanhtoan', ['diachi' => $diachi, 'sanpham' => null, 'sanphamkhuyenmai' => $sanphamkhuyenmai]);
    }
    public function muangay($id)
    {
        $diachi = DiaChi::all();
        $sanpham = SanPham::find($id);
        if (session('giamgia')) {
            Session::forget('giamgia');
        }
        Session::put('muangay', $sanpham);
        return view('pages.thanhtoan', ['diachi' => $diachi, 'sanpham' => $sanpham, 'sanphamkhuyenmai' => null]);
    }
    public function muagiamgia($id)
    {
        $diachi = DiaChi::all();
        $giamgiasanpham = GiamGiaSanPham::find($id);
        $sanpham = SanPham::find($giamgiasanpham->masanpham);
        if (session('giamgia')) {
            Session::forget('giamgia');
        }
        $sanpham->Gia = $giamgiasanpham->giakhuyenmai;
        Session::put('muangay', $sanpham);
        return view('pages.thanhtoan', ['diachi' => $diachi, 'sanpham' => $sanpham, 'sanphamkhuyenmai' => null]);
    }
    public function laygiatientutenphuong($id)
    {
        $diachi = DiaChi::find($id);
        return $diachi->gia;
    }
    public function tinhtiengiamgia(Request $request)
    {
        $magiamgia = KhuyenMai::where('makhuyenmai', $request->magiamgia)->first();
        $ngay = Carbon::now('Asia/Ho_Chi_Minh');
        if ($magiamgia) {
            if (($ngay >= $magiamgia->ngaybatdau) && ($ngay <= $magiamgia->ngayketthuc)) {
                if ($magiamgia->soluong > 0) {
                    $kiemtra =  substr_count($magiamgia->nguoisudung, (string)session('khachhang')->id);
                    if ($kiemtra > 0) {
                        $data = ["loi" => "Mã đã được sử dụng"];
                        return $data;
                    } else {
                        $data = $magiamgia->loaikhuyenmai . '-' . $magiamgia->sotien . '-' . $magiamgia->id;
                        Session::put('giamgia', $data);
                        return  $data;
                    }
                } else {
                    $data = ["loi" => "Mã đã hết lượt sử dụng"];
                    return $data;
                }
            } else {
                $data = ["loi" => "Mã Giảm Giá Đã Hết Hạn"];
                return $data;
            }
        } else {
            $data = ["loi" => "Mã Giảm Giá Không Đúng"];
            return $data;
        }
    }
    public function huygiamgia($id)
    {
        Session::forget('giamgia');
    }
    public function postthanhtoan(Request $request)
    {
        $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
        $this->validate($request, [
            'tennguoinhan' => 'required',
            'dienthoai' => 'required',
            'hinhthucthanhtoan' => 'required',
            'tenphuong' => 'required',
            'sonha' => 'required',
        ], [
            'tennguoinhan.required' => 'Vui lòng nhập tên người nhận',
            'dienthoai' => 'Vui lòng nhập số điện thoại người nhận',
            'hinhthucthanhtoan.required' => 'Vui lòng chọn hình thức thanh toán',
            'tenphuong.required' => 'Vui Lòng Nhập Tên Phường',
            'sonha.required' => 'Vui Lòng Nhập Địa chỉ Cụ Thể',
        ]);
        if (session('giamgia')) {
            $giamgia = explode('-', session('giamgia'));
            if ($giamgia[0] == 1) {
                if (session('muangay')) {
                    $tiengiamgia = round(session('muangay')->Gia * $giamgia[1] / 100, 0);
                } else {
                    $tiengiamgia = round(session('giohang')->tonggiatien * $giamgia[1] / 100, 0);
                }
            } else {
                $tiengiamgia = $giamgia[1];
            }
            $magiamgia = KhuyenMai::find($giamgia[2]);
            $magiamgia->soluong = $magiamgia->soluong - 1;
            $magiamgia->nguoisudung .= ' ' . (string)session('khachhang')->id;
            $magiamgia->save();
        } else {
            $tiengiamgia = 0;
        }
        $tenphuong = DiaChi::find($request->tenphuong);
        if ($request->hinhthucthanhtoan == 1) {
            $thongtinnguoinhan = new ThongTinNguoiNhan();
            $thongtinnguoinhan->tennguoinhan = $request->tennguoinhan;
            $thongtinnguoinhan->dienthoai = $request->dienthoai;
            $thongtinnguoinhan->diachi = $request->sonha . ',' . $tenphuong->tenphuong;
            $thongtinnguoinhan->save();
            $donhang = new DonHang();
            $donhang->idnguoinhan = $thongtinnguoinhan->id;
            $donhang->tienship = $tenphuong->gia;
            $donhang->idkhachhang = session('khachhang')->id;
            if (session('muangay')) {
                $donhang->tongtien = session('muangay')->Gia + $donhang->tienship - $tiengiamgia;
            } else {
                $donhang->tongtien = session('giohang')->tonggiatien + $donhang->tienship - $tiengiamgia;
            }
            //Hình Thức Thanh Toán
            //1:Trả Sau;
            //2:MOMO
            $donhang->hinhthucthanhtoan = $request->hinhthucthanhtoan;
            //tình trạng đơn hàng:
            //0:Chờ Xác Nhận Đơn Hàng;
            //1:đã xác nhận đơn hàng,chờ shipper lấy hàng;
            //2:shipper đã lấy hàng,đang trong quá trình giao;
            //3:giao hàng thành công
            $donhang->tinhtrangdonhang = 0;
            $donhang->ghichu = $request->ghichu;
            $donhang->giodat = Carbon::now("Asia/Ho_Chi_Minh");
            $donhang->save();
            if (session('muangay')) {
                $chitietdonhang = new ChiTietDonHang();
                $chitietdonhang->iddonhang = $donhang->id;
                $chitietdonhang->idsanpham = session('muangay')->id;
                $chitietdonhang->soluong = 1;
                $chitietdonhang->gia = session('muangay')->Gia;
                $chitietdonhang->save();
            } else {
                foreach (session('giohang')->sanpham as $sanpham) {
                    if ($sanpham['soluong'] > 0) {
                        $chitietdonhang = new ChiTietDonHang();
                        $chitietdonhang->iddonhang = $donhang->id;
                        $chitietdonhang->idsanpham = $sanpham['sanpham']->id;
                        $chitietdonhang->soluong = $sanpham['soluong'];
                        $chitietdonhang->gia = $sanpham['sanpham']->Gia;
                        $chitietdonhang->save();
                    }
                    if ($sanpham['idkhuyenmai'] != "") {
                        $idkhuyenmai = trim($sanpham['idkhuyenmai']);
                        $idkhuyenmai = explode(' ', $idkhuyenmai);
                        foreach ($idkhuyenmai as $khuyenmai) {
                            $chitietdonhang = new ChiTietDonHang();
                            $giamgia = GiamGiaSanPham::where('id', $khuyenmai)->where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->first();
                            if ($giamgia) {
                                $chitietdonhang->iddonhang = $donhang->id;
                                $chitietdonhang->idsanpham = $giamgia->masanpham;
                                $chitietdonhang->soluong = 1;
                                $chitietdonhang->gia = $giamgia->giakhuyenmai;
                                $chitietdonhang->save();
                                $giamgia->soluong -= 1;
                                $giamgia->save();
                            }
                        }
                    }
                }
            }

            $thongbao = new ThongBao();
            $thongbao->tieude = "Đơn Hàng Đã Được Tạo";
            $thongbao->noidung = "<p> Đơn Hàng Mã Số <b>" . $donhang->id . " </b>Đã Được Tạo Thành Công</p>";
            $thongbao->loaithongbao = 2;
            $thongbao->idkhachhang = session('khachhang')->id;
            $thongbao->ngaydang = $donhang->giodat;
            $gio = Carbon::now('Asia/Ho_Chi_Minh');
            $thongbao->ngayketthuc = $gio->addDay(14);
            $thongbaoimg = ChiTietDonHang::where('iddonhang', $donhang->id)->first();
            $thongbao->hinhanh = "sanpham/" . $thongbaoimg->SanPham->Hinh;
            $thongbao->save();
            if (session('giamgia')) {
                Session::forget('giamgia');
            }
            if (session('muangay')) {
                Session::forget('muangay');
            } else {
                Session::forget('giohang');
            }
            return redirect('trangchu')->with('thanhcong', 'Đơn Hàng Đã Được Tạo');
        } else if ($request->hinhthucthanhtoan == 2) {
            $thongtinndonhang = array(
                'tennguoinhan' => $request->tennguoinhan,
                'dienthoai' => $request->dienthoai,
                'diachi' => $request->sonha . ',' . $tenphuong->tenphuong,
                'hinhthucthanhtoan' => $request->hinhthucthanhtoan,
                'ghichu' => $request->ghichu,
                'tienship' => $tenphuong->gia,
                'tiengiamgia' => $tiengiamgia,
            );
            Session::put('thongtindonhang', $thongtinndonhang);
            return redirect('momo');
        }
    }
    public function sanpham($trang)
    {
        $sanpham  = SanPham::all()->where('TrangThai',1)->skip(9 * ($trang - 1))->take(9);
        $sosanpham = SanPham::where('TrangThai',1)->select(DB::raw('count(id) as sosanpham'))->first();
        return view('pages.sanpham', ['sanpham' => $sanpham, 'sosanpham' => $sosanpham->sosanpham]);
    }
    public function timkiemsanpham($key)
    {
        if ($key != -1) {
            $sanpham = SanPham::where('TrangThai',1)->where('TenSanPham', 'like', '%' . $key . '%')->get();
            $data = "<h2 class='title text-center'>Kết Quả Tìm Kiếm Của:" . $key . "</h2>";
            if (count($sanpham) > 0) {
                foreach ($sanpham as $sp) {
                    $sp->TenSanPham = str_replace($key, '<span style="color:red;font-weight:bold">' . $key . '</span>', $sp->TenSanPham);
                    $data .= "<div class='col-sm-4'><div class='product-image-wrapper'><div class='single-products'><a href='chitietsanpham/" . $sp->id . "'><div class='productinfo text-center'><img src='upload/sanpham/" . $sp->Hinh . "'/><span class='text_product'>" . $sp->TenSanPham . "</span><span class='text_product2'>" . number_format($sp->Gia) . "' VNĐ'</span></div></a></div><div class='choose'><ul class='nav nav-pills nav-justified'><li><a href='giohang/themvaogio/'" . $sp->id . "'><iclass='fa fa-shopping-cart'></i>Thêm Vào Giỏ Hàng</a></li><li><a href='muangay/" . $sp->id . "'><iclass='fa-solid fa-sack-dollar'></i>Mua Ngay</a></li></ul></div></div></div>";
                }
                return $data;
            } else {
                $data = "<h2 class='title text-center'>Kết Quả Tìm Kiếm Của:" . $key . "</h2>";
                $data .=  "<h2>Không Có Sản Phẩm Phù Hợp</h2>";
                return $data;
            }
        } else {
            $sanpham = SanPham::where('TrangThai',1)->take(9)->get();
            $sosanpham = SanPham::where('TrangThai',1)->all();
            $data = "<h2 class='title text-center'>Sản Phẩm</h2>";
            if (count($sanpham) > 0) {
                foreach ($sanpham as $sp) {
                    $data .= "<div class='col-sm-4'><div class='product-image-wrapper'><div class='single-products'><a href='chitietsanpham/" . $sp->id . "'><div class='productinfo text-center'><img src='upload/sanpham/" . $sp->Hinh . "'/><span class='text_product'>" . $sp->TenSanPham . "</span><span class='text_product2'>" . number_format($sp->Gia) . "' VNĐ'</span></div></a></div><div class='choose'><ul class='nav nav-pills nav-justified'><li><a href='giohang/themvaogio/'" . $sp->id . "'><iclass='fa fa-shopping-cart'></i>Thêm Vào Giỏ Hàng</a></li><li><a href='muangay/" . $sp->id . "'><iclass='fa-solid fa-sack-dollar'></i>Mua Ngay</a></li></ul></div></div></div>";
                }
                $data .= "<div class='pagination-area'><ul class='pagination'>";
                $sotrang = (int) count($sosanpham) % 9 == 0 ? count($sosanpham) / 9 : count($sosanpham) / 9 + 1;
                for ($i = 1; $i <= $sotrang; $i++) {
                    $data .= "<li><a href='sanpham/" . $i . "' class='active'>" . $i . "</a></li>";
                }
                $data .= "</ul></div>";
                return $data;
            }
        }
    }
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function momo()
    {
        if (session('muangay')) {
            $tongtien = session('muangay')->Gia + session('thongtindonhang')['tienship'] - session('thongtindonhang')['tiengiamgia'];
        } else {
            $tongtien = session('giohang')->Gia + session('thongtindonhang')['tienship'] - session('thongtindonhang')['tiengiamgia'];
        }
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMONEPD20220216';
        $accessKey = 'ffgVmZWbAUNAPqVM';
        $secretKey = '9StOL6TJlmmTgAgnzR05fvZKe6njCkza';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $tongtien;
        $orderId = time() . "";
        $redirectUrl = "http://laravel-app:8000/resultmomo";
        $ipnUrl = "http://laravel-app:8000/resultmomo";
        $extraData = "";
        $requestId = time() . "";
        $requestType = "captureWallet";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
    }
    public function resultmomo()
    {
        $resultCode = $_GET['resultCode'];
        if ($resultCode == 0) {
            $thongtinnguoinhan = new ThongTinNguoiNhan();
            $thongtinnguoinhan->tennguoinhan = session('thongtindonhang')['tennguoinhan'];
            $thongtinnguoinhan->dienthoai = session('thongtindonhang')['dienthoai'];
            $thongtinnguoinhan->diachi = session('thongtindonhang')['diachi'];
            $thongtinnguoinhan->save();
            $donhang = new DonHang();
            $donhang->idnguoinhan = $thongtinnguoinhan->id;
            $donhang->idkhachhang = session('khachhang')->id;
            //Hình Thức Thanh Toán
            //1:Trả Sau;
            //2:MOMO
            $donhang->hinhthucthanhtoan = session('thongtindonhang')['hinhthucthanhtoan'];
            //tình trạng đơn hàng:
            //0:Chờ Xác Nhận Đơn Hàng;
            //1:đã xác nhận đơn hàng,chờ shipper lấy hàng;
            //2:shipper đã lấy hàng,đang trong quá trình giao;
            //3:giao hàng thành công
            $donhang->tinhtrangdonhang = 0;
            $donhang->tienship = session('thongtindonhang')['tienship'];
            $donhang->ghichu = session('thongtindonhang')['ghichu'];
            $donhang->giodat = Carbon::now("Asia/Ho_Chi_Minh");
            if (session('muangay')) {
                $donhang->tongtien = session('muangay')->Gia +  $donhang->tienship - session('thongtindonhang')['tiengiamgia'];
            } else {
                $donhang->tongtien = session('giohang')->tonggiatien +  $donhang->tienship - session('thongtindonhang')['tiengiamgia'];
            }
            $donhang->save();
            if (session('muangay')) {
                $chitietdonhang = new ChiTietDonHang();
                $chitietdonhang->iddonhang = $donhang->id;
                $chitietdonhang->idsanpham = session('muangay')->id;
                $chitietdonhang->soluong = 1;
                $chitietdonhang->gia = session('muangay')->Gia;
                $chitietdonhang->save();
            } else {
                foreach (session('giohang')->sanpham as $sanpham) {
                    if ($sanpham['soluong'] > 0) {
                        $chitietdonhang = new ChiTietDonHang();
                        $chitietdonhang->iddonhang = $donhang->id;
                        $chitietdonhang->idsanpham = $sanpham['sanpham']->id;
                        $chitietdonhang->soluong = $sanpham['soluong'];
                        $chitietdonhang->gia = $sanpham['sanpham']->Gia;
                        $chitietdonhang->save();
                    }
                    if ($sanpham['idkhuyenmai'] != "") {
                        $idkhuyenmai = trim($sanpham['idkhuyenmai']);
                        $idkhuyenmai = explode(' ', $idkhuyenmai);
                        foreach ($idkhuyenmai as $id) {
                            $chitietdonhang = new ChiTietDonHang();
                            $ngayhomnay = Carbon::now("Asia/Ho_Chi_Minh");
                            $giamgia = GiamGiaSanPham::where('id', $id)->where("soluong", '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->first();
                            if ($giamgia) {
                                $chitietdonhang->iddonhang = $donhang->id;
                                $chitietdonhang->idsanpham = $giamgia->masanpham;
                                $chitietdonhang->soluong = 1;
                                $chitietdonhang->gia = $giamgia->giakhuyenmai;
                                $chitietdonhang->save();
                                $giamgia->soluong -= 1;
                                $giamgia->save();
                            }
                        }
                    }
                }
            }
            $thongbao = new ThongBao();
            $thongbao->tieude = "Đơn Hàng Đã Được Tạo";
            $thongbao->noidung = "<p> Đơn Hàng Mã Số <b>" . $donhang->id . " </b>Đã Được Tạo Thành Công</p>";
            $thongbao->loaithongbao = 2;
            $thongbao->idkhachhang = session('khachhang')->id;
            $thongbao->ngaydang = $donhang->giodat;
            $gio = Carbon::now('Asia/Ho_Chi_Minh');
            $thongbao->ngayketthuc = $gio->addDay(14);
            $thongbaoimg = ChiTietDonHang::where('iddonhang', $donhang->id)->first();
            $thongbao->hinhanh = "sanpham/" . $thongbaoimg->SanPham->Hinh;
            $thongbao->save();
            if (session('muangay')) {
                Session::forget('muangay');
            } else {
                Session::forget('giohang');
            }
            return redirect('trangchu')->with('thanhcong', 'Thanh Toán Thành Công');
        } else {
            return redirect('thanhtoan')->with('thatbai', 'Thanh Toán Thất Bại Vui Lòng Kiểm Tra Lại');
        }
    }
    public function lichsu()
    {
        if (isset(session('khachhang')->id)) {
            $donhang = DonHang::where('idkhachhang', session('khachhang')->id)->where('tinhtrangdonhang', 3)->get();
            return view('pages.lichsudonhang', ['donhang' => $donhang]);
        } else {
            return redirect('login');
        }
    }
    public function chitietlichsu($id)
    {
        $chitiet = ChiTietDonHang::where('iddonhang', $id)->get();
        $donhang = DonHang::find($id);
        return view('pages.chitietlichsu', ['chitiet' => $chitiet, 'donhang' => $donhang]);
    }
    public function baiviet($stt)
    {
        $baiviet = BaiViet::where('hienthi', 1)->orderBy('ngaydang', 'DESC')->skip(5*($stt-1))->take(5)->get();
        $sobaiviet = count($baiviet);
        return view('pages.baiviet', ['baiviet' => $baiviet, 'sobaiviet' => $sobaiviet]);
    }
    public function baiviettheotheloai($id,$stt)
    {
        $theloai = TheLoaiBaiViet::find($id);
        $baiviet = BaiViet::where('matheloai', $id)->where('hienthi', 1)->skip(5*($stt-1))->take(5)->get();
        $sobaiviet = count($baiviet);
        return view('pages.baiviet', ['baiviet' => $baiviet, 'theloai' => $theloai, 'sobaiviet' => $sobaiviet]);
    }
    public function chitietbaiviet($id)
    {
        $baiviet = BaiViet::find($id);
        return view('pages.chitietbaiviet', ['baiviet' => $baiviet]);
    }
    public function danhgia($donhang, $stt)
    {
        $sanpham = ChiTietDonHang::skip($stt)->where('iddonhang', $donhang)->first();
        if ($sanpham->DonHang->idkhachhang == session('khachhang')->id) {
            Session::put('star', 0);
            return view('pages.danhgia', ['sanpham' => $sanpham, 'stt' => $stt, 'donhang' => $donhang]);
        } else {
            return redirect('login');
        }
    }

    public function postdanhgia(Request $request, $donhang, $stt)
    {
        $sanpham = ChiTietDonHang::where('iddonhang', $donhang)->get();
        if (session('star') > 0) {
            $danhgia = new DanhGia();
            $danhgia->masanpham = $sanpham[$stt]->id;
            $danhgia->madon = $sanpham[$stt]->iddonhang;
            $danhgia->sosao = session('star');
            $danhgia->nguoidang = session('khachhang')->id;
            $danhgia->noidung = $request->noidung;
            $danhgia->ngaydang = Carbon::now('Asia/Ho_Chi_Minh');
            $danhgia->hienthi = 1;
            $danhgia->save();
        } else if (session('star') == 0 && $request->noidung != null) {
            return redirect('danhgia/' . $donhang . '/' . $stt)->with('thatbai', 'Vui Lòng Nhập Số Sao');
        }
        if (count($sanpham) - 1 > $stt) {
            return redirect('danhgia/' . $donhang . '/' . $stt + 1);
        } else {
            return redirect('thongbao/donhang/danhgia');
        }
    }
    public function doisao($sao)
    {
        Session::put('star', $sao);
    }
    public function donhangdangcho()
    {
        $donhang = DonHang::where('idkhachhang', session('khachhang')->id)->where('tinhtrangdonhang', '>=', 0)->where('tinhtrangdonhang', '<', 3)->get();
        return view('pages.donhangdangcho', ['donhang' => $donhang]);
    }
    public function tatca()
    {
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();
        $thongbao = ThongBao::where('idkhachhang', null)->orWhere('idkhachhang', session('khachhang')->id)
            ->where('ngaydang', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)
            ->orderBy('ngaydang', 'DESC')->get();
        return view('pages.thongbao', ['magiamgia' => $magiamgia, 'thongbao' => $thongbao]);
    }
    public function kiemtrathongbao()
    {
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $thongbao = ThongBao::where('idkhachhang', null)->orWhere('idkhachhang', session('khachhang')->id)
            ->where('ngaydang', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)
            ->orderBy('ngaydang', 'DESC')->take(3)->get();
        return $thongbao;
    }
    public function thongbao($id)
    {
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        if ($id != 2) {
            $thongbao = ThongBao::where('loaithongbao', $id)
                ->where('ngaydang', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)
                ->orderBy('ngaydang', 'DESC')->get();
        } else {
            $thongbao = ThongBao::where('loaithongbao', $id)->where('idkhachhang', session('khachhang')->id)
                ->where('ngaydang', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)
                ->orderBy('ngaydang', 'DESC')->get();
        }
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();

        return view('pages.thongbao', ['magiamgia' => $magiamgia, 'thongbao' => $thongbao]);
    }
    public function xemthongtin()
    {
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $khachhang = KhachHang::find(session('khachhang')->id);
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();
        return view('pages.taikhoan.xemthongtin', ['magiamgia' => $magiamgia, 'khachhang' => $khachhang]);
    }
    public function doimatkhau()
    {
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();
        return view('pages.taikhoan.doimatkhau', ['magiamgia' => $magiamgia]);
    }
    public function postdoimatkhau(Request $request)
    {
        $this->validate($request, [
            'matkhaucu' => 'required',
            'matkhaumoi' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
            'nhaplaimatkhau' => 'same:matkhaumoi'
        ], [
            'matkhaucu.required' => 'Vui Lòng Nhập Mật Khẩu Cũ',
            'matkhaumoi.required' => 'Vui Lòng Nhập Mật Khẩu Mới',
            'matkhaumoi.regex' => 'Mật Khẩu Không Hợp Lệ Mật Khẩu Phải Từ 8 Kí Tự Và Phải Bao Gồm:Chữ Thường,Chữ Hoa,Số,Kí Tự Đặc Biệt',
            'nhaplaimatkhau.same' => 'Nhập Lại Mật Khẩu Không Đúng'
        ]);
        $taikhoan = KhachHang::find(session('khachhang')->id);
        if (password_verify($request->matkhaucu, $taikhoan->matkhau)) {
            $taikhoan->matkhau = password_hash($request->matkhaumoi, null);
            return redirect('thongbao/taikhoan/doimatkhau')->with('thanhcong', 'Đổi Mật Khẩu Thành Công');
        } else {
            return redirect('thongbao/taikhoan/doimatkhau')->with('thatbai', 'Mật Khẩu Không Đúng');
        }
    }
    public function postxemthongtin(Request $request)
    {
        $khachhang = KhachHang::find(session('khachhang')->id);
        if ($request->tennguoidung == $khachhang->tennnguoidung && !$request->has('anhdaidien') && $khachhang->sodienthoai == $request->sodienthoai) {
            return redirect('thongbao/taikhoan/xemthongtin');
        } else {
            $this->validate($request, [
                'tennguoidung' => 'required|regex:/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùếúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẾẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i',
                'sodienthoai' => 'required|regex:/^[0-9]{10,14}$/',
                'anhdaidien' => 'mimes:jpeg,jpg,png,gif'
            ], [
                'tennguoidung.required' => 'Vui Lòng Nhập Tên Người Dùng',
                'tennguoidung.regex' => 'Họ Tên Không Được Nhập Số Hoặc Kí Tự Đặc Biệt',
                'sodienthoai.required' => 'Vui Lòng Nhập số điện thoại',
                'sodienthoai.regex' => 'Số Điện Thoại Không Đúng',
                'anhdaidien.mimes' => 'Ảnh Đại Diện Không Phù Hợp',
            ]);
            if ($request->has('anhdaidien')) {
                $anhdaidien = $request->file('anhdaidien');
                $gio = Carbon::now('Asia/Ho_Chi_Minh');
                $gio = str_replace(':', '_', $gio);
                $gio = str_replace('-', '_', $gio);
                $gio = str_replace(' ', '_', $gio);
                $tenanh = $gio . Str::random(6) . '.' . $anhdaidien->getClientOriginalExtension();
                if (!empty($khachhang->anhdaidien)) {
                    unlink('upload/anhkhachhang/' . $khachhang->anhdaidien);
                }
                $anhdaidien->move('upload/anhkhachhang/', $tenanh);
                $khachhang->anhdaidien = $tenanh;
            } else {
                if ($khachhang->anhdaidien) {
                    unlink('upload/anhkhachhang/' . $khachhang->anhdaidien);
                }
                $khachhang->anhdaidien = null;
            }
            $khachhang->tennguoidung = $request->tennguoidung;
            $khachhang->sodienthoai = $request->sodienthoai;
            $khachhang->save();
            Session::put('khachhang', $khachhang);
            return redirect('thongbao/taikhoan/xemthongtin')->with('thanhcong', 'Sửa Thông Tin thành Công');
        }
    }
    public function tatcadonhang()
    {
        $donhang = DonHang::where('idkhachhang', session('khachhang')->id)->orderBy('giodat', 'DESC')->get();
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();
        return view('pages.thongbaodonhang', ['magiamgia' => $magiamgia, 'donhang' => $donhang, 'tieude' => 'Tất Cả Đơn Hàng']);
    }
    public function hiendonhang($id)
    {
        $donhang = DonHang::where('idkhachhang', session('khachhang')->id)->where('tinhtrangdonhang', $id)->orderBy('giodat', 'DESC')->get();
        $ngayhomnay = Carbon::now('Asia/Ho_Chi_Minh');
        $magiamgia = KhuyenMai::where('nguoisudung', 'not like', '%' . session('khachhang')->id . '%')
            ->where('soluong', '>', 0)->where('ngaybatdau', '<=', $ngayhomnay)->where('ngayketthuc', '>', $ngayhomnay)->get();
        switch ($id) {
            case 0:
                $tieude = "Đơn Hàng Đang Chờ Xác Nhận";
                break;
            case 1:
                $tieude = "Đơn Hàng Đang Chờ Được Giao";
                break;
            case 3:
                $tieude = "Đơn Hàng Đã Hoàn Thành";
                break;
            case -1:
                $tieude = "Đơn Hàng Bị Hủy";
                break;
        }
        return view('pages.thongbaodonhang', ['magiamgia' => $magiamgia, 'donhang' => $donhang, 'tieude' => $tieude]);
    }
    public function danhgiadonhang()
    {
        $donhang = DonHang::where('idkhachhang', session('khachhang')->id)->where('tinhtrangdonhang', 3)
            ->orderBy('giodat', 'DESC')
            ->whereNotExists(function ($query) {
                $query->select("danhgia.madon")
                    ->from('danhgia')
                    ->whereRaw('donhang.id = danhgia.madon');
            })
            ->whereNotExists(function($query){
                $query->select("chitietdonhang.iddonhang")->from('chitietdonhang')
                ->where('idsanpham',0)->whereRaw('chitietdonhang.iddonhang = donhang.id');
            })
            ->get();
        return view('pages.thongbaodanhgia', ['donhang' => $donhang, 'tieude' => "Đơn Hàng Chưa Đánh Giá"]);
    }
    public function xemdanhgiadonhang()
    {
        $danhgia = DanhGia::where('nguoidang', session('khachhang')->id)->orderBy('ngaydang', 'DESC')->get();
        return view('pages.xemdanhgiadonhang', ['danhgia' => $danhgia, 'tieude' => "Đơn Hàng Đã Đánh Giá"]);
    }
    public function xoadanhgia($id)
    {
        $danhgia = DanhGia::find($id);
        if ($danhgia->TraLoi) {
            $traloi = TraLoiDanhGia::find($danhgia->TraLoi->id);
            $traloi->delete();
        }
        $danhgia->delete();
        return redirect('thongbao/donhang/xemdanhgia')->with('thanhcong', 'Xoá Đánh Giá Thành Công');
    }
    public function suadanhgia($id, $idsanpham)
    {
        $danhgia = DanhGia::find($id);
        return view('pages.suadanhgia', ['danhgia' => $danhgia]);
    }
    public function postsuadanhgia($id, $idsanpham, Request $request)
    {
        $danhgia = DanhGia::find($id);
        if (session('star') > 0) {
            $danhgia->masanpham = $idsanpham;
            $danhgia->madon = $danhgia->madon;
            $danhgia->sosao = session('star');
            $danhgia->nguoidang = session('khachhang')->id;
            $danhgia->noidung = $request->noidung;
            $danhgia->ngaydang = Carbon::now('Asia/Ho_Chi_Minh');
            $danhgia->hienthi = 1;
            $danhgia->save();
            return redirect('thongbao/donhang/xemdanhgia')->with('thanhcong', 'Sửa Đánh Giá Thành Công');
        } else {
            return redirect('thongbao/donhang/suadanhgia/' . $id . '/' . $idsanpham)->with('thatbai', 'Vui Lòng Nhập Số Sao');
        }
    }
}
