@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        @if($device->device_name !== '')
                        <h3 class="text-center font-weight-light my-4">Edit Device - {{ $device->device_name }}</h3>
                        @else
                        <h3 class="text-center font-weight-light my-4">Edit Device - {{ $product->category }}</h3>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('edit.device') }}" enctype="multipart/form-data">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Device Name</label>
                                        <input class="form-control py-4" name="device_name" type="text" value="{{ $device->device_name }}" required />
                                    </div>
                                </div>
                            </div>

                            <input name="device_id" id="device_id" value="{{ $device->unique_id }}" hidden />

                            <div class=" form-group mt-4 mb-0"><button class="btn btn-primary btn-block">Submit</button></div>


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