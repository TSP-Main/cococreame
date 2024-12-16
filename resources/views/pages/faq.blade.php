@extends('layout.app')
@section('title', 'CocoCream | FAQ')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('theme/images/background/34.jpg') }})">
        <div class="auto-container">
            <h1>FAQ</h1>
            <ul class="page-breadcrumb">
                <li><a href="index.html">home</a></li>
                <li>FAQ</li>
            </ul>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Content Elements -->
    <section class="content-elements" id="page">
        <div class="auto-container">
            <!-- Sec title -->
            <div class="sec-title text-center margin-top-50">
                <div class="divider"><img src="{{ asset('theme/images/icons/divider_1.png') }}" alt=""></div>
                <h2>FAQ</h2>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-50">
                    <!--Accordian Box-->
                    <ul class="accordion-box">
                        <!--Block-->
                        <li class="accordion block active-block">
                            <div class="acc-btn active"><div class="icon-outer"><span class="icon fa fa-plus"></span> </div> Etiam hendrerit auctor feugiat</div>
                            <div class="acc-content current">
                                <div class="content">
                                    <div class="text">Nunc pharetra nisl non tellus venenatis, sit amet maximus libero bibendum. Nulla ac mattis eros, id malesuada dolor. Nulla sodales massa ipsum.</div>
                                </div>
                            </div>
                        </li>

                        <!--Block-->
                        <li class="accordion block">
                            <div class="acc-btn"><div class="icon-outer"><span class="icon fa fa-plus"></span> </div>Maecenas ullamcorper lectus finibus</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Lorem ipsum dolor amet consectur adipicing elit eiusmod tempor incididunt ut labore dolore magna aliqua.enim minim veniam quis nostrud exercitation ullamco laboris.</div>
                                </div>
                            </div>
                        </li>
                        
                        <!--Block-->
                        <li class="accordion block">
                            <div class="acc-btn"><div class="icon-outer"><span class="icon fa fa-plus"></span> </div> Nam cursus lacus malesuada ullamcorper</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Lorem ipsum dolor amet consectur adipicing elit eiusmod tempor incididunt ut labore dolore magna aliqua.enim minim veniam quis nostrud exercitation ullamco laboris.</div>
                                </div>
                            </div>
                        </li>

                        <!--Block-->
                        <li class="accordion block">
                            <div class="acc-btn"><div class="icon-outer"><span class="icon fa fa-plus"></span> </div> Nulla erat nibh, tempus in commodo rutrum</div>
                            <div class="acc-content">
                                <div class="content">
                                    <div class="text">Lorem ipsum dolor amet consectur adipicing elit eiusmod tempor incididunt ut labore dolore magna aliqua.enim minim veniam quis nostrud exercitation ullamco laboris.</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--End Content Elements -->
@endsection