<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <div class="well well-small">
        <h4>Featured Products <small class="pull-right">{{$featuredItemsCount}} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" @if ($featuredItemsCount > 4)  class="carousel slide" @endif>
                <div class="carousel-inner">
                    @foreach ($featuredItemsChunk as $key => $featuredItem)
                        <div class="item @if($key==1) active @endif">
                            <ul class="thumbnails">
                                @foreach ($featuredItem as $item)
                                    <li class="span3">
                                        <div class="thumbnail" style="height: 300px;>
                                            <i class="tag"></i>
                                            <?php $product_image_path = 'images/product_images/small/'.$item['main_image']; ?>
                                            @if (!empty($item['main_image']) && file_exists($product_image_path))
                                                <a href="{{ url('product/'. $item['id']) }}"><img style="width: 170px; height: 170px;" src="{{ asset('/images/product_images/small/'.$item['main_image']) }}" alt=""></a>
                                                @else
                                                <a href="{{ url('product/'. $item['id']) }}"><img style="width: 170px; height: 170px;" src="{{ asset('/images/product_images/small/no-image.png') }}" alt=""></a>
                                            @endif
                                            <div class="caption">
                                                <h5>{{$item['product_name']}}</h5>
                                                <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                                                <h5><a class="btn" style="margin-bottom: 10px;" href="{{ url('product/'. $item['id']) }}">VIEW</a><br>
                                                    @if ($discounted_price > 0)
                                                    <del>@currency($item['product_price'])</del><br>
                                                    <font color="red"> @currency($discounted_price)</font>
                                                    @else
                                                        @currency($item['product_price'])
                                                @endif
                                                </h5>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach ($newProducts as $product)
        <li class="span3">
            <div class="thumbnail" style="margin-left: 14px; height: 400px;">
                <?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
                @if (!empty($product['main_image']) && file_exists($product_image_path))
                    <a href="{{ url('product/'. $product['id']) }}"><img style="width: 195px; height: 195px;" src="{{ asset('/images/product_images/small/'.$product['main_image']) }}" alt=""></a>
                    @else
                    <a href="{{ url('product/'. $product['id']) }}"><img style="width: 195px; height: 195px;" src="{{ asset('/images/product_images/small/no-image.png') }}" alt=""></a>
                @endif
                <div class="caption">

                    <h5>{{$product['product_name']}}</h5>
                    <p>
                        {{$product['occassion']}} || Type : {{$product['sleeve']}}
                    </p>
                    <?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
                    <h4 style="text-align:center">
                        <a class="btn" href="{{ url('product/'.$product['id']) }}"> <i class="icon-zoom-in"></i></a>
                        <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a>
                        <a class="btn btn-primary" href="#">
                            @if ($discounted_price > 0)
                                <del>@currency($product['product_price'])</del>
                                <font color="yellow"> || @currency($discounted_price)</font>
                                @else
                                    @currency($product['product_price'])
                            @endif
                        </a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection
