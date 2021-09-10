@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active"> SHOPPING CART</li>
    </ul>
    <h3> SHOPPING CART [ <small><span class="totalCartItems">{{totalCartItems()}}</span> Item(s) </small>]<a href="products.html" class="btn btn-large pull-right"><i
                class="icon-arrow-left"></i> Continue Shopping </a></h3>
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

    <div id="AppendCartItems">
      @include('front.products.cart_items')
    </div>

    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>
                    <form method="post" action="javascript:void(0);" class="form-horizontal" id="applyCoupon" @if (Auth::check()) user="1" @endif>@csrf
                        <div class="control-group">
                            <label class="control-label"><strong> COUPON CODE: </strong> </label>
                            <div class="controls">
                                <input name="code" id="code" type="text" class="input-medium" required placeholder="Enter Coupon Code">
                                <button type="submit" class="btn"> Apply Coupon </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>

        </tbody>
    </table>

    <a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
    <a href="login.html" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

</div>
@endsection
