@extends('layout.main')
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
                Danh Sách Đơn Hàng Đang Chờ
            </div>
        </div>
        @if (count($donhang) > 0)
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Người Nhận</th>
                            <th>Địa Chỉ</th>
                            <th>Tổng Tiền</th>
                            <th>Tình Trạng Đơn Hàng</th>
                            <th>Ghi chú cho shipper</th>
                            <th style="width:50px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($donhang as $dh)
                            <tr>
                                <td>{{ $dh->id }}</td>
                                <td>{{ $dh->NguoiNhan->tennguoinhan }}</td>
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
                                    @endswitch

                                </td>
                                <td>
                                    @if (!empty($dh->ghichu))
                                        {{ $dh->ghichu }}
                                </td>
                            @else
                                {{ 'Không' }}
                        @endif
                        <td>
                            <a href="chitietlichsu/{{ $dh->id }}"><i class="fa-solid fa-eye"></i></a>
                        </td>
                        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
@else
    {{ 'Không Có Đơn Hàng' }}
    @endif
@endsection
