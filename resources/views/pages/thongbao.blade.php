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
                <div class="col-sm-6 ">
                    <div class="features_items">
                        <!--features_items-->
                        <h2 class="title text-center">Thông Báo</h2>
                        @if (count($thongbao) > 0)
                            @foreach ($thongbao as $tb)
                                <div class="title_content">
                                    <div class="title_content_img">
                                        <img src="upload/{{ $tb->hinhanh }}" height="150px" alt="">
                                    </div>
                                    <div class="title_content_Mess">
                                        <h1 class="title_content_Mess_item1">{{ $tb->tieude }}</h1>
                                        {!! $tb->noidung !!}
                                        <p class="title_content_Mess_item3"><?php echo date('d/m/Y H:i:s', strtotime($tb->ngaydang)); ?></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h4>Không có thông báo</h4>
                        @endif



                    </div>
                    <!--features_items-->
                </div>
                <div class="col-sm-3 padding-right">
                    <div class="features_items">
                        <!--features_items-->
                        <h2 class="title text-center">Mã Giảm Giá</h2>
                        @if (count($magiamgia) > 0)
                            @foreach ($magiamgia as $ma)
                                <div class="title_sale">
                                    <div class="title_sale_img">
                                        <img src="front-end/images/khuyenmai.png" alt="" />
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

                    </div>
                    <!--features_items-->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
