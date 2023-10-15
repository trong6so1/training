<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Thể Loại Bài Viết</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            {{-- menu 2 cấp --}}
            {{-- <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                            Sportswear
                        </a>
                    </h4>
                </div>
                <div id="sportswear" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul>
                            <li><a href="#">Nike </a></li>
                            <li><a href="#">Under Armour </a></li>
                            <li><a href="#">Adidas </a></li>
                            <li><a href="#">Puma</a></li>
                            <li><a href="#">ASICS </a></li>
                        </ul>
                    </div>
                </div>
            </div> --}}
            @foreach ($theloaibaiviet as $tl)
                @if (count($tl->BaiViet) > 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">

                            @if (count($tl->BaiViet) > 0)
                                <h4 class="panel-title"><a
                                        href="baiviet/{{ $tl->id }}/{{ 1 }}">{{ $tl->tentheloai }}</a>
                                </h4>
                            @endif

                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <!--/category-products-->


    </div>
</div>
