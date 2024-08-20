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
                                        <input class="form-control py-4" name="phone_number" id="phone_number" type="tel" value="{{ $agent_phone }}" required />
                                    </div>
                                </div>
                            </div>


                            <div class=" form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fa fa-lg fa-edit"></i> Update</button></div>
                            <!-- <div class="form-group mt-4 mb-0"><button class="btn btn-danger btn-block" onclick="(function () { window.replace(" {{ route('all.agents') }}"); })\"><i class="fa fa-xl fa-times"></i> Cancel</button></div> -->

                        </form>
                    </div>
                    <div class="card-footer">
                        <!-- Device Table -->

                        <div class="form-group">
                            <div>
                                <h3 class="text-center font-weight-light my-4">Assigned Devices</h3>
                            </div>
                            <hr class="py-3">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="dataTable" name="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Device Name</th>
                                            <th>Device Type</th>
                                            <th>Product Code</th>
                                            <th>Actions</th>
                                            <th>ID</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($devices as $device)
                                        <tr>
                                            <td>{{ $device['device_name'] }}</td>
                                            <td>{{ $device['device_type'] }}</td>
                                            <td>{{ $device['product_code'] }}</td>
                                            <td><a href="{{ route('unassign.device', $device['device_id']) }}" class="btn btn-sm btn-danger"><i class="fa fa-xl fa-times"></i> Un-Assign</a>
                                            <td class="hidden">{{$device['device_id']}}</td>
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

@section('script')
<!-- Document on ready function -->
<script>
    $(document).ready(function() {

        // Call the dataTables jQuery plugin
        let table = $('#dataTable').DataTable({
            columnDefs: [{
                target: 4,
                visible: false
            }]
        });

        // // Make rows clickable to assign device endpoint
        // table.on('click', 'tbody tr',
        //     function() {
        //         let data = table.row(this).data();

        //         window.location.replace("{{ route('assign.device', " + data[4] + ") }}");
        //     }

        // );
    });
</script>

@endsection