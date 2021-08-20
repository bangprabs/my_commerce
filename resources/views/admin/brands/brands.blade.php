@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Catalogues</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header card-success">
                            <h3 class="card-title mt-2">Data Brands</h3>
                            <a href="{{ url('admin/add-edit-brand')}}" class="btn btn-primary float-right">Add Brands</a>
                        </div>

                        @if (Session::has('success_message'))
                        <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                {{ Session::get('success_message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="brands" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;?>
                                    @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{$brand->name}}</td>
                                        <td>
                                            @if ($brand->status == 1)
                                            <a class="updateBrandStatus btn btn-primary btn-block"
                                                id="brand-{{$brand->id}}" brand_id="{{$brand->id}}"
                                                href="javascript:void(0)">Active</a>
                                            @else
                                            <a class="updateBrandStatus btn btn-danger btn-block"
                                                id="brand-{{$brand->id}}" brand_id="{{$brand->id}}"
                                                href="javascript:void(0)">Inactive</a>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                            <a title="Edit Brand" href="{{ url('admin/add-edit-brand/'.$brand->id)}}" class="btn btn-success "><i class="fas fa-edit"></i></a>
                                            <a title="Delete Brand" href="javascript:void(0)" record="brand" recordid="{{ $brand->id }}" class="confirmDelete btn btn-danger ml-3"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php $no++?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No. </th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
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
    </section>
</div>

@endsection
