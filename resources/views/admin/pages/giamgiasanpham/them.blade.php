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
    <header class="panel-heading">
        Thêm Sản Phẩm Giảm Giá
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST" action="admin/giamgiasanpham/them"
                novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Danh Mục Sản Phẩm:</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="idDanhMuc" id="madanhmuc">
                            @foreach ($danhmuc as $dm)
                                <option @if ($dm->id == $danhmucdau) {{ 'selected' }} @endif
                                    value="{{ $dm->id }}">{{ $dm->TenDanhMuc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cname" class="control-label col-lg-3">Tên Sản Phẩm:</label>
                    <div class="col-lg-6">
                        <select class="form-control" id="masanpham" name="masanpham">
                            <option value="{{ null }}">--Chọn Sản Phẩm--</option>
                            @foreach ($sanpham as $sp)
                                <option value="{{ $sp->id }}" img="{{ $sp->Hinh }}">{{ $sp->TenSanPham }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group " id="giakhuyenmai">
                    <label for="ccomment" class="control-label col-lg-3">Giá Khuyến Mãi</label>
                    <div class="col-lg-6">
                        <input class="form-control" id="cname" name="giakhuyenmai" type="number" min="1">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Số Lượng:</label>
                    <div class="col-lg-6">
                        <input class=" form-control" id="cname" name="soluong" type="number" min="1">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Hiển Thị:</label>
                    <div class="col-lg-6">
                        <input type="radio" name="hienthi" value=0>Ẩn
                        <input type="radio" name="hienthi" value=1>Hiện

                    </div>
                </div>

                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tiêu Đề:</label>
                    <div class="col-lg-6">
                        <textarea rows="5" class="form-control" id="ccomment" name="tieude"></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Nội Dung Khuyến Mãi:</label>
                    <div class="col-lg-6">
                        <textarea rows="5" class="form-control ckeditor" id="ccomment" name="noidung"></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Ngày Bắt Đầu:</label>
                    <div class="col-lg-6">
                        <input class="form-control" id="cname" name="ngaybatdau" type="datetime-local">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Ngày Kết Thúc:</label>
                    <div class="col-lg-6">
                        <input class="form-control" id="cname" name="ngayketthuc" type="datetime-local">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <button class="btn btn-primary" type="submit">Thêm</button>
                        <button class="btn btn-default" type="button">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $("#masanpham").change(function(e) {
            var masanpham = $("#masanpham").val();
            var img = $('option:selected', this).attr('img');
            if (masanpham != "") {
                if ($("#giagoc")) {
                    $("#giagoc").remove();
                    $("#imgsanpham").remove();
                }
                $.get("admin/giamgiasanpham/timgiasanpham/" + masanpham,
                    function(data) {
                        text =
                            "<div class='form-group' id='giagoc'><label for='ccomment' class='control-label col-lg-3'>Giá Gốc</label><div class='col-lg-6' ><input name='giagoc' class='form-control' id='cname' readonly type='number' value=" +
                            data + "></div></div>"
                        $("#giakhuyenmai").before(text);
                    },
                );
                var imgsanpham = "<img src='upload/sanpham/" + img +
                    "'width ='280px' height='250px' id='imgsanpham'>";
                $("#masanpham").before(imgsanpham);
            } else {
                $("#giagoc").remove();
                $("#imgsanpham").remove();
            }
        });
        $("#madanhmuc").change(function(e) {
            $("#giagoc").remove();
            $("#imgsanpham").remove();
            var madanhmuc = Number($("#madanhmuc").val());
            var listsanpham = "<option value=" + null + ">--Chọn Sản Phẩm--</option>"
            $.get("admin/giamgiasanpham/timsanpham/" + madanhmuc,
                function(data) {
                    data.forEach(dt => {
                        listsanpham += "<option value=" + dt['id'] + " img='" + dt['Hinh'] + "'>" + dt[
                            'TenSanPham'] + "</option>";
                    });
                    $("#masanpham").html(listsanpham);
                },
            );

        })
    </script>
@endsection
