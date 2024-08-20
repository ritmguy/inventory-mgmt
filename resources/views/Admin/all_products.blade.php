@extends('layouts.admin_master')
@section('content')
<main>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">All Products and Product Models</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fa fa-tablet-screen-button mr-1"></i>
            Products
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Device Name</th>
                            <th>Product Code</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Assignments</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['code'] }}</td>
                            <td>{{ $row['category'] }}</td>

                            <td>{{ $row['totals'] }}</td>
                            <td>
                                <div class="py-2"><i class="fa-sharp fa-check text-success"></i> {{ $row['assigned'] }} Assigned</div>
                                <div class="py-2"><i class="fa-sharp fa-ban text-danger"></i> {{ $row['unassigned'] }} Unassigned</div>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($row['last_update'])->tz('America/New_York')->toDateTimeString() }}</td>

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
<script src="{{ asset('backend') }}/js/table-config.js"></script>

@endsection