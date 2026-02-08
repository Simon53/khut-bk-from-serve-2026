@extends('layout.app')
@section('title', 'Site-Page')
@section('content')

     <!-- ===== section start ===== -->
    <div class="innerBanner">
        @php
            $adminBaseUrl = rtrim(env('ADMIN_BASE_URL'), '/');  
        @endphp    

       
        <img src="{{ $adminBaseUrl . $pages->first()->image }}"  class="img-resize-banner banner-animate">
        
        <div class="d-flex justify-content-center">
            @foreach($pages as $page)
                <h1>{{ $page->page_title }}</h1>
            @endforeach
        </div>
        
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb bg-transparent p-0">
                    @foreach($breadcrumbs as $crumb)
                        <li class="breadcrumb-item">
                            <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                        </li>
                    @endforeach
                </ol>
            </nav>
        </div>  
    </div>
     <div class="ribon"></div>
    <!-- ===== section end ===== -->


    <div class="container topGap-1 site-topGap-1" style="min-height:400px;">
        @foreach($pages as $page)
            <div class="site-page">
                <div>{!! $page->details !!}</div>
            </div>
            <hr>
        @endforeach
    </div>


     
@endsection

@section('script')
<script src="{{asset('/js/jquery-3.6.0.min.js')}}" ></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('/js/swiper-bundle.min.js')}}"></script>
<!-- Custom -->
<script src="{{asset('/js/custom.js')}}"></script>
@endsection