<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Danh Mục Sản Phẩm</h2>
        <div class="panel-group category-products" id="accordian"><!--category-productsr-->
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
                @foreach ($danhmuc as $dm)
                    @if (count($dm->SanPham)>0)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="danhmuc/{{ $dm->id }}/{{ 1 }}">{{ $dm->TenDanhMuc }}({{ count($dm->SanPham) }})</a></h4>
                            </div>
                        </div>  
                    @endif
                @endforeach
        </div><!--/category-products-->


    </div>
</div>
