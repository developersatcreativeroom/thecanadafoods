

                  @if(count($rows) > 0)
                  <!-- The time line -->
                  <div class="timeline">
                  <!-- timeline time label -->
									<div class="time-label">
										<span class="bg-green"></span>
									</div>
									<!-- /.timeline-label -->

                    @foreach($rows as $inventoryLog)
                      <!-- timeline item -->
                      <div>
                      @if($inventoryLog->event == 'added')
                        <i class="fas fa-plus-circle bg-green"></i>
                      @elseif($inventoryLog->event == 'initial_added')
                        <i class="fas fa-plus-circle bg-info"></i>
                      @elseif($inventoryLog->event == 'reduced')
                        <i class="fas fa-minus-circle bg-red"></i>
                      @elseif($inventoryLog->event == 'sold')
                        <i class="fas fa-shopping-cart bg-blue"></i>
                      @else
                        <i class="fas fa-info bg-gray"></i>
                      @endif


                        <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> {{$inventoryLog->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</span>
                        <h3 class="timeline-header no-border">
                            <a href="#" >{{$inventoryLog->remarks}}</a>
                            <!-- sent you an email -->
                        </h3>

                        
                          <div class="timeline-body">
                            @if($inventoryLog->event == 'sold')
                            Total of <strong>{{count($inventoryLog->products)}}</strong> product(s) sold which are:<br> 
                              @foreach($inventoryLog->products as $product)
                                <a href="{{route('product',$product->slug)}}" target="_blank">{{$product->name}} (Qty: {{$product->quantity}})

                                @if($product->is_variant && $product->attribute)
                                    @if(isset($product->attribute->details))
                                        <div>
                                            @foreach($product->attribute->details as $detail)
                                            <strong>{{$detail->attribute_name}}: </strong>{{$detail->attribute_value}}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                                </a><br>
                              @endforeach
                            @endif

                            @if($inventoryLog->event == 'initial_added')
                            Following fresh product added:<br> 
                              @foreach($inventoryLog->products as $product)
                                <a href="{{route('product',$product->slug)}}" target="_blank"> {{$product->name}} (Initial Quantity Added: {{$product->quantity}})

                                @if($product->is_variant && $product->attribute)
                                    @if(isset($product->attribute->details))
                                        <div>
                                            @foreach($product->attribute->details as $detail)
                                            <strong>{{$detail->attribute_name}}: </strong>{{$detail->attribute_value}}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif

                                </a><br>
                              @endforeach
                            @endif

                            @if($inventoryLog->event == 'added')
                            Following product quantity added:<br> 
                              @foreach($inventoryLog->products as $product)
                                <a href="{{route('product',$product->slug)}}" target="_blank"> {{$product->name}} (Quantity Added: {{$product->quantity}})

                                @if($product->is_variant && $product->attribute)
                                    @if(isset($product->attribute->details))
                                        <div>
                                            @foreach($product->attribute->details as $detail)
                                            <strong>{{$detail->attribute_name}}: </strong>{{$detail->attribute_value}}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                                </a><br>
                              @endforeach
                            @endif

                            @if($inventoryLog->event == 'reduced')
                            Following product quantity reduced:<br> 
                              @foreach($inventoryLog->products as $product)
                                <a href="{{route('product',$product->slug)}}" target="_blank"> {{$product->name}} (Quantity Reduced: -{{$product->quantity}})

                                @if($product->is_variant && $product->attribute)
                                    @if(isset($product->attribute->details))
                                        <div>
                                            @foreach($product->attribute->details as $detail)
                                            <strong>{{$detail->attribute_name}}: </strong>{{$detail->attribute_value}}
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                                </a><br>
                              @endforeach
                            @endif

                            @if($inventoryLog->note)
                              <p class="mb-0"><strong>Note: </strong>{{$inventoryLog->note}}</p>
                            @endif

                          </div>

                          <div class="timeline-footer">
                         
                            @if($inventoryLog->order_id != null)
                            <a class="btn btn-primary btn-sm" target="_blank" href="{{route('admin.order.view', $inventoryLog->order_id)}}">Order Details</a>
                            @endif

                            
                          </div>
                        

                        </div>
                      </div>
                      <!-- END timeline item -->
                  
                      @endforeach

                      <div>
                        <i class="fas fa-clock bg-gray"></i>
                      </div>

                    </div>
                    <!-- /.timeline -->
                    @else

                    <div class="text-center">
                      <p>No Timeline found yet</p>
                    </div>

                    @endif
                    