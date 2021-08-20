@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title mt-2">Data Products</h3>
                            <a href="{{ url('admin/add-edit-product')}}" class="btn btn-success float-right">Add Products</a>
                        </div>

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

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Num. </th>
                                        <th>Product Name</th>
                                        <th>Product Code</th>
                                        <th>Product Color</th>
                                        <th>Product Image</th>
                                        <th>Category</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $no = 1;?>
                                    @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->product_code}}</td>
                                        <td>{{$product->product_color}}</td>
                                        <td style="width: 10%; text-align: center">
                                            <?php $product_image_path = "images/product_images/small/" . $product->main_image; ?>
                                            @if (!empty($product->main_image && file_exists($product_image_path)))
                                                <img class="w-75 img-thumbnail rounded mx-auto d-block" src="{{ asset('images/product_images/small/' . $product->main_image) }}" alt="">
                                            @else
                                                <img class="w-75 img-thumbnail rounded mx-auto d-block" src="{{ asset('images/product_images/small/no-image.png') }}" alt="">
                                            @endif
                                        </td>
                                        <td>{{$product->category->category_name}}</td>
                                        <td>{{$product->section->name}}</td>
                                        <td class="align-middle">
                                            @if ($product->status == 1)
                                                <a class="updateProductsStatus btn btn-primary btn-block" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)">Active</a>
                                            @else
                                                <a class="updateProductsStatus btn btn-danger btn-block" id="product-{{$product->id}}" product_id="{{$product->id}}" href="javascript:void(0)">Inactive</a>
                                            @endif
                                        </td>
                                        <td style="width: 12%; text-align: center">
                                            <a title="Add/Edit Attributes" href="{{ url('admin/add-attributes/'.$product->id)}}" class="btn btn-success m-1"><i class="fas fa-plus-circle"></i></a>
                                            <a title="Edit Products" href="{{ url('admin/add-edit-product/'.$product->id)}}" class="btn btn-primary m-1"><i class="fas fa-edit"></i></a>
                                            <a title="Delete Products" href="javascript:void(0)" record="product" recordid="{{ $product->id }}" class="confirmDelete btn btn-danger m-1"><i class="fas fa-trash"></i></a>
                                            <a title="Add Images" href="{{ url('admin/add-images/'.$product->id)}}" class="btn btn-warning m-1"><i class="fas fa-image "></i></a>
                                        </td>
                                    </tr>
                                    <?php $no++?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Num. </th>
                                        <th>Product Name</th>
                                        <th>Product Code</th>
                                        <th>Product Color</th>
                                        <th>Product Image</th>
                                        <th>Category</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
