@extends('layouts.admin_master')
@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item inactive"><a class="dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">All Statuses</li>
</ol>
<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <i class="fas fa-check-double" aria-hidden="true"></i>
            Status List
        </div>
        <div>
            <a href="{{ route('add.status.view') }}" class="btn btn-md btn-info"><i class="fa fa-md fa-plus"></i> Create Status</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Active</th>
                        <th>Created On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $status)

                    <tr class="position-relative">
                        <td>{{ $status['name'] }}</td>
                        <td>{{ $status['type'] }}</td>
                        @if($status['is_active'] === 1)
                        <td><i class="fa fa-md fa-circle-check text-success"></i></td>
                        @else
                        <td><i class="fa fa-md fa-ban text-danger"></i></td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($status['created_at'])->tz('America/New_York')->toDateTimeString() }}</td>

                        <td>
                            <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-md fa-times"></i> Delete</a>
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
    $(document).ready(function() {

        // Call the dataTables jQuery plugin
        $('#dataTable').DataTable({
            order: [
                [1, 'asc'],
                [0, 'asc']
            ],
            columnDefs: [{
                targets: [2],
                className: 'dt-center'
            }],
        });


    });
</script>

@endsection