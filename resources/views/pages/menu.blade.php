@extends('layout.app')
@section('title', 'Menu')

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

            <!-- Modal -->
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
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal ENd -->

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
                                            <figure class="image"><a href="shop-single.html">
                                                @if (isset($product['images'][0]['path']))
                                                        <img src="{{ env('SERVER_URL') }}storage/product_images/{{ $product['images'][0]['path'] }}" alt="{{ $product['title'] }}" >
                                                    @else
                                                    <img src="{{ env('SERVER_URL') }}assets/theme/images/default_product_image.jpg" alt="{{ $product['title'] }}" >
                                                @endif
                                            </a></figure>
                                            <div class="btn-box"><a href="shopping-cart.html">Add to cart</a></div>
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
    var isClosed = @json($isClosed);
    if (isClosed) {
        if(@json($code) == '002'){
            $('#opening').text(@json($opening));
            $('#closing').text(@json($closing));
        }
        $('#restaurantModal').modal('show');
    }
@endpush