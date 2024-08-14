@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Create New Agent</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('create.agent') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="first_name">First Name</label>
                                        <input class="form-control py-4" name="first_name" value="" placeholder="First Name" type="text" required />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="last_name">Last Name</label>
                                        <input class="form-control py-4" name="last_name" value="" placeholder="Last Name" type="text" required />

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address1">Address</label>
                                        <input class="form-control py-4" name="address1" type="text" value="" placeholder="Address" required />
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address2">Address Line 2 (optional)</label>
                                        <input class="form-control py-4" name="address2" type="text" value="" placeholder="Address Line 2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_city">City</label>
                                        <input class="form-control py-4" name="address_city" type="text" value="" placeholder="City" required />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_state">State</label>
                                        <input class="form-control py-4" name="address_state" type="text" value="" maxlength=2 placeholder="State" required />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="small mb-1" for="address_zip">Zip Code</label>
                                        <input class="form-control py-4" name="address_zip" type="text" value="" maxlength=5 placeholder="Zip Code" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="phone">Phone Number</label>
                                        <input class="form-control py-4" name="phone" type="tel" value="" placeholder="(XXX)-XXX-XXXX" required />
                                    </div>
                                </div>
                            </div>


                            <div class=" form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Agent</button></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection