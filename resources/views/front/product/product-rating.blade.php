
<h3 class="section-title style-1 @if(count($product->ratings) <= 0) no-bottom-border @endif mb-30 mt-30">Reviews ({{count($product->ratings)}})</h3>
@if(count($product->ratings) > 0)
    <!--Comments-->
    <div class="comments-area style-2">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-30">Customer submitted reviews</h4>
                <div class="comment-list">
                    @foreach($product->ratings as $rating)
                    <div class="single-comment justify-content-between d-flex">
                        <div class="user justify-content-between d-flex">
                            <div class="thumb text-center">
                                <!-- <img src="assets/imgs/page/avatar-6.jpg" alt=""> -->
                                <h6><a href="#">{{$rating->name}}</a></h6>
                                <!-- <p class="font-xxs">Since 2012</p> -->
                            </div>
                            <div class="desc">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:{{$rating->rating_percentage}}%">
                                    </div>
                                </div>
                                <p>{{$rating->review}}</p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <p class="font-xs mr-30">{{$rating->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}} </p>
                                        <!-- <a href="#" class="text-brand btn-reply">Reply <i class="fi-rs-arrow-right"></i> </a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- <div class="single-comment justify-content-between d-flex">
                        <div class="user justify-content-between d-flex">
                            <div class="thumb text-center">
                                <img src="assets/imgs/page/avatar-7.jpg" alt="">
                                <h6><a href="#">Ana Rosie</a></h6>
                                <p class="font-xxs">Since 2008</p>
                            </div>
                            <div class="desc">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width:90%">
                                    </div>
                                </div>
                                <p>Great low price and works well.</p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <p class="font-xs mr-30">December 4, 2022 at 3:12 pm </p>
                                        <a href="#" class="text-brand btn-reply">Reply <i class="fi-rs-arrow-right"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    
                </div>
            </div>

            <!-- <div class="product__rating">
                <div class="product__rating-stars">
                    <div class="rating">
                    <div class="rating__body">
                        @for($i = 0; $i < $product->average_rating_floor; $i++ )
                        <div class="rating__star rating__star--active"></div>
                        @endfor
                        @for($i = 0; $i < (5 - $product->average_rating_floor); $i++ )
                        <div class="rating__star"></div>
                        @endfor                                                      
                    </div>
                    </div>
                </div>
                <div class="product-card__rating-label">{{$product->average_rating}} on {{$product->total_rating}} @if($product->total_rating > 1) reviews @else review @endif</div>
            </div> -->


            <div class="col-lg-4">
                <h4 class="mb-30">Customer @if($product->total_rating > 1) reviews @else review @endif</h4>
                <div class="d-flex mb-30">
                    <div class="product-rate d-inline-block mr-15">
                        <div class="product-rating" style="width:{{$product->average_rating_percentage}}%">
                        </div>
                    </div>
                    <h6>{{$product->average_rating}} out of 5</h6>
                </div>
                <div class="progress">
                    <span>5 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
                <div class="progress">
                    <span>4 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <div class="progress">
                    <span>3 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                </div>
                <div class="progress">
                    <span>2 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                </div>
                <div class="progress mb-30">
                    <span>1 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                </div>
                
            </div>
        </div>
    </div>
    @endif