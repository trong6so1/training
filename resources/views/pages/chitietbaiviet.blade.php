@extends('layout.main')
@section('content')
    <section>
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="trangchu">Trang Chủ</a></li>
                    <li><a href="baiviet/{{ $baiviet->TheLoaiBaiViet->id }}/{{ 1 }}">{{ $baiviet->TheLoaiBaiViet->tentheloai }}</a>
                    </li>
                    <li class="active">Giỏ Hàng</li>
                </ol>
            </div>
            <div class="row">
                @include('layout.theloaibaiviet')
                <div class="col-sm-9">
                    <div class="blog-post-area">
                        <h2 class="title text-center">{{ $baiviet->tenbaiviet }}</h2>
                        <img src="upload/anhbaiviet/{{ $baiviet->anhbaiviet }}" class="imgbaiviet">
                        <div class="single-blog-post">
                            <div class="post-meta">
                                <ul>
                                    <?php
                                    $ngaydang = $baiviet->ngaydang;
                                    $ngaydang = explode(' ', $ngaydang);
                                    ?>
                                    <li><i class="fa fa-clock-o"></i> {{ $ngaydang[1] }}</li>
                                    <li><i class="fa fa-calendar"></i> {{ $ngaydang[0] }}</li>
                                </ul>
                            </div>
                            {!! $baiviet->noidung !!}
                        </div>
                    </div>
                    <!--/blog-post-area-->
                </div>
            </div>
        </div>
    </section>
@endsection
