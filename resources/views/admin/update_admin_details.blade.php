@extends('layouts.admin_layout.admin_layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper mb-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Update Your Account Information</h3>
            </div>

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

            @if ($errors->any())
            <div class="alert alert-danger mt-2 mr-3 ml-3 alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                {{ $error }} <br>
                @endforeach
            </div>
            @endif

            <!-- /.card-header -->
            <!-- form start -->
            <form method="post" role="form" action="{{ url('/admin/update-admin-details') }}"
                enctype="multipart/form-data" name="updateAdminDetails" id="updatePasswordForm">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="adminEmail">Admin Email</label>
                                    <input class="form-control" value="{{ $adminDetails->email}}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="adminType">Admin Type</label>
                                    <input class="form-control" value="{{ $adminDetails->type }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="adminName">Admin Name</label>
                                    <input class="form-control" type="text" value="{{ $adminDetails->name}}"
                                        placeholder="Enter Admin Name" name="admin_name" id="admin_name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="adminMobile">Mobile</label>
                                    <input class="form-control" type="text" value="{{ $adminDetails->mobile}}"
                                        placeholder="Enter Mobile Number" id="admin_mobile" name="admin_mobile">
                                </div>
                                <label for="adminImage">Image</label>
                                <input type="file" name="admin_image" class="file"
                                    style=" visibility: hidden; position: absolute;" accept="image/*">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" disabled placeholder="Upload File"
                                        id="file">
                                    <div class="input-group-append">
                                        <button type="button" class="browse btn btn-primary">Browse...</button>
                                    </div>
                                </div>
                                <img style="width: 40%;"
                                    src="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}"
                                    id="preview"
                                    class="img-thumbnail d-block mx-auto img-circle">
                                <div id="msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.content-wrapper -->
@endsection

{{-- <div class="form-group">
                        <label for="adminImage">Image</label>
                        <input class="form-control" type="file" id="admin_image" name="admin_image" accept="image/*">
                        @if (!empty(Auth::guard('admin')->user()->image))
                        <a href="{{ url('') }}">View Image</a>
<input type="hidden" name="current_admin_image" value="{{ (!empty(Auth::guard('admin')->user()->image)) }}">
@endif
</div> --}}
