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
        Sửa Thương Hiệu
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST"
                action="admin/thuonghieu/chinhsua/{{ $thuonghieu->id }}" novalidate="novalidate" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tên Thương Hiệu</label>
                    <div class="col-lg-6">
                        <input class=" form-control" id="cname" name="TenThuongHieu" type="text"
                            value="{{ $thuonghieu->TenThuongHieu }}">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Mô Tả</label>
                    <div class="col-lg-6">
                        <textarea rows="5" class="form-control ckeditor" id="ccomment" name="MoTa" required="">{{ $thuonghieu->MoTa }}</textarea>
                    </div>
                </div>
                <div class="form-group ">
                    <label for="ccomment" class="control-label col-lg-3">Hiển Thị:</label>
                    <div class="col-lg-6">
                        <input @if ($thuonghieu->Hien === 1) {{ 'checked' }} @endif type="radio" name="Hien"
                            id="" value="1">Hiện
                        <input @if ($thuonghieu->Hien === 0) {{ 'checked' }} @endif type="radio" name="Hien"
                            value="0">Ẩn

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-6">
                        <button class="btn btn-primary" type="submit">Sửa</button>
                        <button class="btn btn-default" type="button">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
