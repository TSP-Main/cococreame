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
                                            {{$currency}}<span class="amount" id="rowTotal-{{ $item['rowId'] }}">{{ $item['rowTotal'] }}</span>
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
                        <div class="pull-right">
                            <div class="apply-coupon clearfix">
                                <div class="form-group clearfix">
                                    <input type="text" name="discount_code" id="discount_code" value="{{$discountCode}}" style="text-transform: uppercase;" required placeholder="Coupon Code">
                                </div>
                                <div class="form-group clearfix">
                                    <button type="button" id="apply_discount" class="theme-btn coupon-btn">Apply Coupon</button>
                                </div>
                            </div>
                            <div id="discount_message"></div>
                        </div>
                    </div>
                </div>
                
                <div class="row justify-content-between">                    
                    <div class="column col-lg-4 offset-lg-8 col-md-6 col-sm-12">
                        <!--Totals Table-->
                        <ul class="totals-table">
                            <li><h3>Cart Totals</h3></li>
                            <li class="clearfix"><span class="col">Subtotal</span><span class="col price">{{ $currency}}<span id="sub-total">{{ $subTotal}}</span> </span></li>
                            <li class="clearfix discount-info" @if(!$discountCode) style="display: none;" @endif><span class="col">Discount Amount</span><span class="col">{{ $currency}}<span id="discount-amount">{{$discountAmount}}</span></span></li>
                            <li class="clearfix"><span class="col">Total</span><span class="col total-price">{{ $currency }}<span id="total">{{ number_format($subTotal - $discountAmount, 2)}} </span></span></li>
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

@section('script')
<script>
    $(document).ready(function() {
        $(document).on('click', '.remove', function(e) {
            e.preventDefault();
            
            let productId = $(this).data('id');
            let row = $(this).closest('.cart-item');
            let discountAmount = parseFloat($('#discount-amount').text());

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
                        $('#sub-total').text(response.cartSubTotal.toFixed(2));
                        $('#total').text(response.cartSubTotal.toFixed(2));
                        // let newTotal = response.cartSubTotal - discountAmount;
                        // if(discountAmount){
                        //     $('#total').text(newTotal.toFixed(2));
                        // } else {
                        //     $('#total').text(response.cartSubTotal.toFixed(2));
                        // }
                    }
                });
            }
        });

        $(document).on('change', '.qty', function(){
            let quantity = $(this).val();
            let rowId = $(this).data('row-id');
            let discountAmount = parseFloat($('#discount-amount').text());

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
                        $('#sub-total').text(response.cartSubTotal.toFixed(2));
                        $('#total').text(response.cartSubTotal.toFixed(2));
                        // let newTotal = response.cartSubTotal - discountAmount;
                        // if(discountAmount){
                        //     $('#total').text(newTotal.toFixed(2));
                        // } else {
                        //     $('#total').text(response.cartSubTotal.toFixed(2));
                        // }
                        
                    }
                }
            });
        });

        $('input[name="discount_code"]').on('input', function () {
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
        });

        $('#apply_discount').on('click', function () {
            const discountCode = $('#discount_code').val();
            const subTotal = parseFloat($('#sub-total').text());

            if (discountCode) {
                calculateDiscount(discountCode, subTotal)
            } else {
                $('#applied_code').val('0');
                $('#discount_message').text('Please enter a discount code.').removeClass('text-success').addClass('text-danger');
            }
        });

        function calculateDiscount(discountCode, subTotal){
            $.ajax({
                url: '{{ route("discount.calculate") }}',
                method: 'POST',
                dataType: "json",
                data: {
                    code: discountCode,
                    subTotal: subTotal,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log(response);
                    console.log(response.status);
                    if (response.status === 'success') {
                        $('#applied_code').val(response.data.applied_code);
                        $('#discount_message').text(response.message).removeClass('text-danger').addClass('text-success');

                        $('.discount-info').show();
                        $('#discount-amount').text(response.data.discount_amount);
                        $('#total').text(response.data.new_total);
                    } else {
                        $('#applied_code').val('0');
                        $('#discount_message').text(response.message).removeClass('text-success').addClass('text-danger');
                        $('.discount-info').hide();
                        $('#discount-amount').text('');
                        $('#total').text(subTotal.toFixed(2));
                    }
                },
                error: function (xhr) {
                    $('#applied_code').val('0');
                    $('#discount_message').text('An error occurred. Please try again.').removeClass('text-success').addClass('text-danger');
                }
            });
        }

        
    });
</script>
@endsection