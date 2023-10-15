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
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Đánh Giá
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Người Đánh Giá</th>
                        <th>Số Sao</th>
                        <th>Nội Dung Đánh Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="upload/sanpham/{{ $danhgia->ChiTiet->SanPham->Hinh }}" class="imgad" alt=""></td>
                        <td>{{ $danhgia->ChiTiet->SanPham->TenSanPham }}</td>
                        <td>{{ $danhgia->madon }}</td>
                        <td>{{ $danhgia->NguoiDang->tennguoidung }}</td>
                        <td class="sosao">
                            <span class="danhgiasanpham">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($danhgia->sosao >= $i)
                                        <i class="fa fa-star color"></i>
                                    @else
                                        <i class="fa fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                        </td>
                        <td>{{ $danhgia->noidung }}</td>
                    </tr>
                </tbody>
            </table>
            <div>
                <div class="form">
                    <form class="cmxform form-horizontal" action="admin/danhgia/traloidanhgia/{{ $danhgia->id }}"
                        id="commentForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group ">
                            <label for="cname" class="control-label col-lg-3">Viết Câu Trả Lời</label>
                            <div class="col-lg-9">
                                <textarea name="noidung" class="form-control" cols="30" rows="10"
                                    placeholder="Vui Lòng Nhập Câu Trả Lời Của Bạn"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-lg-6">
                                <button class="btn btn-primary" type="submit">Trả Lời</button>
                                <button class="btn btn-default" type="button">Hủy</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
@endsection
