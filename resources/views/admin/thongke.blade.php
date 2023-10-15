@extends('admin.layout')
@section('content')
    <?php
    $data = $thongkedoanhthu;
    ?>
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
        <div class="form-group ">
            <form action="admin/thongke" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label>Xem Doanh Thu Theo Ngày:</label>
                <input type="date" class="form-thongke" name="ngaydau" id="">
                <input type="submit" class="btn btn-success" value="Xem Doanh Thu">
                <input type="date" class="form-thongke" name="ngaycuoi">
            </form>
        </div>
        @if (count($sosanh) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    So Sánh Doanh Thu
                </div>
            </div>
            <div id="sosanh" data-sosanh="{{ $sosanh }}"></div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">
                Thống Kê Doanh Thu
            </div>
        </div>
        <div style="display: flex;flex-direction: row">
            <div id="thongkedoanhthu" data-doanhthu="{{ $thongkedoanhthu }}">
            </div>
            <div>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Hình Thức Thanh Toán</th>
                            <th>Số Lượng Bán Ra</th>
                            <th>Tổng Tiền Bán Ra</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $tongtien = 0; ?>
                        @foreach ($thongkedoanhthu as $tk)
                            <tr>
                                <td>
                                    @if ($tk->hinhthucthanhtoan == 1)
                                        {{ 'Trả Sau' }}
                                    @elseif ($tk->hinhthucthanhtoan == 2)
                                        {{ 'MoMo' }}
                                    @endif
                                </td>
                                <td>{{ $tk->soluong }}</td>
                                <?php
                                $tongtien += $tk->tongtien;
                                ?>
                                <td>{{ number_format($tk->tongtien) . ' VNĐ' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">Tổng Doanh Thu</td>
                            <td>{{ number_format($tongtien) . ' VNĐ' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thống Kê Đồ Uống
            </div>
        </div>
        <div class="table-responsive">
            @if (count($thongkedouong) > 0)
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Mã Sản Phẩm</th>
                            <th>Tên Sản Phẩm</th>
                            <th></th>
                            <th>Số Lượng Bán Ra</th>
                            <th>Tổng Tiền Bán Ra</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($thongkedouong as $tk)
                            <tr>
                                <td>{{ $tk->idsanpham }}</td>
                                <td>{{ $tk->SanPham->TenSanPham }}</td>
                                <td>
                                    <img src="upload/sanpham/{{ $tk->SanPham->Hinh }}" width="150px" height="150px">
                                </td>
                                <td>{{ $tk->soluong }}</td>
                                <td>{{ number_format($tk->tongtien).' VND' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h2>Không Có Đơn Hàng</h2>
            @endif
        </div>
    </div>


@endsection
@section('script')
    <script>
        let colors = [
            '#E0F7FA',
            '#B2EBF2',
            '#80DEEA',
            '#4DD0E1',
            '#26C6DA',
            '#00BCD4',
            '#00ACC1',
            '#0097A7',
            '#00838F',
            '#006064'
        ];
        let tk = [];
        var data = $("#thongkedoanhthu").data("doanhthu");
        for (let $i = 0; $i < data.length; $i++) {
            var hinhthuc = "";
            if (data[$i]['hinhthucthanhtoan'] == 1) {
                hinhthuc = 'Trả Sau';
            } else if (data[$i]['hinhthucthanhtoan']) {
                hinhthuc = "MoMo";
            }
            let thongke = {
                'label': hinhthuc,
                'value': data[$i]['tongtien'],
                'color': colors[$i]
            }
            tk.push(thongke);

        }
        var colorDanger = "#FF1744";
        Morris.Donut({
            element: 'thongkedoanhthu',
            resize: true,
            //labelColor:"#cccccc", // text color
            //backgroundColor: '#333333', // border color
            data: tk
        });
    </script>
    <script>
        let sosanh = [];
        var data = $("#sosanh").data("sosanh");
        for (let $i = 0; $i < data.length; $i++) {
            let thongke = {
                y: data[$i]['Date(giogiao)'],
                a: data[$i]['tongtien'],
            }
            sosanh.push(thongke);

        }
        Morris.Bar({
            element: 'sosanh',

            data: sosanh,
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Doanh Thu']
        });
    </script>
@endsection
