@extends('layouts.admin_master')
@section('content')

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item inactive"><a class="dark:text-gray-400 dark:hover:text-white" href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">All Agents</li>
</ol>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-contact-card" aria-hidden="true"></i>
        All Agents
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
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

                    <tr class="position-relative">
                        <td>{{ $agent['name'] }}</td>
                        <td>{{ $agent['address'] }}</td>
                        <td>{{ $agent['phone'] }}</td>
                        <td>{{ $agent['device_count'] }}</td>
                        <td>{{ $agent['updated_at'] }}</td>

                        <td>
                            <a href=" {{ route('edit.agent', $agent['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>
                            <!-- <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Delete</a> -->
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
        let table = $('#dataTable').DataTable();

        // Make rows clickable to assign device endpoint
        table.on('click', 'tbody tr',
            function() {
                let data = table.row(this).data();

                window.location.replace("{{ route('edit.agent', $agent['id']) }}");
            }

        );
    });
</script>

@endsection