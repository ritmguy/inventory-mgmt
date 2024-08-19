@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            <div class="col-xl-5 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        Laptops
                        <div class="row">

                            <div class="col-xs-2 px-4 py-4">
                                @foreach($devices as $device)
                                @if($device['category'] != 'Laptops')
                                @else
                                <div class="card text-dark mb-4 px-4 py-2">

                                    <h4 class="text-gray">{{ $device['name'] }} - {{ $device['code'] }}</h4>
                                    {{ $device['assigned'] }} Assigned / {{ $device['unassigned'] }} Unassigned

                                </div>
                                @endif
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('all.devices') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        Headsets
                        <div class="row">

                            <div class="col-xs-2 px-4 py-4">
                                @foreach($devices as $device)
                                @if($device['category'] != 'Headset')

                                @else
                                <div class="card text-dark mb-4 px-4 py-2">

                                    <h4 class="text-gray">{{ $device['name'] }} - {{ $device['code'] }}</h4>
                                    {{ $device['assigned'] }} Assigned / {{ $device['unassigned'] }} Unassigned

                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('all.devices') }}">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Recent Transactions
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>User ID</th>
                                <th>Notes</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $action)
                            <tr>
                                <td>{{ $action->transaction_type }}</td>
                                <td>{{ $action->user_id }}</td>
                                <td>{{ $action->notes }}</td>
                                <td>{{ $action->updated_at }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<!-- Document on ready function -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            order: [3, 'desc']
        });
    });
</script>
@endsection