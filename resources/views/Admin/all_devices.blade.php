@extends('layouts.admin_master')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Device List
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
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
                        <td>{{ $row['device_name'] }}</td>
                        <td>{{ $row['product_code'] }}</td>
                        <td>{{ $row['device_status'] }}</td>
                        @if($row['is_assigned'] === 1)
                        <td><i class="fas fa-check text-success"></i></td>
                        @else
                        <td><i class="fas fa-times text-danger"></i></td>
                        @endif

                        <td>{{ $row['last_update'] }}</td>

                        <td>
                            <a href="{{ route('device.edit', $row['device_uuid']) }}" class="btn btn-sm btn-primary">Edit</a>
                            <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            <a href="{{ route('assign.device', $row['device_uuid']) }}" class="btn btn-sm btn-success">Re-Assign</a>
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
<script src="{{ asset('backend') }}/js/table-config.js"></script>

@endsection