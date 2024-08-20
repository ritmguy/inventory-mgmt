@extends('layouts.admin_master')
@section('content')
<main>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">All Devices</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fa-sharp fa-laptop mr-1"></i>
            Device List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Device Type/Category</th>
                            <th>Device Name</th>
                            <th>Product Code</th>
                            <th>Status</th>
                            <th>Assigned</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devices as $row)
                        <tr>
                            <td>{{ $row['category'] }}</td>
                            <td>{{ $row['device_name'] }}</td>
                            <td>{{ $row['product_code'] }}</td>
                            <td>{{ $row['device_status'] }}</td>
                            @if($row['is_assigned'] === 1)
                            <td><i class="fas fa-check text-success"></i></td>
                            @else
                            <td><i class="fas fa-times text-danger"></i></td>
                            @endif

                            <td>{{ \Carbon\Carbon::parse($row['updated_at'])->tz('America/New_York')->toDateTimeString() }}</td>

                            <td>
                                <a href="{{ route('device.edit', $row['unique_id']) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                <a href="{{ route('assign.device', $row['unique_id']) }}" class="btn btn-sm btn-success">Re-Assign</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
@section('script')
<script>
    $(document).ready(function() {

        // Call the dataTables jQuery plugin
        $('#dataTable').DataTable({
            order: [
                [1, 'asc']
            ]
        });


    });
</script>

@endsection