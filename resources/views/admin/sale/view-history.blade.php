<h5>Order Status History</h5>
							<hr>

								<!-- The time line -->
								<div class="timeline">
									<!-- timeline time label -->
									<div class="time-label">
										<span class="bg-green">{{$row->created_at?->format(App\Helper::universalDateFormat()) ?? ''}}</span>
									</div>
									<!-- /.timeline-label -->

									@foreach($row->history as $history)
										<!-- timeline item -->
										<div>
											<i class="fas fa-info bg-blue"></i>
											<div class="timeline-item">
											<span class="time"><i class="fas fa-clock"></i> {{$history->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</span>
											<h3 class="timeline-header no-border"><a>{{$history->status}}</a></h3>

											@if($history->note != null)
												<div class="timeline-body">
													{{$history->note}}
												</div>
											@endif

											</div>
										</div>
										<!-- END timeline item -->
									@endforeach

									<!-- timeline item -->
									<!-- <div>
										<i class="fas fa-info bg-blue"></i>
										<div class="timeline-item">
										<span class="time"><i class="fas fa-clock"></i> 12:05</span>
										<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

										<div class="timeline-body">
											Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
											weebly ning heekya handango imeem plugg dopplr jibjab, movity
											jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
											quora plaxo ideeli hulu weebly balihoo...
										</div>
										</div>
									</div> -->
									<!-- END timeline item -->

									<!-- timeline item -->
									<!-- <div>
										<i class="fas fa-user bg-green"></i>
										<div class="timeline-item">
										<span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
										<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
										</div>
									</div> -->
									<!-- END timeline item -->
								
									
										<div>
											<i class="fas fa-clock bg-gray"></i>
										</div>
									</div>
									<!-- /.timeline -->