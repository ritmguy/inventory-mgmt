@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Add New Status</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('add.status') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">


                                <div class="col-md-6 py-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="statusType">Status Type</label>
                                        <!-- <input class="form-control py-4" name="category" type="text" placeholder="" /> -->
                                        <select class="form-control py-2" name="statusType" required>
                                            @foreach($types as $type)
                                            <option value="{{ $type }}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="statusName">Status Name</label>
                                        <input class="form-control py-4" name="statusName" type="text" placeholder="" required />
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Status</button></div>
                        </form>
                        <div class="form-group mt-4 mb-0">
                            <a href="{{ route('all.products') }}" class="btn btn-danger btn-block"><i class="fa fa-md fa-ban"></i> Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection