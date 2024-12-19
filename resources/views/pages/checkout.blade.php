@extends('layout.app')
@section('title', 'Checkout')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('theme/images/background/34.jpg') }})">
        <div class="auto-container">
            <h1>Checkout</h1>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Checkout</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

     <!--CheckOut Page-->
    <section class="checkout-page">
        <div class="auto-container">
            <div class="row">
                <!--Order Box-->
                <div class="col-md-4 order-md-2 order-lg-2 order-1">
                    <div class="order-box">
                        <table>
                            <thead>
                                <tr>
                                    <th class="product-name">Product</th>
                                    <th class="product-total">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                    <tr class="cart-item">
                                        <td class="product-name">
                                            {{ $item['productTitle']}}&nbsp;
                                            <strong class="product-quantity">× {{ $item['quantity']}}</strong>
                                            <p><small>{{ $item['optionNames'] ? implode(', ', $item['optionNames']) : '' }}</small></p>
                                        </td> 
                                        <td class="product-total">
                                            <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{ $currency }}</span>{{ $item['rowTotal']}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal">
                                    <th>Subtotal</th>
                                    <td><span class="amount">{{ $currency . $subTotal}}</span></td>
                                </tr>
                                <tr class="order-total">
                                    <th>Total</th>
                                    <td><strong class="amount">{{ $currency . $subTotal}}</strong> </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!--End Order Box-->

                <!--Checkout Details-->
                <div class="col-md-8 order-md-1 order-lg-1 order-2">
                    <div class="checkout-form">
                        <form method="post" action="checkout.html">
                            <div class="row clearfix">
                                <!--Column-->
                                <div class="column col-lg-12 col-md-12 col-sm-12">
                                    <div class="inner-column">
                                        <div class="sec-title">
                                            <h3>Billing details</h3>
                                        </div>
    
                                        <!--Form Group-->
                                        <div class="form-group">
                                            <div class="field-label">First name <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>
                                        
                                        <!--Form Group-->
                                        <div class="form-group">
                                            <div class="field-label">Last name <sup>*</sup></div>
                                            <input type="text" name="field-name" value="" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--End Checkout Details--> 
            </div>
        </div>
    </section>
    <!--End CheckOut Page-->
@endsection