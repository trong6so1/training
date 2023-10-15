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
        Thêm Mã Khuyến Mãi
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST" action="admin/khuyenmai/them"
                novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Mã Khuyến Mãi</label>
                    <div class="col-lg-6">
                        <input class="form-control" id="cname" name="makhuyenmai" type="text">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Nội Dung</label>
                    <div class="col-lg-6">
                        <textarea rows="5" class=" form-control" id="ckeditor" name="noidung" required=""></textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Số Lượng</label>
                    <div class="col-lg-6">
                        <input class="form-control" min="1" id="cname" name="soluong" type="number">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Hình Thức Khuyến Mãi</label>
                    <div class="col-lg-6">
                        <select name="loaikhuyenmai" class="form-control">
                            <option value="{{ null }}">--Chọn Hình Thức--</option>
                            <option value=1>Khuyến Mãi Theo Phần Trăm</option>
                            <option value=2>Khuyến Mãi Theo Số Tiền</option>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Giá Trị</label>
                    <div class="col-lg-6">
                        <input class="form-control" min="1" id="cname" name="giatri" type="number">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Ngày Bắt Đầu</label>
                    <div class="col-lg-6">
                        <input class="form-control" id="cname" name="ngaybatdau" type="datetime-local">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Ngày Kết Thúc</label>
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
@section('')
@endsection
