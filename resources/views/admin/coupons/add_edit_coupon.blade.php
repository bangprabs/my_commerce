@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Coupons</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Catalogues</a></li>
                        <li class="breadcrumb-item active">Coupons</li>
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
                <div class="alert alert-danger mt-2 mr-3 ml-3 alert-dismissible fade show" role="alert">
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

                <form @if (empty($coupon['id'])) action="{{ url('admin/add-edit-coupon')}}" @else
                    action="{{ url('admin/add-edit-coupon/'.$coupon['id'])}}" @endif name="couponForm" id="couponForm"
                    method="post">@csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @if (empty($coupon['coupon_code']))
                                <div class="form-group">
                                    <label for="coupon_option">Coupon Option : </label></br>
                                    <span><input id="automaticCoupon" type="radio" name="coupon_option" id=""
                                            value="Automatic" checked>&nbsp;Automatic</span>
                                    &nbsp;&nbsp;
                                    <span> <input id="manualCoupon" type="radio" name="coupon_option" id=""
                                            value="Manual">&nbsp;Manual </span>
                                </div>
                                <div class="form-group" style="display: none" id="couponField">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input class="form-control" id="coupon_code" name="coupon_code"
                                        placeholder="Enter Coupon Code">
                                </div>
                                @else
                                <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                                <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                                <div class="form-group" id="couponField">
                                    <label for="coupon_code">Coupon Code : </label>
                                    <span>{{$coupon['coupon_code']}}</span>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="coupon_option">Select Users : </label><span
                                        style="font-size: 15px; font-style: italic; margin-left: 10px">Select with
                                        control key if multiple select</span></br>
                                    <select data-placeholder="Select a Users" name="users[]" select
                                        class="form-control select2" multiple="multiple">
                                        @foreach ($users as $user)
                                        <option @if (in_array($user['email'], $selUsers)) selected @endif
                                            value="{{ $user['email'] }}">{{ $user['email'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Expiry Date</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" required data-inputmask-alias="datetime"
                                            data-inputmask-inputformat="yyyy/mm/dd" data-mask id="datemask" value="{{ $coupon['expiry_date'] }}"
                                            name="expiry_date">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="coupon_option">Select Category : </label><span
                                        style="font-size: 15px; font-style: italic; margin-left: 10px">Select with
                                        control key if multiple select</span></br>
                                    <select data-placeholder="Select a Category" name="categories[]"
                                        class="form-control select2" multiple size="10" required>
                                        @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}"></optgroup>
                                        @foreach ($section['categories'] as $category)
                                        <option value="{{ $category['id'] }}" @if (in_array($category['id'], $selCats))
                                            selected @endif>
                                            &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp; {{ $category['category_name'] }}
                                        </option>
                                        @foreach ($category['subcategories'] as $subcategory)
                                        <option value="{{ $subcategory['id'] }}" @if (in_array($subcategory['id'],
                                            $selCats)) selected @endif>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;
                                            {{ $subcategory['category_name'] }}</option>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="coupon_type">Coupon Type</label><br>
                                    <span><input type="radio" checked name="coupon_type"
                                        @if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Multiple Times")
                                            checked
                                            @elseif (!isset($coupon['coupon_type']))
                                            checked
                                        @endif
                                            value="Multiple Times">&nbsp;Multiple Times</span>&nbsp;&nbsp;
                                    <span><input type="radio" name="coupon_type"
                                        @if (isset($coupon['coupon_type']) && $coupon['coupon_type'] == "Single Times")
                                            checked
                                            @elseif (!isset($coupon['coupon_type']))
                                            checked
                                        @endif
                                        value="Single Times">&nbsp;Single
                                        Times</span>
                                </div>
                                <div class="form-group">
                                    <label for="amount_type">Amount Type</label><br>
                                    <span><input type="radio" checked name="amount_type"
                                        @if (isset($coupon['amount_type']) && $coupon['amount_type'] == "Precentage")
                                            checked
                                        @endif
                                            value="Precentage">&nbsp;Percentage (in %)</span>&nbsp;&nbsp;
                                    <span><input type="radio" name="amount_type"
                                        @if (isset($coupon['amount_type']) && $coupon['amount_type'] == "Fixed")
                                        checked
                                    @endif
                                        value="Fixed">&nbsp;Fixed (in
                                        Rupiah)</span>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input class="form-control" type="number" id="amount" name="amount" value="{{ $coupon['amount'] }}"
                                        placeholder="Enter Amount">
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
