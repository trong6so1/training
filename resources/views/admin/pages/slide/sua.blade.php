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
        Sửa Slide
    </header>
    <div class="panel-body">
        <div class=" form">
            <form class="cmxform form-horizontal " id="commentForm" method="POST" action="admin/slide/sua/{{ $slide->id }}"
                enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group ">
                    <label for="cname" class="control-label col-lg-3">Ảnh</label>
                    <div class="col-lg-9" id="sanpham">
                        <img src="upload/slide/{{ $slide->anh }}" id="imgsanpham" alt="">
                        <input class=" form-control" name="anh" id="fileanhsanpham" type="file">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button class="btn btn-primary" type="submit">Sửa</button>
                        <button class="btn btn-default" type="button">Hủy</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#fileanhsanpham").change(function() {
                if ($("#fileanhsanpham").val() != "") {
                    var input = document.getElementById("fileanhsanpham");
                    var fReader = new FileReader();
                    fReader.readAsDataURL(input.files[0]);
                    fReader.onloadend = function(event) {
                        if ($("#imgsanpham")) {
                            $("#imgsanpham").remove();
                        }
                        $("#sanpham").prepend(
                            `<img id='imgsanpham' src=${event.target.result} width='800' height = '600'>`
                            );
                    }
                } else {
                    if ($("#imgsanpham")) {
                        $("#imgsanpham").remove();
                    }
                }
            });
        });
    </script>
@endsection
