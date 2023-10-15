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
                        @if (count($donhang) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped b-t b-light">
                                    <thead>
                                        <tr>
                                            <th>Mã Đơn Hàng</th>
                                            <th>Địa Chỉ</th>
                                            <th>Tổng Tiền</th>
                                            <th>Tình Trạng Đơn Hàng</th>
                                            <th>Giờ Đặt</th>
                                            <th>Giờ Giao</th>
                                            <th style="width:50px;">Xem Chi Tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donhang as $dh)
                                            <tr>
                                                <td>{{ $dh->id }}</td>
                                                <td>{{ $dh->NguoiNhan->diachi }}</td>
                                                <td>{{ number_format($dh->tongtien) . ' VNĐ' }}</td>
                                                <td>
                                                    @switch($dh->tinhtrangdonhang)
                                                        @case(0)
                                                            {{ 'Chờ Xác Nhận Đơn' }}
                                                        @break

                                                        @case(1)
                                                            {{ 'Đã Xác Nhận Đơn,Đang Trong Quá Trình Giao' }}
                                                        @break

                                                        @case(3)
                                                            {{ 'Đã Giao Hàng Xong' }}
                                                        @break

                                                        @case(-1)
                                                            {{ 'Đơn Hàng Đã Bị Hủy' }}
                                                        @break
                                                    @endswitch

                                                </td>
                                                <td>{{ $dh->giodat }}</td>
                                                <td>
                                                    @switch($dh->tinhtrangdonhang)
                                                        @case(0)
                                                            {{ 'Chờ Xác Nhận Đơn' }}
                                                        @break

                                                        @case(1)
                                                            {{ 'Đang Trong Quá Trình Giao' }}
                                                        @break

                                                        @case(3)
                                                            {{ $dh->giogiao }}
                                                        @break

                                                        @case(-1)
                                                            {{ $dh->giogiao }}
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <a href="chitietlichsu/{{ $dh->id }}" class="btn btn-success">Xem Đơn Hàng</a>
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
