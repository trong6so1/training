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
                                            <th>Giờ Đặt</th>
                                            <th>Giờ Giao</th>
                                            <th style="width:150px;">Chức Năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($donhang as $dh)
                                            <tr>
                                                <td>{{ $dh->id }}</td>
                                                <td>{{ $dh->NguoiNhan->diachi }}</td>
                                                <td>{{ number_format($dh->tongtien) . ' VNĐ' }}</td>
                                                <td>{{ $dh->giodat }}</td>
                                                <td>{{ $dh->giogiao }}</td>
                                                <td>
                                                    <a class="btn btn-info"
                                                        href="danhgia/{{ $dh->id }}/{{ 0 }}">Đánh Giá</a>
                                                    <a class="btn btn-success" href="chitietlichsu/{{ $dh->id }}">Xem
                                                        Chi Tiết</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{ 'Không Có Đơn Hàng' }}
                        @endif
                        {{-- <div class="col-sm-3 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Mã Giảm Giá</h2>
                    @if (count($magiamgia) > 0)
                        @foreach ($magiamgia as $ma)
                            <div class="title_sale">
                                <div class="title_sale_img">
                                    <img src="front-end/images/khuyenmai.png" 
                                    alt=""
                                    />
                                </div>
                                <div class="title_sale_content">
                                    <h1 class="title_sale_content_item2">Mã: {{ $ma->makhuyenmai }}</h1>
                                    <p class="title_sale_content_item3">{{ $ma->noidung }}</p>
                                    <p class="title_sale_content_item3">NKM: <?php echo date('d/m/Y', strtotime($ma->ngaybatdau)); ?></p>
                                    <p class="title_sale_content_item3">HSD: <?php echo date('d/m/Y', strtotime($ma->ngayketthuc)); ?></p>
                                </div>
                                    
                            </div>
                        @endforeach
                    @else
                        <div class="title_sale">
                            <h6>Không Có Mã Có Thể Sử Dụng</h6>
                        </div>
                    @endif

                </div><!--features_items-->
            </div> --}}
                    </div>
                </div>
    </section>
@endsection
