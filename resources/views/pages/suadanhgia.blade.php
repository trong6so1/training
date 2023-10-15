@extends('layout.main')
@section('content')
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
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
            <div class="content_danhgia">
                <h1 class="content_danhgia_item">Đánh giá đơn hàng</h1>
                <h4 class="content_danhgia_item">Mã đơn hàng: {{ $danhgia->madon }}</h4>
            </div>
            <form action="thongbao/donhang/suadanhgia/{{ $danhgia->id }}/{{ $danhgia->masanpham }}" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value={{ csrf_token() }}>
                <div class="thongtindanhgia">
                    <img class="img_danhgia" src="upload/sanpham/{{ $danhgia->ChiTiet->SanPham->Hinh }}" alt="">
                    <div class="thongtinsanpham">
                        <p>{{ $danhgia->ChiTiet->SanPham->TenSanPham }}</p>
                        <h5>Giá:{{ number_format($danhgia->ChiTiet->gia) . ' VNĐ' }}</h5>
                        <h5>Số Lượng:{{ $danhgia->ChiTiet->soluong }}</h5>
                    </div>
                </div>
                <ul class="ulstar">
                    <p>Chất Lượng Sản Phẩm:</p>
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($danhgia->sosao >= $i)
                            <li class="star color" id={{ $i }} data-id={{ $i }}>&#9733;</li>
                        @else
                            <li class="star" id={{ $i }} data-id={{ $i }}>&#9733;</li>
                        @endif
                    @endfor
                    <span id="trangthaidanhgia"></span>
                </ul>
                <textarea name="noidung" id="danhgia" cols="30" rows="10" placeholder="Nhập Lời Đánh Giá Của Bạn">{{ $danhgia->noidung }}</textarea>
                <button type="submit" class="btn btn-primary" id="guidanhgia">Đánh giá</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function out() {
            for (let i = 1; i <= 5; i++) {
                $("#" + i).css("color", "#ccc")
            }
        }
        $(document).ready(function() {
            flag = 0;
            $(".star").click(function() {

                out();
                flag = 0;
                var star = $(this).attr("id");
                for (let i = 1; i <= star; i++) {
                    $("#" + i).css("color", "#ffcc00");
                }
                flag = 1;
                switch (star) {
                    case "1":
                        trangthai = "Rất Tệ";
                        $("#trangthaidanhgia").text(trangthai);
                        break;
                    case "2":
                        trangthai = "Tệ";
                        $("#trangthaidanhgia").text(trangthai);
                        break;
                    case "3":
                        trangthai = "Bình Thường";
                        $("#trangthaidanhgia").text(trangthai);
                        break;
                    case "4":
                        trangthai = "Tốt";
                        $("#trangthaidanhgia").text(trangthai);
                        break;
                    case "5":
                        trangthai = "Rất Tốt";
                        $("#trangthaidanhgia").text(trangthai);
                        break;

                }
                var $url = "doisao/" + star;
                $.get($url,
                    function(data) {

                    },
                );
            })
        });
    </script>
@endsection
