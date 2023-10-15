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
                        <!--login form-->
                        <h2 class="title text-center">Thông Tin</h2>
                        <div class="thongbao-form">
                            <form action="thongbao/taikhoan/xemthongtin" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <label>Họ Tên:</label>
                                <input type="text" placeholder="Nhập Họ Tên" value="{{ $khachhang->tennguoidung }}"
                                    name="tennguoidung" />
                                <label>Email:</label>
                                <input type="text" value="{{ $khachhang->email }}" name="email" />
                                <label>Số Điện Thoại:</label>
                                <input type="text" placeholder="Nhập Số Điện Thoại" value="{{ $khachhang->sodienthoai }}"
                                    name="sodienthoai" />
                                @if ($khachhang->anhdaidien)
                                    <img id="imgsanpham" src="upload/anhkhachhang/{{ $khachhang->anhdaidien }}"
                                        class="img-taikhoan-thongbao">
                                @endif
                                <label>Ảnh Đại Diện:</label>
                                <input type="file" name="anhdaidien" id="fileanhsanpham">
                                <button type="submit" class="btn btn-default">Lưu</button>
                            </form>
                        </div>
                    </div>
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
    <script>
        $(document).ready(function() {
            $("#fileanhsanpham").change(function(e) {
                if ($("#fileanhsanpham").val() != "") {
                    var input = document.getElementById("fileanhsanpham");
                    var fReader = new FileReader();
                    fReader.readAsDataURL(input.files[0]);
                    fReader.onloadend = function(event) {
                        if ($("#imgsanpham")) {
                            $("#imgsanpham").remove();
                        }
                        $("#fileanhsanpham").before(
                            `<img id='imgsanpham' src=${event.target.result} class="img-taikhoan-thongbao">`
                            );
                    }
                } else {
                    if ($("#imgsanpham")) {
                        $("#imgsanpham").remove();
                    }
                }
            })
        });
    </script>
@endsection
