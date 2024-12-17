@extends('layout.app')
@section('title', 'Menu')

@push('style')
    .add-to-cart-btn {
        position: relative;
        display: inline-block;
        padding: 5px 15px;
        font-weight: 500;
        text-align: center;
        white-space: nowrap;
        font-size: 16px;
        line-height: 25px;
        color: #4b4342;
        background-color: #ffffff;
        border-radius: 30px;
        -webkit-transition: all 300ms ease;
        -moz-transition: all 300ms ease;
        -ms-transition: all 300ms ease;
        -o-transition: all 300ms ease;
        transition: all 300ms ease;
    }
    .add-to-cart-btn:hover {
        background-color: #4b4342;
        color: #ffffff;
    }
@endpush

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('theme/images/background/34.jpg') }})">
        <div class="auto-container">
            <h1>Menu</h1>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>Menu</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!--Sidebar Page Container-->
    <div class="sidebar-page-container">
        <div class="auto-container">
            {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testModal">
                Launch Modal
            </button> --}}

            <!-- Restaurant Schedule Modal -->
            <div class="modal fade" id="restaurantModal">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Restaurant Closed</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center" id="schedule-msg">Sorry, we are currently closed or out of operating hours.</p>
                            @if ($code == '002')
                                <hr>
                                <p>Opening <span class="float-right" id="opening"></span></p>
                                <p>Closing <span class="float-right" id="closing"></span></p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('home') }}">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Go to home</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ENd -->

            <!-- Product Options Modal -->
            <div class="modal fade" id="productOptionsModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="productTitle"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="productId" />
                            <input type="hidden" id="productImage" />
                            <div class="options"></div>
                            <div class="instruction"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="modalAddToCartBtn" class="btn btn-success" data-dismiss="modal">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Options Modal End -->

            <div class="row clearfix">
                <!--Content Side-->
                <div class="content-side col-lg-9 col-md-12 col-sm-12">
                    <div class="our-shop">
                        <div class="shop-upper-box clearfix">
                            <div class="items-label">Showing all 12 results</div>
                            <div class="orderby">
                                <select name="orderby" class="sortby-select select2-offscreen">
                                    <option value="price" >Sort by price: low to high</option>
                                    <option value="price-desc" >Sort by price: high to low</option>
                                </select>
                            </div>
                        </div>

                        <div class="row clearfix">
                            @foreach ($menus as $product)
                                <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image">
                                                <a href="#">
                                                    <img src="{{ isset($product['images'][0]['path']) ? env('SERVER_URL') . 'storage/product_images/' . $product['images'][0]['path'] : env('SERVER_URL') . 'assets/theme/images/default_product_image.jpg' }}" alt="{{ $product['title'] }}">
                                                </a>
                                            </figure>
                                            <div class="btn-box">
                                                <button class="add-to-cart-btn" 
                                                    data-id="{{ $product['id'] }}" 
                                                    data-title="{{ $product['title'] }}" 
                                                    data-price="{{ $product['price'] }}" 
                                                    data-image="{{ isset($product['images'][0]['path']) ? env('SERVER_URL') . 'storage/product_images/' . $product['images'][0]['path'] : env('SERVER_URL') . 'assets/theme/images/default_product_image.jpg' }}"
                                                    data-instruction="{{$product['ask_instruction']}}"
                                                    data-has-options="{{ !empty($product['options']) ? 'true' : 'false' }}"
                                                    data-options="{{ json_encode($product['options']) }}">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                        <div class="lower-content">
                                            <h4 class="name"><a href="shop-single.html">{{ $product['title'] }}</a></h4>
                                            <div class="price">{{ $currencySymbol . $product['price'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!--Sidebar Side-->
                <div class="sidebar-side sticky-container col-lg-3 col-md-12 col-sm-12">
                    <aside class="sidebar theiaStickySidebar">
                        <div class="sticky-sidebar">
                            <!-- Search Widget -->
                            <div class="sidebar-widget search-widget">
                                <form method="post" action="contact.html">
                                    <div class="form-group">
                                        <input type="search" name="search-field" value="" placeholder="Search products…" required>
                                        <button type="submit"><span class="icon fa fa-search"></span></button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tags Widget -->
                            <div class="sidebar-widget tags-widget">
                                <h3 class="widget-title">Categories</h3>
                                <ul class="tag-list clearfix">
                                    <li><a href="#">Bars</a></li>
                                    <li><a href="#">Caramels</a></li>
                                    <li><a href="#">Chocolate</a></li>
                                    <li><a href="#">Fruit</a></li>
                                    <li><a href="#">Nuts</a></li>
                                    <li><a href="#">Toffees</a></li>
                                    <li><a href="#">Top Rated</a></li>
                                    <li><a href="#">Truffles</a></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!--End Sidebar Page Container-->
@endsection

@push('script')
let isClosed = @json($isClosed);
    if (isClosed) {
        if(@json($code) == '002'){
            $('#opening').text(@json($opening));
            $('#closing').text(@json($closing));
        }
        $('#restaurantModal').modal('show');
    }

    {{-- modal add to cart btn event --}}
    $('#modalAddToCartBtn').off('click').on('click', function() {
        let productId = $('#productId').val();
        let productTitle = $('#productTitle').text();
        let productImage = $('#productImage').val();
        {{-- let productDetail = $('#productDetail').data('product-detail'); --}}
        let productInstruction = $('#productInstruction').val() ?? null;
        let selectedOptions = {};
        let selectedOptionNames = [];
        let valid = true;

        $('.option-group').each(function() {
            var optionGroupId = $(this).data('option-id');
            var optionType = $(this).find('h6').text().includes('(Required)') ? 1 : 2;

            var selectedOption = [];
            if (optionType == 1) {
                var checkedRadio = $(this).find('input[type=radio]:checked');
                if (checkedRadio.length === 0) {
                    valid = false;
                    $(this).find('.required-warning').removeClass('d-none');
                } else {
                    $(this).find('.required-warning').addClass('d-none');
                    selectedOption.push(checkedRadio.val());
                    selectedOptionNames.push(checkedRadio.data('option-name'));
                }
            } else {
                $(this).find('input[type=checkbox]:checked').each(function() {
                    selectedOption.push($(this).val());
                    selectedOptionNames.push($(this).data('option-name'));
                });
            }

            if (selectedOption.length > 0) {
                selectedOptions[optionGroupId] = selectedOption;
            }
        });

        if (valid) {
            let cartData = {
                id: productId,
                title: productTitle,
                image: productImage,
                options: selectedOptions,
                optionNames: selectedOptionNames,
                product_instruction: productInstruction
            };
            addToCart(cartData);
        }
    });

    {{-- Direct Add to cart btn event --}}
    $(document).on('click', '.add-to-cart-btn', function() {
        let hasOptions = $(this).data('has-options');
        let currencySymbol = @json($currencySymbol);

        let productData = {
            id: $(this).data('id'),
            title: $(this).data('title'),
            price: $(this).data('price'),
            image: $(this).data('image'),
        };

        if (hasOptions) {
            let productId = productData.id;
            let productTitle = productData.title;
            let productImage = productData.image;
            let optionsHtml = '';
            let instructionHtml = '';
            let productOptions = $(this).data('options');

            $('#productTitle').text(productTitle);
            $('#productId').val(productId);
            $('#productImage').val(productImage);
            
            productOptions.forEach(function(optionGroup) {
                optionsHtml += '<div class="option-group" data-option-id="' + optionGroup.option.id + '">';
                optionsHtml += '<h6>' + optionGroup.option.name;
                
                // Show required or optional based on option type
                if (optionGroup.option.option_type == 1) {
                    optionsHtml += ' (Required)';
                } else if (optionGroup.option.option_type == 2) {
                    optionsHtml += ' (Optional)';
                }
                optionsHtml += '</h6>';
                
                // Add warning message for required options
                if (optionGroup.option.option_type == 1) {
                    optionsHtml += '<p class="text-danger d-none required-warning" data-option-id="' + optionGroup.option.id + '">Please select one option.</p>';
                }

                if (optionGroup.option.option_values && optionGroup.option.option_values.length > 0) {
                    optionGroup.option.option_values.forEach(function(optionValue) {
                        optionsHtml += '<div class=" p-0 form-check d-flex bd-highlight mb-3  align-items-center">';
                        
                        // Use radio buttons for option type 1
                        if (optionGroup.option.option_type == 1) {
                            optionsHtml += '<input class=" ms-2 p-2 bd-highlight" type="radio" name="option_' + optionGroup.option.id + '" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                        } 
                        // Use checkboxes for option type 2
                        else if (optionGroup.option.option_type == 2) {
                            optionsHtml += '<input class=" ms-2 p-2 bd-highlight" type="checkbox" name="option_' + optionGroup.option.id + '[]" id="option_' + optionValue.id + '" value="' + optionValue.id + '" data-option-name="' + optionValue.name +'">';
                        }

                        optionsHtml += '<label class=" ms-2 form-check-label" for="option_' + optionValue.id + '">' + optionValue.name + '</label>';
                        if (optionValue.price) {
                            optionsHtml += '<span class="ms-auto p-2 bd-highlight" >' + currencySymbol + optionValue.price + '</span>';
                        }
                        optionsHtml += '</div>';
                    });
                }
                optionsHtml += '</div>';
            });

            if ($(this).data('instruction') == 1) {
                instructionHtml = '<hr><textarea name="productInstruction" id="productInstruction" class="form-control" rows="3" placeholder="Enter any special instructions here..."></textarea>';
            } else {
                instructionHtml = '';
            }

            $('.options').html(optionsHtml);
            $('.instruction').html(instructionHtml);

            $('#productOptionsModal').modal('show');
        } else {
            addToCart(productData);
        }
    });
    
    function addToCart(productData) {
        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                ...productData
            },
            success: function(response) {
                alert(response.message);
                updateCart(response.cart);
            }
        });
    }

    {{-- update navbar cart --}}
    function updateCart(cart) {
        // Update cart count
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
    
@endpush