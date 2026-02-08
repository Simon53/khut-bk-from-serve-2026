@extends('layout.app')
@section('title', 'All Khut Stories')
@section('content')
<div class="container my-4">
    <h1 class="mb-4">KHUT STORIES</h1>

    @php
            $adminBaseUrl = rtrim(env('ADMIN_BASE_URL'), '/');  
        @endphp  

    <div class="row">
        @forelse($stories as $story)
            <div class="col-lg-3 col-md-6 col-6 padding-custom-mobile mb-3 story-card">
                <div class="swiper-slide p-2">
                    <a href="{{ route('khut-stories.details', $story->id) }}">
                        <div class="col-md-12 slide-item slide-item-hozoborolo">
                             <img src="{{ $adminBaseUrl . $story->image }}" class="slide-img-new-list" 
                                 alt="{{ $story->title }}">
                        </div>
                    </a>

                    
                   <div class="wiper-slide-info-unique p-4" style="margin-top:-20px">
                        <h5 class="product-title">{{ $story->title }}</h5>
                        <p class="text-muted small">
                            {{ Str::limit(strip_tags($story->subject), 100) }}
                        </p>
                       <a href="{{ route('khut-stories.details', $story->id) }}">
                            Read More >>
                        </a>
                    </div>
                   
                </div>
            </div>
        @empty
            <p>No stories found.</p>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $stories->links() }}
    </div>
</div>
@endsection
