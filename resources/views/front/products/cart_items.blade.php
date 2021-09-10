<?php use App\Product; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity/Update</th>
            <th>Unit Price</th>
            <th>Category/Product <br>Discount</th>
            <th>Sub Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach ($userCartItems as $item)
        <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']); ?>
        <tr>
            <td> <img width="60" src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}" alt="" /></td>
            <td colspan="2">
                {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br />
                Color : {{ $item['product']['product_color'] }}<br />
                Size : {{ $item['size'] }}
            </td>
            <td>
                <div class="input-append">
                    <input readonly class="span1" style="max-width:34px" id="appendedInputButtons" size="16" type="text" value="{{ $item['quantity'] }}">
                        <button class="btn btnItemUpdate qtyMinus" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-minus"></i></button>
                        <button class="btn btnItemUpdate qtyPlus" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-plus"></i></button>
                        <button class="btn btn-danger btnItemDelete" data-cartid="{{ $item['id'] }}" type="button"><i class="icon-remove icon-white"></i></button> </div>
            </td>
            <td>@currency($attrPrice['product_price'])</td>
            <td>@currency($attrPrice['discount'])</td>
            <td>@currency($attrPrice['final_price'] * $item['quantity'])</td>
        </tr>
        <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']) ?>
        @endforeach

        <tr>
            <td colspan="6" style="text-align:right">Sub Price: </td>
            <td> @currency($total_price)</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right">Coupon Discount: </td>
            <td> Rs.0.00</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (@currency($total_price) - Rs.0) =</strong></td>
            <td class="label label-important" style="display:block"> <strong> @currency($total_price) </strong></td>
        </tr>
    </tbody>
</table>
