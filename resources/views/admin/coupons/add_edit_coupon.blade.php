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
                                <div class="form-group">
                                    <label for="coupon_option">Coupon Option : </label></br>
                                    <input id="automaticCoupon" type="radio" name="coupon_option" id=""
                                        value="Automatic">&nbsp;Automatic</span>
                                    &nbsp;&nbsp;
                                    <input id="manualCoupon" type="radio" name="coupon_option" id=""
                                        value="Manual">&nbsp;Manual </span>
                                </div>
                                <div class="form-group">
                                    <label for="coupon_option">Select Category : </label><span style="font-size: 15px; font-style: italic; margin-left: 10px">Select with control key if multiple select</span></br>
                                    <select name="categories[]" class="form-control select2" multiple size="10">
                                        @foreach ($categories as $section)
                                        <optgroup label="{{ $section['name'] }}"></optgroup>
                                        @foreach ($section['categories'] as $category)
                                        <option value="{{ $category['id'] }}" @if (!empty(@old('category_id')) &&
                                            $category['id']==@old('category_id'))
                                            @elseif(!empty($productdata['category_id']) &&
                                            $productdata['category_id']==$category['id']) selected @endif>
                                            &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp; {{ $category['category_name'] }}</option>
                                        @foreach ($category['subcategories'] as $subcategory)
                                        <option value="{{ $subcategory['id'] }}" @if (!empty(@old('category_id')) &&
                                            $subcategory['id']==@old('category_id'))
                                            @elseif(!empty($productdata['category_id']) &&
                                            $productdata['category_id']==$subcategory['id']) selected @endif>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;
                                            {{ $subcategory['category_name'] }}</option>
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="display: none" id="couponField">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input class="form-control" id="coupon_code" name="coupon_code"
                                        placeholder="Enter Coupon Code">
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