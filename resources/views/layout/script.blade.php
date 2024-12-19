<script src="{{ asset('theme/js/jquery.js') }}"></script> 
<script src="{{ asset('theme/js/popper.min.js') }}"></script>
<script src="{{ asset('theme/js/bootstrap.min.js') }}"></script>
<!--Revolution Slider-->
<script src="{{ asset('theme/plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ asset('theme/plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ asset('theme/js/main-slider-script.js') }}"></script>
<!--Revolution Slider-->

<script src="{{ asset('theme/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('theme/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('theme/js/owl.js') }}"></script>
<script src="{{ asset('theme/js/wow.js') }}"></script>
<script src="{{ asset('theme/js/appear.js') }}"></script>
<script src="{{ asset('theme/js/select2.min.js') }}"></script>
<script src="{{ asset('theme/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('theme/js/script.js') }}"></script>
{{-- <script src="{{ asset('theme/js/jquery.steps.js') }}"></script> --}}

<!-- Custom Js Code -->
<script>
    /********** Overall Js *********/
    $(document).ready(function() {
        fetchCart();
    });

    // cart item in navbar
    function fetchCart() {
        $.ajax({
            url: "{{ route('cart.fetch') }}",  // Define this route in Laravel
            method: "GET",
            success: function(response) {
                updateCart(response.cart);
            }
        });
    }

    // Update cart in navbar
    function updateCart(cart) {
        $('.cart-btn .count').text(Object.keys(cart).length);
    
        // Clear existing items
        $('.shopping-cart-items').empty();
    
        // Populate cart items
        $.each(cart, function(rowId, item) {
            $('.shopping-cart-items').append(`
                <li class="cart-item">
                    <img src="${item.productImage}" alt="#" class="thumb" />
                    <span class="item-name">${item.productTitle}</span>
                    <span class="item-quantity">${item.quantity} x <span class="item-amount">${ @json($currencySymbol) + item.rowTotal}</span></span>
                    <button class="remove-item" data-row-id="${rowId}"><span class="fa fa-times"></span></button>
                </li>
            `);
        });
    
        // Calculate subtotal
        let subtotal = Object.values(cart).reduce((sum, item) => sum + parseFloat(item.rowTotal), 0);
        $('.shopping-cart-total').html(`<strong>Subtotal:</strong> ${@json($currencySymbol) + subtotal.toFixed(2)}`);
    }
    
    /********* Page Specific Js **********/
    $(function() {
        @stack('script')
    });
</script>