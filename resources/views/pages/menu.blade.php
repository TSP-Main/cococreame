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
                            @for ($i = 1; $i < 12; $i++)
                                <div class="shop-item col-lg-4 col-md-6 col-sm-12">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            <figure class="image"><a href="shop-single.html"><img src="https://via.placeholder.com/300x300" alt=""></a></figure>
                                            <div class="btn-box"><a href="shopping-cart.html">Add to cart</a></div>
                                        </div>
                                        <div class="lower-content">
                                            <h4 class="name"><a href="shop-single.html">Authentic Macaroons</a></h4>
                                            {{-- <div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star light"></span></div> --}}
                                            <div class="price"><del>$29.00</del> $25.00</div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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