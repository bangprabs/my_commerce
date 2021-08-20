@extends('layouts.admin_layout.admin_layout')
@section('content')



<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Categories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Catalogues</a></li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{$title}}</h3>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mt-2 mr-3 ml-3" alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                    @endforeach
                </div>
                @endif

                @if (Session::has('success_message'))
                <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif

                <form @if (empty($brand['id'])) action="{{ url('admin/add-edit-brand')}}" @else
                    action="{{ url('admin/add-edit-brand/'.$brand['id'])}}" @endif
                    name="brandForm" id="brandForm" method="post">@csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="brand">Brand Name</label>
                                    <input class="form-control" id="brand" name="brand_name" placeholder="Enter Brand Name"
                                        @if (!empty($brand['name'])) { value="{{ $brand['name'] }}" } @else {
                                        value="{{ old('name') }}" } @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
            </div>
            </form>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header card-success">
                            <h3 class="card-title">Current Brands</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="brands" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;?>
                                    @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$brand->name}}</td>
                                    </tr>
                                    <?php $no++?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. </th>
                                        <th>Name</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</div>


</section>



</div>
@endsection
