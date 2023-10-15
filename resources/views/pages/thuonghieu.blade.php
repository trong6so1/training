
@extends('layout.main')
@section('content')
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#slider-carousel" data-slide-to="1"></li>
                        <li data-target="#slider-carousel" data-slide-to="2"></li>
                    </ol>
                    
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Free E-Commerce Template</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="front-end/images/home/girl1.jpg" class="girl img-responsive" alt="" />
                                <img src="front-end/images/home/pricing.png"  class="pricing" alt="" />
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>100% Responsive Design</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="front-end/images/home/girl2.jpg" class="girl img-responsive" alt="" />
                                <img src="front-end/images/home/pricing.png"  class="pricing" alt="" />
                            </div>
                        </div>
                        
                        <div class="item">
                            <div class="col-sm-6">
                                <h1><span>E</span>-SHOPPER</h1>
                                <h2>Free Ecommerce Template</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                <button type="button" class="btn btn-default get">Get it now</button>
                            </div>
                            <div class="col-sm-6">
                                <img src="front-end/images/home/girl3.jpg" class="girl img-responsive" alt="" />
                                <img src="front-end/images/home/pricing.png" class="pricing" alt="" />
                            </div>
                        </div>
                        
                    </div>
                    
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            @include('layout.menu')
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">{{ $tenthuonghieu->TenThuongHieu }}</h2>
                        @foreach ($sanphamtheothuonghieu as $sptth)
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <a href="chitietsanpham/{{ $sptth->id }}">
                                            <div class="productinfo text-center">
                                                <img src="upload/sanpham/{{ $sptth->Hinh }}" width="250px" height="250px" alt="" />
                                                <h2>{{ number_format($sptth->Gia).' VNĐ' }}</h2>
                                                <div><a href="chitietsanpham/{{ $sptth->id }}">{{ $sptth->TenSanPham }}</a></div>
                                                <a href="giohang/themvaogio/{{ $sptth->id }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm Vào Giỏ Hàng</a>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="#"><i class="fa fa-plus-square"></i>Yêu Thích</a></li>
                                            <li><a href="#"><i class="fa fa-plus-square"></i>So Sánh</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div><!--features_items-->
            </div>
        </div>
    </div>
</section>   
@endsection	

	
