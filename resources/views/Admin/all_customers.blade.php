@extends('layouts.admin_master')
@section('content')



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Device Assignees List
    </div>
    <div class="card-body">
        <div class="table-responsive justify-content-center">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Device Assigned</th>
                        <th>Device Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $row)
                    <tr>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->address }}</td>
                        <td>{{ $row->phone }}</td>

                        @if($row->device_id !== null)
                        <td><i class="fa fa-check-circle fa-lg" aria-hidden="false"></i></td>
                        <td>{{ $row->device_id }}</td>
                        @else
                        <td><i class="fa fa-times-circle fa-lg" aria-hidden="false"></i></td>
                        <td></td>
                        @endif
                        <td>
                            <a href="{{url('/edit-customer')}}" class="btn btn-sm btn-info">Edit</a>
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