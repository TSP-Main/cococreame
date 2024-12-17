@extends('layout.app')
@section('title', 'Cart')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('theme/images/background/34.jpg')}})">
        <div class="auto-container">
            <h1>Cart</h1>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!--Cart Section-->
    <section class="cart-section">
        @if ($cart)
            <div class="auto-container">
                <!--Cart Outer-->
                <div class="cart-outer">
                    <div class="table-outer">
                        <table class="cart-table">
                            <thead class="cart-header">
                                <tr>
                                    <th class="product-thumbnail text-center">Image</th>
                                    <th class="product-name text-center">Product</th>
                                    <th class="product-price text-center">Price</th>
                                    <th class="product-quantity text-center">Quantity</th>
                                    <th class="product-subtotal text-center">Total</th>
                                    <th class="product-remove text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                    <tr class="cart-item">
                                        <td class="product-thumbnail">
                                            <a href="shop-single.html"><img src="{{ $item['productImage'] }}" alt=""></a>
                                        </td>
                                        <td class="product-name">
                                            <p><a href="shop-single.html"><b>{{ $item['productTitle'] }}</b></a></p>
                                            <span><small>{{ $item['optionNames'] ? implode(', ', $item['optionNames']) : '' }}</small></span>
                                        </td>
                                        <td class="product-price">{{ $currency . $item['comboTotal'] }}</td> 
                                        <td class="product-quantity">
                                            <div class="quantity">
                                                <label>Quantity</label>
                                                <input type="number" min="1" max="10" id="quantity-{{ $item['rowId'] }}" class="qty" name="quantity" value="{{ $item['quantity'] }}" data-row-id={{ $item['rowId'] }} onkeypress="return false;">
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount" id="rowTotal-{{ $item['rowId'] }}">{{ $currency . $item['rowTotal'] }}</span>
                                        </td>
                                        <td class="product-remove">
                                            <a href="#" class="remove" data-id="{{ $item['rowId'] }}">
                                                <span class="fa fa-times"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="cart-options clearfix">
                        <div class="pull-left">
                            <div class="apply-coupon clearfix">
                                <div class="form-group clearfix">
                                    <input type="text" name="coupon-code" value="" placeholder="Coupon Code">
                                </div>
                                <div class="form-group clearfix">
                                    <button type="button" class="theme-btn coupon-btn">Apply Coupon</button>
                                </div>
                            </div>
                        </div>

                        <div class="pull-right">
                            <button type="button" class="theme-btn cart-btn">update cart</button>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-between">                    
                    <div class="column col-lg-4 offset-lg-8 col-md-6 col-sm-12">
                        <!--Totals Table-->
                        <ul class="totals-table">
                            <li><h3>Cart Totals</h3></li>
                            <li class="clearfix"><span class="col">Subtotal</span><span class="col price" id="subTotal">{{ $currency . $subTotal}}</span></li>
                            <li class="clearfix"><span class="col">Total</span><span class="col total-price" id="total">{{ $currency . $subTotal}}</span></li>
                            <li class="text-right"><a href="{{ route('checkout.view') }}"><button type="submit" class="theme-btn proceed-btn">Proceed to Checkout</button></a></li>
                        </ul>
                    </div>  
                </div>
            </div>
        @else
            <h1 class="text-center">Your cart is empty</h1>
        @endif
    </section>
    <!--End Cart Section-->
@endsection

@push('script')
    $(document).on('click', '.remove', function(e) {
        e.preventDefault();
        
        let productId = $(this).data('id');
        let row = $(this).closest('.cart-item');

        if (confirm("Are you sure you want to remove this item from the cart?")) {
            $.ajax({
                url: "{{ route('cart.remove') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: productId
                },
                success: function(response) {
                    alert(response.message);
                    row.remove();
                    $('#subTotal').text(@json($currency) + response.cartSubTotal.toFixed(2));
                    $('#total').text(@json($currency) + response.cartSubTotal.toFixed(2));
                }
            });
        }
    });

    $(document).on('change', '.qty', function(){
        let quantity = $(this).val();
        let rowId = $(this).data('row-id');

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                row_id: rowId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $('#rowTotal-'+rowId).text(response.rowTotal);
                    $('#subTotal').text(@json($currency) + response.cartSubTotal.toFixed(2));
                    $('#total').text(@json($currency) + response.cartSubTotal.toFixed(2));
                }
            }
        });
    });
@endpush