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
                <!--Order Summary-->
                <div class="col-md-4 order-md-2 order-lg-2 order-1">
                    <div class="order-box">
                        <div class="accordion" id="accordionExample">
                            <div class="card" style="border: 4px solid #5fcac7;">
                              <div class="card-header" id="headingOne" style="background: #5fcac7">
                                <h2 class="mb-0 text-center">
                                  <button class="btn btn-link text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Order Summary
                                  </button>
                                </h2>
                              </div>
                          
                              <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body p-0" >
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name">Product</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartItems as $item)
                                                <tr class="cart-item">
                                                    <td class="product-name">
                                                        {{ $item['productTitle']}}&nbsp;
                                                        <strong class="product-quantity">× {{ $item['quantity']}}</strong>
                                                        <p><small>{{ $item['optionNames'] ? implode(', ', $item['optionNames']) : '' }}</small></p>
                                                    </td> 
                                                    <td class="product-total">
                                                        <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">{{ $currencySymbol }}</span>{{ $item['rowTotal']}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td><span>{{ $currencySymbol }}</span><span class="amount" id="sub-total">{{ $cartSubTotal }}</span></td>
                                            </tr>
                                            @if ($discountCode)
                                                <tr class="discount-div">
                                                    <th>Discount Amount</th>
                                                    <td class="text-right"><span>-{{ $currencySymbol }}</span><span class="amount" id="sub-total">{{ $discountAmount }}</span></td>
                                                </tr>
                                            @endif
                                            <tr class="delivery-charges-div" style="display: none">
                                                <th>Delivery Charges (may vary)
                                                    (Free over £30.00)</th>
                                                <td><span class="amount" id="delivery-charges-amount"></span></td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td><strong>{{$currencySymbol}}</strong><strong class="amount" id="total">{{$cartSubTotal-$discountAmount}}</strong> </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <!--End Order Summary-->

                <!--Checkout Details-->
                <div class="col-md-8 order-md-1 order-lg-1 order-2">
                    <div class="default-tabs tabs-box">
                        <!--Tabs Box-->
                        <ul class="tab-buttons clearfix">
                            <li class="tab-btn active-btn" data-tab="#tab1">Basic Details</li>
                            <li class="tab-btn" data-tab="#tab2">Shipping Details</li>
                            <li class="tab-btn" data-tab="#tab3">Payment</li>
                        </ul>
                    
                        <div class="contact-form">
                            <input type="hidden" id="stripe_key" value="{{ $stripeKey }}">
                            <form  id="checkout-form" action="{{ route('checkout.process') }}" method="post">
                                @csrf
                                <div class="tabs-content">
                                    <!--Tab 1 - Basic Details-->
                                    <div class="tab active-tab" id="tab1">
                                        <div class="basic-detail">
                                            <label>Name:</label>
                                            <div class="form-group">
                                                <input type="text" name="name" class="name" placeholder="Your Name *">
                                            </div>
            
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Phone:</label>
                                                    <div class="form-group">
                                                        <input type="text" name="phone" class="phone" placeholder="Your Phone *">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label>Email:</label>
                                                    <div class="form-group">
                                                        <input type="email" name="email" class="email" placeholder="Your Email *">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <a href="#" class="theme-btn btn-style-two small next-tab" data-next="#tab2">
                                            <span></span>Next<span></span>
                                        </a>
                                    </div>
                        
                                    <!--Tab 2 - Shipping Details-->
                                    <div class="tab" id="tab2">
                                        <div class="shipping-detail">
                                            <div>
                                                <label>Order Type:</label>
                                                <div class="form-group">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-6">
                                                            <div class="form-check h-100 border rounded-3">
                                                                <div class="p-3">
                                                                    <input class="form-check-input" type="radio" name="order_type" id="pickup" value="pickup" required>
                                                                    <label class="form-check-label" for="pickup">
                                                                        Pickup <br>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-check h-100 border rounded-3">
                                                                <div class="p-3">
                                                                    <input class="form-check-input" type="radio" name="order_type" id="delivery" value="delivery" required>
                                                                    <label class="form-check-label" for="delivery">
                                                                        Delivery <br>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="address-details-div" style="display: none">
                                                <label>Address:</label>
                                                <div class="form-group">
                                                    <input type="text" name="address" id="address" placeholder="Type here *">
                                                </div>

                                                <label>Apartment, Suite, etc. (Optional):</label>
                                                <div class="form-group">
                                                    <input type="text" name="apartment" placeholder="Type here">
                                                </div>
                
                                                <div class="row mb-2">
                                                    <div class="col-lg-6">
                                                        <label>City:</label>
                                                        <div class="form-group">
                                                            <input type="text" name="city" id="city" placeholder="Your City *">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <label>Postal Code:</label>
                                                        <div class="form-group">
                                                            <input type="text" name="postcode" id="postcode" placeholder="Your Email">
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="latitude" name="latitude">
                                                <input type="hidden" id="longitude" name="longitude">
                                            </div>

                                            <div>
                                                <label>Add a note to your order (Optional):</label>
                                                <div class="form-group">
                                                    <textarea name="order_note" id="" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <a href="#" class="theme-btn btn-style-two small prev-tab" data-prev="#tab1">
                                            <span></span>Previous<span></span>
                                        </a>
                                        <a href="#" class="theme-btn btn-style-two small next-tab" data-next="#tab3">
                                            <span></span>Next<span></span>
                                        </a>
                                    </div>
                        
                                    <!--Tab 3 - Payment Details-->
                                    <div class="tab" id="tab3">
                                        <div class="payment-detail">
                                            <div>
                                                <label>Payment Option:</label>
                                                <div class="form-group">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-6">
                                                            <div class="form-check h-100 border rounded-3">
                                                                <div class="p-3">
                                                                    <input class="form-check-input" type="radio" name="payment_option" id="cash" value="cash" checked required>
                                                                    <label class="form-check-label" for="cash">
                                                                        Cash <br>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-check h-100 border rounded-3">
                                                                <div class="p-3">
                                                                    <input class="form-check-input" type="radio" name="payment_option" id="online" value="online" required>
                                                                    <label class="form-check-label" for="online">
                                                                        Online <br>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <!-- Stripe Card Fields -->
                                                <div id="stripe-form" class="container mt-4 d-none">
                                                    <div class="form-group mb-3">
                                                        <label for="card-number-element" class="form-label">Card Number</label>
                                                        <div id="card-number-element" class="form-control"></div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="card-expiry-element" class="form-label">Expiry Date</label>
                                                        <div id="card-expiry-element" class="form-control"></div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="card-cvc-element" class="form-label">CVC</label>
                                                        <div id="card-cvc-element" class="form-control"></div>
                                                    </div>
                                                    <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                                    <div class="form-group">
                                                        <button id="submit-payment" type="button" class="btn w-100" style="color: #C36; border: 1px solid #C36; margin-left:0;">Confirm the Payment and Place Order</button>
                                                    </div>
                                                </div>

                                                <div class="mt-2" id="payment-button-container"></div>
                                            </div>
                                        </div>
                        
                                        <a href="#" class="theme-btn btn-style-two small prev-tab" data-prev="#tab2">
                                            <span></span>Previous<span></span>
                                        </a>
                                        <button type="submit" class="theme-btn btn-style-two small" id="place-order">
                                            <span></span>Place Order<span></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--End Checkout Details--> 
            </div>
        </div>
    </section>
    <!--End CheckOut Page-->
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    // stripe payment
    document.addEventListener('DOMContentLoaded', function() {
        let totalBill = $('#total').text() * 100;
        console.log(totalBill);
        const stripe = Stripe(document.getElementById('stripe_key').value);
        const elements = stripe.elements();

        // Create individual elements for card number, expiry, and CVC
        const cardNumber = elements.create('cardNumber');
        const cardExpiry = elements.create('cardExpiry');
        const cardCvc = elements.create('cardCvc');

        // Mount elements to the corresponding divs
        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');

        function updatePaymentForm() {
            const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;
            const stripeForm = document.getElementById('stripe-form');
            const paymentButtonContainer = document.getElementById('payment-button-container'); // Combined container for both Apple Pay and Google Pay
            const placeOrderButton = document.getElementById('place-order');

            if (paymentOption === 'online') {
                stripeForm.classList.remove('d-none');
                paymentButtonContainer.classList.remove('d-none'); // Show payment button container
                placeOrderButton.classList.add('d-none');
            } else {
                stripeForm.classList.add('d-none');
                paymentButtonContainer.classList.add('d-none'); // Hide payment button container
                placeOrderButton.classList.remove('d-none');
            }
        }

        updatePaymentForm();

        document.querySelectorAll('input[name="payment_option"]').forEach(function(element) {
            element.addEventListener('change', updatePaymentForm);
        });

        // Create Payment Request object
        const paymentRequest = stripe.paymentRequest({
            country: 'GB',
            currency: 'gbp',
            total: {
                label: 'Total',
                amount: totalBill,
            },
            requestPayerName: true,
            requestPayerEmail: true,
            requestPayerPhone: true,
            paymentMethodTypes: ['card', 'applePay', 'googlePay'], // No need to specify Google or Apple Pay explicitly here
        });

        const prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
        });

        // Check if Google Pay or Apple Pay is available and then mount the button
        paymentRequest.canMakePayment().then(function(result) {
            if (result && (result.applePay || result.googlePay)) {
                prButton.mount('#payment-button-container');
            } else {
                console.log('Neither Google Pay nor Apple Pay is available');
                document.getElementById('payment-button-container').style.display = 'none';
            }
        });

        // Handle the payment method ID returned from Google Pay/Apple Pay
        paymentRequest.on('paymentmethod', function(ev) {
            const form = document.getElementById('checkout-form');
            let hiddenTokenInput = form.querySelector('input[name="payment_method_id"]');

            if (hiddenTokenInput) {
                hiddenTokenInput.setAttribute('value', ev.paymentMethod.id);
            } else {
                hiddenTokenInput = document.createElement('input');
                hiddenTokenInput.setAttribute('type', 'hidden');
                hiddenTokenInput.setAttribute('name', 'payment_method_id');
                hiddenTokenInput.setAttribute('value', ev.paymentMethod.id);
                form.appendChild(hiddenTokenInput);
            }

            var orderType = @json($orderType);
            if (orderType === 'pickup') {
                form.submit();
            } else {
                checkCustomerLocation();
            }
            ev.complete('success');
        });

        // Card payment submission logic
        document.getElementById('submit-payment').addEventListener('click', function(event) {
            event.preventDefault();
            const paymentOption = document.querySelector('input[name="payment_option"]:checked').value;

            if (paymentOption === 'online') {
                stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber,
                    billing_details: {
                        name: document.querySelector('input[name="name"]').value,
                        email: document.querySelector('input[name="email"]').value,
                        phone: document.querySelector('input[name="phone"]').value
                    }
                }).then(function(result) {
                    if (result.error) {
                        const displayError = document.getElementById('card-errors');
                        displayError.textContent = result.error.message;
                    } else {
                        const form = document.getElementById('checkout-form');
                        let hiddenTokenInput = form.querySelector('input[name="payment_method_id"]');

                        if (hiddenTokenInput) {
                            hiddenTokenInput.setAttribute('value', result.paymentMethod.id);
                        } else {
                            hiddenTokenInput = document.createElement('input');
                            hiddenTokenInput.setAttribute('type', 'hidden');
                            hiddenTokenInput.setAttribute('name', 'payment_method_id');
                            hiddenTokenInput.setAttribute('value', result.paymentMethod.id);
                            form.appendChild(hiddenTokenInput);
                        }

                        var orderType = @json($orderType);
                        if (orderType === 'pickup') {
                            form.submit();
                        } else {
                            checkCustomerLocation();
                        }
                    }
                }).catch(function(error) {
                    console.error('Error creating PaymentMethod:', error);
                });
            } else {
                const form = document.getElementById('checkout-form');
                form.submit();
            }
        });
    });

    // Google map and check delivery radius and dynamic deliver chareges
    let autocomplete;

    const restaurantLat = {{ $restaurantLat }};
    const restaurantLng = {{ $restaurantLng }};
    const deliveryRadius = {{ $deliveryRadius }};
    const currencySymbol = '{{ $currencySymbol }}';
    let cartSubTotal = {{ $cartSubTotal }};
    let freeShippingAmount = {{ $freeShippingAmount }};

    function initAutocomplete() {
        // Initialize autocomplete
        autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));
        autocomplete.setFields(['address_component', 'geometry']);

        autocomplete.addListener('place_changed', function() {
            let place = autocomplete.getPlace();
            if (!place.geometry) {
                alert("No details available for the input: '" + place.name + "'");
                return;
            }

            // Set latitude and longitude in hidden fields
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

            // Autofill the city, postcode, and apartment
            fillInAddress(place);
            geocodePostcode($('#postcode').val());
        });

        // Handle manual postcode entry
        document.getElementById('postcode').addEventListener('blur', function() {
            let postcode = this.value;
            if (postcode) {
                geocodePostcode(postcode);
            }
        });
    }

    function fillInAddress(place) {
        let addressComponents = place.address_components;
        let city = '';
        let postcode = '';
        let apartment = '';

        addressComponents.forEach(component => {
            let types = component.types;

            if (types.includes('postal_code')) {
                postcode = component.long_name;
            }
        });

        // Autofill fields
        document.getElementById('postcode').value = postcode;
    }

    function geocodePostcode(postcode) {
        let geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'address': postcode }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    let location = results[0].geometry.location;

                    // Update latitude and longitude
                    document.getElementById('latitude').value = location.lat();
                    document.getElementById('longitude').value = location.lng();

                    let customerDistanceMeters = calculateDistance(restaurantLat, restaurantLng, location.lat(), location.lng());

                    // Convert distance from meters to kilometers
                    let customerDistanceKm = customerDistanceMeters / 1000;

                    // Get delivery charge based on distance
                    let deliveryCharge = getDeliveryCharge(customerDistanceKm);
                    let discountPrice = $('#discount-price').text();
                    // let subTotal = @json($cartSubTotal);
                    
                    if (cartSubTotal < freeShippingAmount) {
                        $('#delivery-charges-amount').text(currencySymbol + deliveryCharge);
                        $('#total').text((parseFloat(deliveryCharge) + parseFloat(cartSubTotal) - @json($discountAmount)).toFixed(2));

                        $('#discount-bill').text((parseFloat(cartSubTotal) + parseFloat(deliveryCharge) - parseFloat(discountPrice)).toFixed(2));
                    } else {
                        $('#delivery-charges-amount').html('<del>' + currencySymbol + deliveryCharge + '</del>');
                        $('#total').text(cartSubTotal.toFixed(2));

                        $('#discount-bill').text(parseFloat(discountBill).toFixed(2));
                    }

                    // Autofill other address fields based on geocoded result
                    fillInAddress(results[0]);
                }
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    // Check Delivery Radius
    document.getElementById('place-order').addEventListener('click', function(e) {
        e.preventDefault();
        checkCustomerLocation();
    });

    function checkCustomerLocation(){
        if ($('#delivery').is(':checked')) {
            var form = document.getElementById('checkout-form');

            // If the form is not valid, display a validation message
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var customerLat = parseFloat(document.getElementById('latitude').value);
            var customerLng = parseFloat(document.getElementById('longitude').value);

            // Calculate the distance using the Haversine formula
            var distance = calculateDistance(restaurantLat, restaurantLng, customerLat, customerLng);
            console.log('d ' + distance);
            if (distance <= deliveryRadius * 1000) {
                // Proceed with the order
                document.getElementById('checkout-form').submit();
            } else {
                // Show error message
                alert('Sorry, you are outside of our delivery radius.');
            }
        } else {
            var form = document.getElementById('checkout-form');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            document.getElementById('checkout-form').submit();
        }
    }

    function calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Radius of the Earth in meters
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in meters
    }

    function getDeliveryCharge(distance){
        let deliveryCharges = @json($deliveryCharges);

        for (let i = 0; i < deliveryCharges.length; i++) {
            let minDistance = parseFloat(deliveryCharges[i].min_distance);
            let maxDistance = parseFloat(deliveryCharges[i].max_distance);

            if (distance >= minDistance && distance < maxDistance) {
                return deliveryCharges[i].charge;
            }
        }
        return 'Not available';
    }

    // next prev tab
    document.querySelectorAll('.next-tab').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const nextTabId = button.getAttribute('data-next');
            switchTab(nextTabId);
        });
    });

    document.querySelectorAll('.prev-tab').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const prevTabId = button.getAttribute('data-prev');
            switchTab(prevTabId);
        });
    });

    function switchTab(tabId) {
        // Remove active class from all tabs and buttons
        document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active-tab'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active-btn'));

        // Add active class to the selected tab and its corresponding button
        document.querySelector(tabId).classList.add('active-tab');
        document.querySelector(`.tab-btn[data-tab="${tabId}"]`).classList.add('active-btn');
    }

    // show hide address div
    function toggleAddressDetails() {
        if ($('#delivery').is(':checked')) {
            $('.address-details-div').show();
            $('.delivery-charges-div').show();
            $('#address, #city, #postcode').attr('required', true);
        } else {
            $('.address-details-div').hide();
            $('.delivery-charges-div').hide();
            $('#address, #city, #postcode').removeAttr('required');
        }
    }

    $('input[name="order_type"]').on('change', function () {
        let deliveryMiniAmount = @json($deliveryMiniAmount);
        let pickupMiniAmount = @json($pickupMiniAmount);

        toggleAddressDetails();

        var orderType = $(this).val();
        var orderAmount = parseFloat($('#sub-total').text());

        if (orderType === 'pickup' && orderAmount < pickupMiniAmount) {
            alert("Order amount must be at least " + pickupMiniAmount + " for Pickup.");
            $(this).prop('checked', false);
        } else if (orderType === 'delivery' && orderAmount < deliveryMiniAmount) {
            alert("Order amount must be at least " + deliveryMiniAmount + " for Delivery.");
            $(this).prop('checked', false);
        }

        $('#address').val('');
        $('#address').val('');
        $('#apartment').val('');
        $('#postcode').val('');
    });
</script>
@endsection