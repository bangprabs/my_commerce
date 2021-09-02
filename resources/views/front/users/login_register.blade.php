@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">Login/Register</li>
    </ul>
    <h3> Login / Register</h3>
    <hr class="soft" />

    <div class="row">

        <div class="span4">
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
            <div class="well">
                <h5>CREATE YOUR ACCOUNT</h5><br />
                Enter your details to create an account.<br /><br />
                <form id="registerForm" action="{{ url('/register') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" id="name" name="name"  placeholder="Enter Name">
                        </div>
                        <label class="control-label" for="mobile">Mobile</label>
                        <div class="controls">
                            <input class="span3" type="number" name="mobile" id="mobile" placeholder="Enter Mobile">
                        </div>
                        <label class="control-label" for="email">E-mail address</label>
                        <div class="controls">
                            <input class="span3" type="text" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <label class="control-label" for="password">Choose Password</label>
                        <div class="controls">
                            <input class="span3" type="password" name="password" id="password" placeholder="Enter Password">
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Create Your Account</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>ALREADY REGISTERED ?</h5>
                <form>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail1">Email</label>
                        <div class="controls">
                            <input class="span3" type="text" id="inputEmail1" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword1">Password</label>
                        <div class="controls">
                            <input type="password" class="span3" id="inputPassword1" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Sign in</button> <a href="forgetpass.html">Forget
                                password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
