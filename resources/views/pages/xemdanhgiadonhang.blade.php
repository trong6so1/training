@extends('layout.main')
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
@section('content')
    <section>
        <div class="container">
            <div class="row">
                @include('layout.menuthongbao')
                <div class="col-sm-9 ">
                    <div class="features_items">
                        <!--login form-->
                        <h2 class="title text-center">{{ $tieude }}</h2>
                        @if (count($danhgia) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped b-t b-light">
                                    <thead>
                                        <tr>
                                            <th>Mã Đơn Hàng</th>
                                            <th></th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Giá</th>
                                            <th style="width:150px;">Số Sao</th>
                                            <th>Đánh Giá</th>
                                            <th>Phản Hồi Của Cửa Hàng</th>
                                            <th style="width:50px;">Xem Chi Tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($danhgia as $dh)
                                            <tr>
                                                <td>{{ $dh->madon }}</td>
                                                <td><img src="upload/sanpham/{{ $dh->ChiTiet->SanPham->Hinh }}"
                                                        height="150px" alt=""></td>
                                                <td>{{ $dh->ChiTiet->SanPham->TenSanPham }}</td>
                                                <td>{{ number_format($dh->ChiTiet->gia) . ' VNĐ' }}</td>
                                                <td>
                                                    <span class="danhgiasanpham">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($dh->sosao >= $i)
                                                                <i class="fa fa-star color"></i>
                                                            @else
                                                                <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </td>
                                                <td>{{ $dh->noidung }}</td>
                                                <td>
                                                    @if ($dh->TraLoi)
                                                        {{ $dh->TraLoi->noidung }}
                                                    @else
                                                        {{ '' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="thongbao/donhang/suadanhgia/{{ $dh->id }}/{{ $dh->ChiTiet->SanPham->id }}"
                                                        class="btn btn-warning">Sửa</a>
                                                    <a onclick="return confirm('Bạn có thật sự muốn xóa đánh giá không?')"
                                                        href="thongbao/donhang/xoadanhgia/{{ $dh->id }}"
                                                        class="btn btn-danger">Xóa</a>
                                                    <a href="chitietlichsu/{{ $dh->madon }}" class="btn btn-success">Xem
                                                        Đơn Hàng</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{ 'Không Có Đơn Hàng' }}
                        @endif
                    </div>
                </div>
    </section>
@endsection
