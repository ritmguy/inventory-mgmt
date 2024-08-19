@extends('layouts.admin_master')

@section('content')

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Add New Product</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('add.product') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">


                                <div class="col-md-6 py-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputLastName">Type/Category</label>
                                        <!-- <input class="form-control py-4" name="category" type="text" placeholder="" /> -->
                                        <select class="form-control py-2" name="category" required>
                                            @foreach($category as $cat)
                                            <option value="{{ $cat }}">{{$cat}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Product Code</label>
                                        <input class="form-control py-4" name="code" type="text" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputFirstName">Product Name</label>
                                        <input class="form-control py-4" name="name" type="text" placeholder="" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="col-md-3 py-9">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputLastName">Buy Price (perUnit)</label>
                                        <input class="form-control py-4" name="unit_cost" type="text" placeholder="$0.00" required />
                                    </div>
                                </div>

                            </div>

                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block"><i class="fas fa-plus"></i> Add Product</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection