@extends('admin.layout')
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $err)
                {{ $err }}<br />
            @endforeach
        </div>
    @endif
    @if (session('thatbai'))
        <script>
            Swal.fire("Lỗi", "{{ session('thatbai') }}", "error", {
                button: "OK",
            })
        </script>
    @endif
    @if (session('thanhcong'))
        <script>
            Swal.fire("Thành Công", "{{ session('thanhcong') }}", "success", {
                button: "OK",
            })
        </script>
    @endif
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh Sách Đánh Giá
                <select name="danhgia" id="">
                    <option value="{{ 0 }}">Tat Ca</option>
                    <option value="{{ 1 }}">Da Tra Loi</option>
                    <option value="{{ 2 }}">Chua Tra Loi</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Người Đánh Giá</th>
                        <th>Số Sao</th>
                        <th>Nội Dung Đánh Giá</th>
                        <th>Trả Lời</th>
                        <th>Nhân Viên Trả Lời</th>
                        <th style="width:100px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($danhgia as $dg)
                        <tr>
                            <td><img src="upload/sanpham/{{ $dg->ChiTiet->SanPham->Hinh }}" class="imgad" alt=""></td>
                            <td>{{ $dg->ChiTiet->SanPham->TenSanPham }}</td>
                            <td>{{ $dg->madon }}</td>
                            <td>{{ $dg->NguoiDang->tennguoidung }}</td>
                            <td class="sosao">
                                <span class="danhgiasanpham">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($dg->sosao >= $i)
                                            <i class="fa fa-star color"></i>
                                        @else
                                            <i class="fa fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                            </td>
                            <td>{{ $dg->noidung }}</td>
                            <td>
                                @if ($dg->TraLoi)
                                    {{ $dg->TraLoi->noidung }}
                                @else
                                    {{ 'Chưa Trả Lời' }}
                                @endif
                            </td>
                            <td>
                                @if ($dg->TraLoi) 
                                    @if (isset($dg->TraLoi->NhanVienTraLoi))
                                        {{ $dg->TraLoi->NhanVienTraLoi->hoten."(Ma Nhan Vien:".$dg->TraLoi->NhanVienTraLoi->id.")" }}
                                    @else
                                        {{ "Nhan Vien Da Nghi" }}
                                    @endif
                                @else
                                    {{ 'Chưa Trả Lời' }}
                                @endif
                            </td>
                            <td>
                                @if ($dg->Traloi)
                                    <a class="btn btn-warning" href="admin/danhgia/sua/{{ $dg->id }}">Sửa Trả Lời</a>
                                    <a onclick="return confirm('Bạn có thật sự muốn xóa danh mục không?')"
                                        class="btn btn-danger" href="admin/danhgia/xoa/{{ $dg->id }}">Xóa Trả Lời</a>
                                @else
                                    <a class="btn btn-success" href="admin/danhgia/traloidanhgia/{{ $dg->id }}">Trả
                                        Lời</a>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
