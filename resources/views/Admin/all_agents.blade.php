@extends('layouts.admin_master')
@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item inactive"><a class="dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">All Agents</li>
</ol>
<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <i class="fa fa-person" aria-hidden="true"></i>
            All Agents
        </div>
        <div>
            <a href="{{ route('add.agent') }}" class="btn btn-md btn-info"><i class="fa fa-md fa-plus"></i> Create Agent</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table display" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Device Count</th>
                        <th>Last Update</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                    <a href=" {{ route('edit.agent', $agent['id']) }}">
                        <tr class="position-relative">
                            <td></td>
                            <td>{{ $agent['name'] }}</td>
                            <td>{{ $agent['address'] }}</td>
                            <td>{{ $agent['phone'] }}</td>
                            <td>{{ $agent['device_count'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($agent['updated_at'])->tz('America/New_York')->toDateTimeString() }}</td>

                            <td>
                                <a href=" {{ route('edit.agent', $agent['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                                <!-- <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</a> -->
                            </td>
                        </tr>
                    </a>
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
                [5, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                render: DataTable.render.select(),
                targets: 0
            }],
            select: {
                style: 'multi'
            },
        });


    });
</script>

@endsection