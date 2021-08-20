@extends('layouts.admin_layout.admin_layout')
@section('content')

<div class="content-wrapper mb-5">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Change Your Password Account</h3>
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

            <form method="post" role="form" action="{{ url('/admin/update-current-pwd') }}"
                name="updatePasswordForm" id="updatePasswordForm">@csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Admin Email</label>
                        <input class="form-control" value="{{ $adminDetails->email}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Admin Type</label>
                        <input class="form-control" value="{{ $adminDetails->type }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Current Password</label>
                        <input type="password" class="form-control" id="current_pwd" name="current_pwd"
                            placeholder="Enter Current Password">
                        <span id="chkCurrentPwd"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2r">New Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" id="new_pwd"
                            name="new_pwd" placeholder="Enter New Password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Confirm New Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" id="confirm_pwd"
                            name="confirm_pwd" placeholder="Enter Confirm New Password" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
