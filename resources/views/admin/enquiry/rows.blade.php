
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Enquiry No</th>
                      <th>Name</th>
                      <th>Enquiry Status</th>
                      <th>Total</th>
                      <th>Enquired on</th>
                      <th style="width: 160px">Actions</th>
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
                      <td>{{$row->enquiry_no}}</td>
                      <td>{{$row->first_name}} {{$row->last_name}}</td>
                      <td><span class="badge bg-info">{{$row->enquiry_status}}</span></td>
                      <td>{{$row->amountWithItems()}}</td>
                      <td>{{$row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? ''}}</td>
                      <td>
                        <a href="{{route('admin.enquiry.view', $row->id)}}" class="btn btn-info btn-sm">View</a>
                        <!-- <a href="#" class="btn btn-danger btn-sm delete-btn">Delete</a> -->
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              