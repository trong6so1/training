@extends('layout.main')
@section('content')
    <section>
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="trangchu">Trang Chủ</a></li>
                    <li class="active">Tin Tức</li>
                </ol>
            </div>
            <div class="row">
                @include('layout.theloaibaiviet')
                <div class="col-sm-9">
                    <div class="blog-post-area">
                        @if (isset($theloai))
                            <h2 class="title text-center">{{ $theloai->tentheloai }}</h2>
                        @else
                            <h2 class="title text-center">Bài Viết Mới Nhất</h2>
                        @endif
                        @foreach ($baiviet as $bv)
                            <div class="single-blog-post">
                                <h3>{{ $bv->tenbaiviet }}</h3>
                                <div class="post-meta">
                                    <ul>
                                        <?php
                                        $ngaydang = $bv->ngaydang;
                                        $ngaydang = explode(' ', $ngaydang);
                                        ?>
                                        <li><i class="fa fa-clock-o"></i> {{ $ngaydang[1] }}</li>
                                        <li><i class="fa fa-calendar"></i> {{ $ngaydang[0] }}</li>
                                    </ul>
                                </div>
                                <a href="chitietbaiviet/{{ $bv->id }}">
                                    <img src="upload/anhbaiviet/{{ $bv->anhbaiviet }}" alt="">
                                </a>
                                <div>{!! $bv->tomtat !!}</div>
                                <a class="btn btn-primary" href="chitietbaiviet/{{ $bv->id }}">Đọc Thêm</a>
                            </div>
                        @endforeach

                        <div class="pagination-area">
                            <ul class="pagination">
                                <?php
                                    $sobaiviet % 5 ==0? $sobaiviet/5 : $sobaiviet/5+1;    
                                ?>
                                @for($i = 1;$i<=$sobaiviet;$i++)
                                    <li><a
                                            @if (isset($theloai))
                                                href="baiviet/{{ $theloai->id }}/{{ $i }}"
                                            @else
                                                href="baiviet/{{ $i }}"
                                            @endif                                        
                                        class="active">{{ $i }}</a></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
