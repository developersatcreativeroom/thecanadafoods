              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Rating</th>
                      <th>Description</th>
                      <th>Status</th>
                      <th>Added on</th>
                      <th style="width: 130px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
					        @foreach($rows as $row)
                    <tr>
                      @if(method_exists($rows, 'links'))
                        <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                      @else
                        <td>{{ $loop->iteration }}</td>
                      @endif
                      <td>{{$row->name}}</td>
                      <td> 
                        @if(!empty($row) && ($row->image != null || $row->image != '' ))
                          <div class="">
                            <img class="img-fluid img-thumbnail" style="width: 100px" src="{{ asset('storage/testimonials/') }}/{{$row->id}}/{{$row->image}}" />
                          </div>
                        @endif
                      </td>
                      <td>{{$row->rating}} stars</td>
                      <td>{{$row->description}}</td>
                      <td>
                        @if($row->status)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">In-active</span>
                        @endif
                      </td>
                      <td>{{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                      <td>
                        <a href="{{route('admin.testimonial.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{route('admin.testimonial.delete', $row->id)}}" class="btn btn-danger btn-sm delete-btn">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->