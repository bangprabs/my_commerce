@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Forgot Password</li>
    </ul>
    <h3> Forgot Password</h3>
    <hr class="soft" />
    @if (Session::has('error_message'))
        <div class="mr-3 ml-3" style="margin-bottom: -10px">
            <div class="mt-4 alert alert-danger" role="alert">
                {{ Session::get('error_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif

        @if (Session::has('success_message'))
        <div class="mr-3 ml-3" style="margin-bottom: -10px">
            <div class="mt-4 alert alert-success" role="alert">
                {{ Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
    <div class="row">
        <div class="span9">
            <div class="well">
                <h5>Forgot Password</h5><br />
                Enter your email to get the new password.<br /><br />
                <form id="forgotPasswordForm" action="{{ url('/forgot-password') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="email">E-mail address</label>
                        <div class="controls">
                            <input class="span3" type="text" id="email" name="email" placeholder="Enter Email">
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
