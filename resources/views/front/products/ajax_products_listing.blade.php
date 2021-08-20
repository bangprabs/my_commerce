<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $product)
            <li class="span3">
                <div class="thumbnail" style="margin-left: 10px;">
                    <a href="product_details.html">
                        @if (isset($product['main_image']))
                            <?php $product_image_path = 'images/product_images/small/'.$product['main_image']; ?>
                        @else
                            <?php $product_image_path = ''; ?>
                        @endif
                        @if (!empty($product['main_image']) && file_exists($product_image_path))
                            <img style="width: 195px; height: 195px;" src="{{ asset($product_image_path)}}" alt="">
                            @else
                            <img style="width: 195px; height: 195px;" src="{{ asset('/images/product_images/small/no-image.png') }}" alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $product['product_name'] }}</h5>
                        <p>
                            @if ($product['brand_id'] == 0)
                                No Brands (Independent)
                            @else
                                {{ $product['brand']['name'] }}
                            @endif
                        </p>
                        <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">@currency($product['product_price'])</a></h4>
                        <p>
                            {{$product['fabric']}}
                        </p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>
