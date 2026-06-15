@forelse ($ratings as $k=>$rating)  
    <div class="users_review mt-4">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            <div class="top-left d-flex align-items-center">
                <div class="review__icon"> {{ substr($rating->name, 0, 1) }}</div>
                <div class="ms-3">
                    <h6 class="mb-1">{{$rating->name}} <span class="badge text-bg-secondary text-white verified-badge">Verified By Shop</span></h6> 
                    <span>{{$rating->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <span class="ti text-warning" style="--rating:{{$rating->rating}}"></span>
            </div>
        </div>
        <p class="mt-3 mb-0">{{$rating->review}}</p>
    </div>
    <hr>
@empty
    <p class="text-center" >No record found.</p>
@endforelse
@if ($ratings->count())
    <div class="mt-3">
        {{ $ratings->appends(request()->except('page'))->links() }}
    </div>
@endif
