@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Edit Agent - {{ $agent->first_name . ' ' . $agent->last_name}}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update.agent') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="first_name">First Name</label>
                                        <input class="form-control py-4" name="first_name" value="{{ $agent->first_name }}" type="text" required />
                                        <input class="form-control" name="agentId" value="{{ $agent->id }}" hidden />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="last_name">Last Name</label>
                                        <input class="form-control py-4" name="last_name" value="{{ $agent->last_name }}" type="text" required />

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address1">Address</label>
                                        <input class="form-control py-4" name="address1" type="text" value="{{ $agent->address1 }}" required />
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address2">Address Line 2 (optional)</label>
                                        <input class="form-control py-4" name="address2" type="text" value="{{ $agent->address2 }}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_city">City</label>
                                        <input class="form-control py-4" name="address_city" type="text" value="{{ $agent->address_city }}" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_state">State</label>
                                        <input class="form-control py-4" name="address_state" type="text" value="{{ $agent->address_state }}" maxlength=2 required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_zip">Zip Code</label>
                                        <input class="form-control py-4" name="address_zip" type="text" value="{{ $agent->address_zip }}" maxlength=5 required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="phone">Phone Number</label>
                                        <input class="form-control py-4" name="phone" type="tel" value="{{ $agent->phone_number }}" required />
                                    </div>
                                </div>
                            </div>


                            <div class=" form-group mt-4 mb-0"><button class="btn btn-primary btn-block">Submit</button></div>

                            <!-- Device Table -->
                            <hr class="py-2" />
                            <div class="form-group">
                                <label class="lg mb-1" for="phone">Assigned Devices</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" name="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Device Name</th>
                                                <th>Device Type</th>
                                                <th>Product Code</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($out as $device)
                                            <tr>
                                                <td>{{ $device['device_name'] }}</td>
                                                <td>{{ $device['device_type'] }}</td>
                                                <td>{{ $device['product_code'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
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
        $('#dataTable').DataTable();
    });
</script>
@endsection