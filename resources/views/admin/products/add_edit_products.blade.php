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
                        <li class="breadcrumb-item active">Products</li>
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

                <form @if (empty($productdata['id'])) action="{{ url('admin/add-edit-product')}}" @else
                    action="{{ url('admin/add-edit-product/'.$productdata['id'])}}" @endif enctype="multipart/form-data"
                    name="productForm" id="productForm" method="post">@csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Category</label>
                                    <select name="category_id" id="category_id" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($categories as $section)
                                            <optgroup label="{{ $section['name'] }}" ></optgroup>
                                            @foreach ($section['categories'] as $category)
                                            <option value="{{ $category['id'] }}" @if (!empty(@old('category_id')) && $category['id'] == @old('category_id')) @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $category['id']) selected @endif> &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp; {{ $category['category_name'] }}</option>
                                                @foreach ($category['subcategories'] as $subcategory)
                                                    <option value="{{ $subcategory['id'] }}" @if (!empty(@old('category_id')) && $subcategory['id'] == @old('category_id')) @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $subcategory['id']) selected @endif > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp; {{ $subcategory['category_name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input class="form-control" id="product_name" name="product_name"
                                        placeholder="Enter product Name" @if (!empty($productdata['product_name'])) {
                                        value="{{ $productdata['product_name'] }}" } @else {
                                        value="{{ old('product_name') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_code">Product Code</label>
                                    <input class="form-control" id="product_code" name="product_code"
                                        placeholder="Enter Product Code" @if (!empty($productdata['product_code'])) {
                                        value="{{ $productdata['product_code'] }}" } @else {
                                        value="{{ old('product_code') }}" } @endif>
                                </div>
                                <div class="form-group">
                                    <label for="product_color">Product Color</label>
                                    <input class="form-control" id="product_color" name="product_color"
                                        placeholder="Enter Product Color" @if (!empty($productdata['product_color'])) {
                                        value="{{ $productdata['product_color'] }}" } @else {
                                        value="{{ old('product_color') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_price">Product Price</label>
                                    <input class="form-control" id="product_price" name="product_price"
                                        placeholder="Enter Product Price" @if (!empty($productdata['product_price'])) {
                                        value="{{ $productdata['product_price'] }}" } @else {
                                        value="{{ old('product_price') }}" } @endif>
                                </div>
                                <div class="form-group">
                                    <label for="product_discount">Product Discount (%)</label>
                                    <input class="form-control" id="product_discount" name="product_discount"
                                        placeholder="Enter product Color" @if (!empty($productdata['product_discount']))
                                        { value="{{ $productdata['product_discount'] }}" } @else {
                                        value="{{ old('product_discount') }}" } @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product_weight">Product Weight</label>
                                    <input class="form-control" id="product_weight" name="product_weight"
                                        placeholder="Enter product Color" @if (!empty($productdata['product_weight'])) {
                                        value="{{ $productdata['product_weight'] }}" } @else {
                                        value="{{ old('product_weight') }}" } @endif>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="main_image">Product Main Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="main_image"
                                                        name="main_image">
                                                    <label class="custom-file-label" for="main_image">
                                                        @if (!empty($productdata['main_image']))
                                                                {{$productdata['main_image']}}
                                                            @else
                                                                Choose file
                                                        @endif
                                                    </label>
                                                </div>
                                                @if (!empty($productdata['main_image']))
                                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                                    data-target="#exampleModalCenter">
                                                    View Image
                                                </button>
                                                @endif
                                            </div>
                                            <div class="font-smaller">Recommended Image Size = <b>Width : 1040px</b> | <b>Height : 1200px</b></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Images -->
                        @if (!empty($productdata['main_image']))
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Images</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="img-thumbnail rounded mx-auto d-block"
                                            src="{{ asset('images/product_images/medium/' . $productdata['main_image']) }}">
                                    </div>
                                    <div class="modal-footer">
                                        <a href="javascript:void(0)" record="product-image"
                                            recordid="{{ $productdata['id'] }}"
                                            class="confirmDelete btn btn-danger">Delete Image</a>
                                        {{-- <a href="{{ url('admin/delete-product-image/'.$productdata['id']) }}"
                                        class="btn btn-danger">Delete Image</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">

                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Select Fabric</label>
                                    <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($fabricArray as $fabric)
                                            <option value="{{ $fabric }}" @if(!empty($productdata['fabric']) && $productdata['fabric'] == $fabric) selected @endif>{{ $fabric }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Select Occasion</label>
                                    <select name="occassion" id="occassion" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($occasionArray as $occasion)
                                            <option value="{{ $occasion }}" @if(!empty($productdata['occassion']) && $productdata['occassion'] == $occasion) selected @endif>{{ $occasion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="product_video">Product Video</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="product_video"
                                                name="product_video">
                                            <label class="custom-file-label" for="product_video">
                                                @if (!empty($productdata['product_video']))
                                                {{$productdata['product_video']}}
                                                    @else
                                                        Choose file
                                                @endif
                                            </label>
                                        </div>
                                        @if (!empty($productdata['product_video']))
                                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                            data-target="#modalVideo">
                                            View Video
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Select Fit</label>
                                    <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($fitArray as $fit)
                                        <option value="{{ $fit }}" @if(!empty($productdata['fit']) && $productdata['fit'] == $fit) selected @endif>{{ $fit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                          <!-- Modal Video -->
                          @if (!empty($productdata['product_video']))
                          <div class="modal fade" id="modalVideo" tabindex="-1" role="dialog"
                              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLongTitle">Videos</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                              <div class="embed-responsive embed-responsive-16by9">
                                                <video controls width="500" height="345" src="{{ asset('videos/products_videos/' . $productdata['product_video']) }}"  />
                                              </div>
                                      </div>
                                      <div class="modal-footer">
                                          <a href="javascript:void(0)" record="product-video"
                                              recordid="{{ $productdata['id'] }}"
                                              class="confirmDelete btn btn-danger">Delete Videos</a>
                                          <a href="{{ url('videos/products_videos/' . $productdata['product_video']) }}" download=""
                                          class="btn btn-success">Download</a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          @endif

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Select Sleeve</label>
                                    <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($sleeveArray as $sleeve)
                                        <option value="{{ $sleeve }}" @if(!empty($productdata['sleeve']) && $productdata['sleeve'] == $sleeve) selected @endif>{{ $sleeve }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Select Pattern</label>
                                    <select name="pattern" id="pattern" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($patternArray as $pattern)
                                        <option value="{{ $pattern }}" @if(!empty($productdata['pattern']) && $productdata['pattern'] == $pattern) selected @endif>{{ $pattern }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label>Select Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($brands as $brand)
                                        <option value="{{ $brand['id'] }}" @if(!empty($productdata['brand_id']) && $productdata['brand_id'] == $brand['id']) selected @endif>{{ $brand['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="is_featured">Product Featured</label>
                                <div class="custom-control custom-switch mt-1">
                                    <input type="checkbox" name="is_featured" class="custom-control-input" id="customSwitch1" value="Yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured'] == "Yes") checked @endif>
                                    <label class="custom-control-label font-weight-normal" for="customSwitch1">Product Is Featured ? </label>
                                  </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description"
                                        class="ckeditor form-control" rows="3"
                                        placeholder="Enter product Meta Description">@if (!empty($productdata['meta_description'])) {{ $productdata['meta_description'] }} @else {{ old('meta_description') }} @endif
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <textarea name="meta_keywords" id="meta_keywords" class="ckeditor form-control"
                                        rows="3" placeholder="Enter product Meta Keywords">@if (!empty($productdata['meta_keywords'])) {{ $productdata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <textarea name="meta_title" id="meta_title" class="ckeditor form-control" rows="3"
                                        placeholder="Enter product Meta Title">@if (!empty($productdata['meta_title'])) {{ $productdata['meta_title'] }} @else {{ old('meta_title') }} @endif
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="wash_care">Wash Care</label>
                                    <textarea name="wash_care" id="wash_care" class="ckeditor form-control" rows="3"
                                        placeholder="">
                                        @if (!empty($productdata['wash_care']))
                                            {{ $productdata['wash_care'] }}
                                        @else
                                            {{ old('wash_care')}}
                                        @endif
                                        </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="product_description">Product Description</label>
                                    <textarea name="description" id="description" class="ckeditor form-control" rows="3"
                                        placeholder="">
                                        @if (!empty($productdata['description']))
                                            {{ $productdata['description'] }}
                                        @else
                                            {{ old('description')}}
                                        @endif
                                        </textarea>
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
</div>
</section>
</div>
@endsection
