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

                <form enctype="multipart/form-data" name="addAttributeForm" id="addAttributeForm" method="post"
                    action="{{ url('admin/add-attributes/'.$productdata['id']) }}">@csrf
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

                                <div class="input-group field_wrapper">
                                    <label for="product_color">Add Attributes</label>
                                    <div class="col-auto input-group-append p-0">
                                        <input id="size" name="size[]" name="size[]" required placeholder="Size"
                                            type="text" type="text" class="form-control mr-2 ">
                                        <input id="sku" name="sku[]" name="sku[]" required placeholder="SKU" type="text"
                                            type="text" class="form-control mr-2 ">
                                        <input id="price" name="price[]" name="price[]" required placeholder="Price"
                                            type="text" type="number" class="form-control mr-2 ">
                                        <input id="stock" name="stock[]" name="stock[]" required placeholder="Stock"
                                            type="text" type="numer" class="form-control mr-2">
                                        <button class="add_button btn btn-success rounded"><a href="javascript:void(0);" title="Add field"
                                            ><i class="fas fa-plus"
                                                style="color: #fff"></i></a></button>
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
                        <button type="submit" class="btn btn-primary">Add Attributes</button>
                    </div>
                </form>



            </div>
        </div>

        <form action="{{ url('admin/edit-attributes/' . $productdata['id']) }}" method="post" name="editAttributeForm"
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
                                            <th>Size</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $no = 1;?>
                                        @foreach ($productdata['attributes'] as $attribute)
                                        <input style="display: none" type="text" name="attrId[]"
                                            value="{{$attribute['id']}}">
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{$attribute['size']}}</td>
                                            <td>{{$attribute['sku']}}</td>
                                            <td>
                                                <input type="number" class="form-control" name="price[]"
                                                    value="{{$attribute['price']}}" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" name="stock[]"
                                                    value="{{$attribute['stock']}}" required>
                                            </td>
                                            <td style="width: 12%; text-align: center">
                                                @if ($attribute['status'] == 1)
                                                <a class="updateAttributesStatus btn btn-primary"
                                                    id="attribute-{{$attribute['id']}}"
                                                    attribute_id="{{$attribute['id']}}"
                                                    href="javascript:void(0)">Active</a>
                                                @else
                                                <a class="updateAttributesStatus btn btn-danger"
                                                    id="attribute-{{$attribute['id']}}"
                                                    attribute_id="{{$attribute['id']}}"
                                                    href="javascript:void(0)">Inactive</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a title="Delete Products" href="javascript:void(0)" record="attribute"
                                                    recordid="{{ $attribute['id'] }}"
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
                                            <th>Size</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Uppdate Attributes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>
@endsection
