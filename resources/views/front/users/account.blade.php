@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">My Account</li>
    </ul>
    <h3> My Account</h3>
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

    @if ($errors->any())
    <div class="mt-4 alert alert-danger" role="alert">
        @foreach ($errors->all() as $error)
        {{ $error }} <br>
        @endforeach
    </div>
    @endif

    <div class="row">
        <div class="span4">
            <div class="well">
                <h5>My Account</h5><br />
                Details of your account.<br /><br />
                <form id="accountForm" action="{{ url('/account') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="name">Name</label>
                        <div class="controls">
                            <input class="span3" type="text" id="name" name="name" placeholder="Enter Name"
                                value="{{ $userDetails['name'] }}" required pattern="[A-Za-z]+">
                        </div>
                        <label class="control-label" for="address">Address</label>
                        <div class="controls">
                            <input class="span3" type="text" id="address" name="address" placeholder="Enter Address"
                                required value="{{ $userDetails['address'] }}">
                        </div>
                        <label class="control-label" for="city">City</label>
                        <div class="controls">
                            <input class="span3" type="text" id="city" name="city" placeholder="Enter City"
                                value="{{ $userDetails['city'] }}">
                        </div>
                        <label class="control-label" for="state">State</label>
                        <div class="controls">
                            <input class="span3" type="text" id="state" name="state" placeholder="Enter State"
                                value="{{ $userDetails['state'] }}">
                        </div>
                        <label class="control-label" for="country">Country</label>
                        <div class="controls">
                            <select class="span3" id="country" name="country">
                                <option value="">Select Contries</option>
                                @foreach ($countries as $country)
                                <option @if ($country['country_name']==$userDetails['country']) selected @endif
                                    value="{{ $country['country_name'] }}">{{$country['country_name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="control-label" for="pincode">Pincode</label>
                        <div class="controls">
                            <input class="span3" type="text" id="pincode" name="pincode" placeholder="Enter Pincode"
                                value="{{ $userDetails['pincode'] }}">
                        </div>
                        <label class="control-label" for="mobile">Mobile</label>
                        <div class="controls">
                            <input class="span3" type="number" name="mobile" id="mobile" placeholder="Enter Mobile"
                                value="{{ $userDetails['mobile'] }}">
                        </div>
                        <label class="control-label" for="email">E-mail address</label>
                        <div class="controls">
                            <input class="span3" value="{{ $userDetails['email'] }}" type="text" readonly>
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="span1"> &nbsp;</div>
        <div class="span4">
            <div class="well">
                <h5>Update Password Form</h5>
                <form id="passwordForm" action="{{ url('/update-password') }}" method="post">@csrf
                    <div class="control-group">
                        <label class="control-label" for="current_pwd">Current Password</label>
                        <div class="controls">
                            <input class="span3" type="password" name="current_pwd" id="current_pwd"
                                placeholder="Enter Current Password"><br>
                            <span id="chkPwd"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="new_password">New Password</label>
                        <div class="controls">
                            <input class="span3" type="password" name="new_password" id="new_password"
                                placeholder="Enter New Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="confirm_password">Confirm Password</label>
                        <div class="controls">
                            <input class="span3" type="password" name="confirm_password" id="confirm_password"
                                placeholder="Enter Confirm Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
