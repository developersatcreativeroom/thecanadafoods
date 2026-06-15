<div class="row g-4 justify-content-center">
    @foreach($products as $product)
        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
            {!! App\Helper::getProductHtml($product) !!}
        </div>
    @endforeach
</div>
<!--pagination-->
{{-- <ul class="template-pagination d-flex align-items-center mt-6">
    <li><a href="#" class="active">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#"><i class="fas fa-arrow-right"></i></a></li>
</ul> --}}
<div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
    {!! $products->withQueryString()->links() !!}
</div>