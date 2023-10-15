<div class="col-sm-3">
    <div class="left-sidebar">
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#taikhoan">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            <i class="fa-solid fa-user" id="iconthongbao"></i>Tài Khoản
                        </a>
                    </h4>
                </div>
                <div id="taikhoan" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="thongbao/taikhoan/xemthongtin">Xem Thông Tin </a></li>
                            <li><a href="thongbao/taikhoan/doimatkhau">Đổi Mật Khẩu </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#donhang">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            <i class="fa-solid fa-receipt" id="iconthongbao"></i>Đơn Hàng
                        </a>
                    </h4>
                </div>
                <div id="donhang" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="thongbao/donhang/{{ 0 }}">Đang Chờ Xác Nhận</a></li>
                            <li><a href="thongbao/donhang/{{ 1 }}">Đang Chờ Giao Hàng</a></li>
                            <li><a href="thongbao/donhang/{{ 3 }}">Đơn Hàng Đã Hoàn Thành</a></li>
                            <li><a href="thongbao/donhang/{{ -1 }}">Đơn Hàng Hủy</a></li>
                            <li><a href="thongbao/donhang/danhgia">Đơn Hàng Chưa Đánh Giá</a></li>
                            <li><a href="thongbao/donhang/xemdanhgia">Đơn Hàng Đã Đánh Giá</a></li>
                            <li><a href="thongbao/donhang/tatca">Tất Cả Đơn Hàng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#hienthongbao">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            <i class="fa-solid fa-bell" id="iconthongbao"></i>Thông Báo
                        </a>
                    </h4>
                </div>
                <div id="hienthongbao" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="thongbao/{{ 1 }}">Thông Báo Sự Kiện</a></li>
                            <li><a href="thongbao/{{ 2 }}">Thông Báo Cá Nhân</a></li>
                            <li><a href="thongbao/{{ 3 }}">Voucher</a></li>
                            <li><a href="thongbao/tatca">Tất Cả</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div><!--/category-products-->
    </div>
</div>
