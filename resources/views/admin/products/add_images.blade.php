@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Catalogues</a></li>
                        <li class="breadcrumb-item active">Products Attributes</li>
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

                @if (Session::has('error_message'))
                <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('error_message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
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

                <form enctype="multipart/form-data" name="addImageForm" id="addImageForm" method="post"
                    action="{{ url('admin/add-images/'.$productdata['id']) }}">@csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input readonly disabled class="form-control" id="product_name" name="product_name"
                                        placeholder="Enter product Name" @if (!empty($productdata['product_name'])) {
                                        value="{{ $productdata['product_name'] }}" } @else {
                                        value="{{ old('product_name') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_code">Product Code</label>
                                    <input readonly disabled class="form-control" id="product_code" name="product_code"
                                        placeholder="Enter Product Code" @if (!empty($productdata['product_code'])) {
                                        value="{{ $productdata['product_code'] }}" } @else {
                                        value="{{ old('product_code') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_color">Product Color</label>
                                    <input readonly disabled class="form-control" id="product_color"
                                        name="product_color" placeholder="Enter Product Code"
                                        @if(!empty($productdata['product_color'])) {
                                        value="{{ $productdata['product_color'] }}" } @else {
                                        value="{{ old('product_color') }}" } @endif>
                                </div>

                                <label for="product_color">Add Images</label>
                                <div class="input-group field_wrapper">
                                    <div class="custom-file">
                                        <input required multiple type="file" class="custom-file-input" id="image"
                                            name="image[]">
                                        <label class="custom-file-label" for="image">
                                            @if (!empty($productdata['image']))
                                                    {{$productdata['image']}}
                                                @else
                                                    Choose file
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="main_image">Product Main Image</label>
                                            <?php $product_image_path = "images/product_images/small/" . $productdata['main_image']; ?>
                                            @if (!empty($productdata['main_image'] && file_exists($product_image_path)))
                                            <img class="w-25 img-thumbnail rounded mx-auto d-block"
                                                src="{{ asset('images/product_images/small/' . $productdata['main_image']) }}"
                                                alt="">
                                            @else
                                            <img class="w-25 img-thumbnail rounded mx-auto d-block"
                                                src="{{ asset('images/product_images/small/no-image.png') }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Images</button>
                    </div>
                </form>



            </div>
        </div>

        <form action="{{ url('admin/add-images/' . $productdata['id']) }}" method="post" name="editAttributeForm"
            id="editAttributeForm">@csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Added Product Attributes</h3>
                                </div>
                            </div>
                            @if (Session::has('success_message_edit_attr'))
                            <div class="mt-2 mr-3 ml-3" style="margin-bottom: -10px">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('success_message_edit_attr')}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                            <div class="card-body">
                                <table id="products" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Num. </th>
                                            <th>Images Name</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $no = 1;?>
                                        @foreach ($productdata['images'] as $image)
                                        <input style="display: none" type="text" name="attrId[]"
                                            value="{{$image['id']}}">
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{$image['image']}}</td>
                                            <td>
                                                <?php $product_image_path = "images/product_images/small/" . $image['image']; ?>
                                                @if (!empty($image['image'] && file_exists($product_image_path)))
                                                    <img class="w-25 img-thumbnail rounded mx-auto d-block" src="{{ asset('images/product_images/small/' . $image['image']) }}" alt="">
                                                @else
                                                    <img class="w-25 img-thumbnail rounded mx-auto d-block" src="{{ asset('images/product_images/small/no-image.png') }}" alt="">
                                                @endif
                                            </td>
                                            <td style="width: 12%; text-align: center">
                                                @if ($image['status'] == 1)
                                                <a class="updateImageStatus btn btn-primary"
                                                    id="image-{{$image['id']}}"
                                                    image_id="{{$image['id']}}"
                                                    href="javascript:void(0)">Active</a>
                                                @else
                                                <a class="updateImageStatus btn btn-danger"
                                                    id="image-{{$image['id']}}"
                                                    image_id="{{$image['id']}}"
                                                    href="javascript:void(0)">Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a title="Delete Image" href="javascript:void(0)" record="image"
                                                    recordid="{{ $image['id'] }}"
                                                    class="confirmDelete btn btn-danger w-100"><i
                                                        class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php $no++?>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Num. </th>
                                            <th>Product Id</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Uppdate Images</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
