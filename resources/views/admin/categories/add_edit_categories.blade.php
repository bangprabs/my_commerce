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

                <form @if (empty($categorydata['id'])) action="{{ url('admin/add-edit-category')}}" @else
                    action="{{ url('admin/add-edit-category/'.$categorydata['id'])}}" @endif
                    enctype="multipart/form-data" name="categoryForm" id="CategoryForm" method="post">@csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input class="form-control" id="category_name" name="category_name"
                                        placeholder="Enter Category Name" @if (!empty($categorydata['category_name'])) {
                                        value="{{ $categorydata['category_name'] }}" } @else {
                                        value="{{ old('category_name') }}" } @endif>
                                </div>
                                <div id="appendCategoriesLevel">
                                    @include('admin.categories.append_categories_level')
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Sections</label>
                                    <select name="section_id" id="section_id" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">Select</option>
                                        @foreach ($getSection as $section)
                                        <option value="{{$section->id}}" @if (!empty($categorydata['section_id']) &&
                                            $categorydata['section_id']==$section->id) selected @endif
                                            >{{$section->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Category Image</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="category_image"
                                                name="category_image">
                                            <label class="custom-file-label" for="category_image">Choose file</label>
                                        </div>
                                        @if (!empty($categorydata['category_image']))
                                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal"
                                            data-target="#exampleModalCenter">
                                            View Image
                                        </button>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    @if (!empty($categorydata['category_image']))
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
                                    <img class="img-thumbnail rounded mx-auto d-block" src="{{ asset('images/category_images/' . $categorydata['category_image']) }}">
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:void(0)" record="category-image" recordid="{{ $categorydata['id'] }}" class="confirmDelete btn btn-danger">Delete Image</a>
                                    {{-- <a href="{{ url('admin/delete-category-image/'.$categorydata['id']) }}" class="btn btn-danger">Delete Image</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="category_discount">Category Discount</label>
                                <input class="form-control" name="category_discount" id="category_discount"
                                    placeholder="Enter Category Discount"
                                    @if(!empty($categorydata['category_discount'])) {
                                    value="{{ $categorydata['category_discount'] }}" } @else {
                                    value="{{ old('category_discount') }}" } @endif>
                            </div>
                            <div class="form-group">
                                <label for="category_description">Category Description</label>
                                <textarea name="description" id="description" class="ckeditor form-control" rows="3" placeholder="">
                                    @if (!empty($categorydata['description']))
                                        {{ $categorydata['description'] }}
                                    @else
                                        {{ old('description')}}
                                    @endif
                                </textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="category_url">Category URL</label>
                                <input name="url" class="form-control" id="url" placeholder="Enter Category URL" @if(!empty($categorydata['url'])) { value="{{ $categorydata['url'] }}" } @else {
                                    value="{{ old('url') }}" } @endif>
                            </div>
                            <div class="form-group">
                                <label for="meta_title">Meta Title</label>
                                <textarea name="meta_title" id="meta_title" class="ckeditor form-control" rows="3"
                                    placeholder="Enter Category Meta Title">@if (!empty($categorydata['meta_title'])) {{ $categorydata['meta_title'] }} @else {{ old('meta_title') }} @endif
                                    </textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="meta_description">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" class="ckeditor form-control" rows="3"
                                    placeholder="Enter Category Meta Description">@if (!empty($categorydata['meta_description'])) {{ $categorydata['meta_description'] }} @else {{ old('meta_description') }} @endif
                                    </textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label for="meta_keywords">Meta Keywords</label>
                                <textarea name="meta_keywords" id="meta_keywords" class="ckeditor form-control" rows="3"
                                    placeholder="Enter Category Meta Keywords">@if (!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }} @else {{ old('meta_keywords') }} @endif
                                    </textarea>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
        </div>
</div>
</section>
</div>
@endsection
