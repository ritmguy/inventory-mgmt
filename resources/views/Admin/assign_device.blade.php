@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Assign Device - {{ $device->device_name }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('device.assign') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Category</label>
                                        <input class="form-control py-4" name="product_category" type="text" value="{{ $product->category }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Type</label>
                                        <input class="form-control py-4" name="product_type" type="text" value="{{ $product->name }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Product Code</label>
                                        <input class="form-control py-4" name="product_code" type="text" value="{{ $product->product_code }}" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Device Name</label>
                                        <input class="form-control py-4" name="device_name" type="text" value="{{ $device->device_name }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Current Assignment</label>
                                        @if($device['agent_id'] === null)
                                        <input class="form-control py-4" name="device_assignment" type="text" value="" placeholder="N/A" disabled />
                                        @else
                                        <input class="form-control py-4" name="device_assignment" type="text" value="{{ $current_agent->first_name . ' ' . $current_agent->last_name . ' - ' . $current_agent->id }}" disabled />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="small mb-1" for="agent_id">Agent</label>
                                        <select class="form-control py-2" name="agent_id" required>
                                            @foreach($agents as $agent)
                                            @if($agent->id === $device['agent_id'])
                                            @else
                                            <option value="{{ $agent->id }}">{{ $agent->first_name . ' ' . $agent->last_name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <input class="form-control" name="device_id" id="device_id" value="{{ $device->unique_id }}" hidden />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fa-md fa fa-wand-sparkles"></i> Assign</button></div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <!-- History Table -->
                        <div class="form-group">
                            <div>
                                <h3 class="text-center font-weight-light my-4">Device History</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="dataTable" name="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Transaction Type</th>
                                            <th>User</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($history as $log)
                                        <tr>
                                            <td>{{ $log['transaction_type'] }}</td>
                                            <td>{{ $log['name'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($log['updated_at'])->tz('America/New_York')->toDateTimeString() }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection