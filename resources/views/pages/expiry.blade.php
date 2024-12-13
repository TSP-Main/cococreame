@extends('layout.app')
@section('title', 'CocoCream | FAQ')

@section('content')
    <!--Page Title-->
    <section class="page-title" style="background-image:url({{ asset('theme/images/background/34.jpg') }})">
        <div class="auto-container">
            <h1>Inactive or Expired</h1>
        </div>
    </section>
    <!--End Page Title-->

    <!-- Content Elements -->
    <section class="content-elements" id="page">
        <div class="auto-container">
            <!-- Sec title -->
            <div class="sec-title text-center margin-top-50">
                <div class="divider"><img src="{{ asset('theme/images/icons/divider_1.png') }}" alt=""></div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 margin-bottom-50">
                    <h1>Your restaurant is inactive or expired. Kindly contact to admin</h1>
                </div>
            </div>
        </div>
    </section>
    <!--End Content Elements -->
@endsection