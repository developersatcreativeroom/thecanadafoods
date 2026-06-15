<div class="card-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Order No</th>
                <th>Name</th>
                <th>Payment Done</th>
                <th>Order Status</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>Ordered on</th>
                <th style="width: 220px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @if (method_exists($rows, 'links'))
                        <td>{{ ($rows->currentPage() - 1) * $rows->perPage() + $loop->iteration }}</td>
                    @else
                        <td>{{ $loop->iteration }}</td>
                    @endif
                    <td>{{ $row->order_no }}</td>
                    <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                    <td>
                        @if ($row->is_payment_done)
                            <span class="badge bg-success">Done</span>
                        @else
                            <span class="badge bg-danger">Not Done</span>
                        @endif
                    </td>
                    <td><span class="badge bg-info">{{ $row->order_status }}</span></td>
                    <td>{{ $row->amountWithItems() }}</td>
                    <td>@if($row->payment){{$row->currency}}{{ $row->payment->amount }}@endif</td>
                    <td>{{ $row->created_at?->format(App\Helper::universalDateTimeFormat()) ?? '' }}</td>
                    <td>
                        <a href="{{ route('admin.order.view', $row->id) }}" class="btn btn-info btn-sm">View</a>
                        @if ($row->status)
                            <a href="{{ route('admin.order.invoice', $row->id) }}" class="btn btn-primary btn-sm"
                                target="_blank">Invoice</a>
                            <a href="{{ route('admin.order.invoice.download', $row->id) }}"
                                class="btn btn-success btn-sm">Download</a>
                        @endif
                        <!-- <a href="#" class="btn btn-danger btn-sm delete-btn">Delete</a> -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
