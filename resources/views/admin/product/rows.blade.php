              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th>Temp Sensitive</th>
                      <th>Status</th>
                      <th>Meta Status</th>
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
                          <img class="img-fluid img-thumbnail" style="width: 100px" src="{{ asset('storage/products/') }}/{{$row->id}}/{{$row->image}}" />
                        </div>
                      @endif
                      </td>
                      <td>{{$row->getPrice()}}</td>
                       <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="nav-toggle"
                                                            data-id="{{ $row->id }}"
                                                             data-col="temp_sensitive"
                                                            {{ $row->temp_sensitive ? 'checked' : '' }}>
                                                        <span class="slider"></span>
                                                    </label>
                                                </td>
                      <td>
                        @if($row->status)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">In-active</span>
                        @endif
                      </td>
                      <td> {!! App\Helper::metaStatus($row) !!} </td>
                      <td>{{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                      <td>
                        <a href="{{route('admin.product.edit', $row->id)}}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="{{route('admin.product.delete', $row->id)}}" class="btn btn-danger btn-sm delete-btn">Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              