@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Add New Device</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('create.device') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="device_type">Device Type/Model</label>
                                        <select class="form-control py-2" name="device_type" required>
                                            @foreach($category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name . ' - ' . $cat->product_code }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="device_name">Device Name</label>
                                        <input class="form-control py-4" name="device_name" value="" placeholder="Enter desired name" type="text" />

                                    </div>
                                </div>

                            </div>


                            <div class=" form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Device</button></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>




@endsection

@section('scripts')
<script>
    // $('<option>').val('999').text('999').appendTo('#groupid');
</script>
@endsection