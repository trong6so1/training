"<div class='col-sm-4'><div class='product-image-wrapper'><div class='single-products'><a href='chitietsanpham/".$sp->id."'><div class='productinfo text-center'><img src='upload/sanpham/". $sp->Hinh."'/><span class='text_product'>". $sp->TenSanPham ."</span><span class='text_product2'>". number_format($sp->Gia) . ' VNĐ' ."</span></div></a></div></div></div>"
        
<div class='choose'>
            <ul class='nav nav-pills nav-justified'>
                <li><a href='giohang/themvaogio/{{ $sp->id }}'><i
                            class='fa fa-shopping-cart'></i>Thêm Vào Giỏ Hàng</a></li>
                <li><a href='muangay/{{ $sp->id }}'><i
                            class='fa-solid fa-sack-dollar'></i>Mua Ngay</a></li>
            </ul>
        </div>
    </div>
</div>"