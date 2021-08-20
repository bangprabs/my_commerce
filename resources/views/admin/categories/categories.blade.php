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
                        <li class="breadcrumb-item"><a href="#">Catalogues</a></li>
                        <li class="breadcrumb-item active">Categories</li>
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
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title mt-2">Data Categories</h3>
                            <a href="{{ url('admin/add-edit-category')}}" class="btn btn-success float-right">Add Category</a>
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
                            <table id="categories" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Num. </th>
                                        {{-- <th>ID</th> --}}
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th>Section</th>
                                        <th>URL</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $no = 1;?>
                                    @foreach ($categories as $category)
                                    @if (!isset($category->parentcategory->category_name))
                                    <?php $parent_category = "Root" ?>
                                    @else
                                    <?php $parent_category = $category->parentcategory->category_name ?>
                                    @endif
                                    <tr>
                                        <td>{{ $no }}</td>
                                        {{-- <td>{{$category->id}}</td> --}}
                                        <td>{{$category->category_name}}</td>
                                        <td>{{ $parent_category }}</td>
                                        <td>{{$category->section->name}}</td>
                                        <td>{{$category->url}}</td>
                                        <td>
                                            @if ($category->status == 1)
                                            <a class="updateCategoryStatus btn btn-primary btn-block" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)">Active</a>
                                            @else
                                            <a class="updateCategoryStatus btn btn-danger btn-block" id="category-{{$category->id}}" category_id="{{$category->id}}" href="javascript:void(0)">Inactive</a>
                                            @endif
                                        </td>
                                        <td style="width: 12%; text-align: center">
                                            <a href="{{ url('admin/add-edit-category/'.$category->id)}}" class="btn btn-warning">Edit</a>
                                            <a href="javascript:void(0)" record="category" recordid="{{ $category->id }}" class="confirmDelete btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <?php $no++?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Num. </th>
                                        {{-- <th>ID</th> --}}
                                        <th>Category</th>
                                        <th>Parent Category</th>
                                        <th>Section</th>
                                        <th>URL</th>
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
