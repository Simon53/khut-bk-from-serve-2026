@extends('layout.app')
@section('title', 'Khut Story')
@section('content')

    <style>
        .story-details img,
        .story-details iframe {
            display: block;
            margin: 0 auto; 
        }
        .story-details table tr td{
            padding:20px;
        } 

        .story-details p{
            width:60%;
            margin: 0 auto; 
        } 
    </style>

   <div class="container my-4 custom-link ">
    <div class=" text-center">
        <h1>{{ $story->title }}</h1>
        <p>{{ $story->subject }}</p>
        <div class="story-details" style="text-align:left">
            {!! $story->details !!}
            <div class="text-center"><a href="{{ route('khut-stories.index') }}" class="mt-3 ">Back to All Stories</a></div>
        </div>
    </div>
</div>


     
@endsection

@section('script')
<script src="{{asset('/js/jquery-3.6.0.min.js')}}" ></script>
<script src="{{asset('/js/popper.js')}}"></script>
<script src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>

<!-- Custom -->
<script src="{{asset('/js/custom.js')}}"></script>
@endsection