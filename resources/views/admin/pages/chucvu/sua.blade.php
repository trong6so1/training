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
        Sửa Chức Vụ
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST" action="admin/chucvu/sua/{{ $chucvu->id }}"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Tên Chức Vụ</label>
                    <div class="col-lg-9">
                        <input class=" form-control" value="{{ $chucvu->tenchucvu }}" name="tenchucvu" type="text">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Mô Tả Chức Vụ</label>
                    <div class="col-lg-9">
                        <textarea name="motachucvu" class="form-control" cols="66" rows="10">{{ $chucvu->motachucvu }}</textarea>
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
