@extends('layouts.admin_master')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        All Devices
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Product Code</th>
                        <th>Status</th>
                        <th>Assignee</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devices as $row)
                    <tr>
                        <td>{{ $row['device_name'] }}</td>
                        <td>{{ $row['product_code'] }}</td>
                        <td>{{ $row['device_status'] }}</td>
                        <td>{{ $row['assignee'] }}</td>
                        <td>{{ $row['last_update'] }}</td>

                        <td>
                            <a href="#" class="btn btn-sm btn-info">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            <a href="{{ 'purchase-products/' . $row['device_uuid'] }}" class="btn btn-sm btn-info">Purchase</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')

<script>
    $('#dataTable').DataTable({
        columnDefs: [{
            bSortable: false,
            targets: [6]
        }],
        dom: 'lBfrtip',
        buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, ':visible']

                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 5]
                }
            },
            'colvis', 'csv'
        ]
    });
</script>
@endsection