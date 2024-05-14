@extends('layouts.app')
@section('title', 'Home Page')
@section('content')
<div id="carouselExampleCaptions" class="carousel slide">
    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        @forelse($sliders as $key => $sliderItem)
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $key }}"></button>
        @empty
        <!-- No sliders -->
        @endforelse
    </div>
    <!-- Carousel Inner -->
    <div class="carousel-inner">
        @forelse($sliders as $key => $sliderItem)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
            @if ($sliderItem->image)
            <img src="{{ asset($sliderItem->image) }}" class="d-block w-100" alt="Slide {{ $key }}" width="800" height="400">
            @endif
            <div class="carousel-caption d-none d-md-block">
                <div class="custom-carousel-content">
                    <h1>{!! $sliderItem->title !!}</h1>
                    <p>{!! $sliderItem->description !!}</p>
                    <div>
                        <a href="#" class="btn btn-slider">
                            Get Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- No sliders -->
        @endforelse
    </div>
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h4>Welcome to Funda of Web IT E-Commerce</h4>
                <div class="underline"></div>
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <h4>Trending Products</h4>
            <div class="underline"></div>
            @forelse($trendingProducts as $productItem)
            <div class="col-md-3">
                <div class="item">
                    <div class="product-card">
                        <div class="product-card-img">
                            <label class="stock bg-danger">New</label>
                            @if($productItem->productImages->count() > 0)
                            <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                <img src="{{ asset($productItem->productImages[0]->image)}}" alt="{{$productItem->name}}" width="250" height="250">
                            </a>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <p class="product-brand">{{$productItem->brand}}</p>
                            <h5 class="product-name">
                                <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                    {{$productItem->name}}
                                </a>
                            </h5>
                            <div>
                                <span class="selling-price">@rupiah($productItem->selling_price)</span>
                                <span class="original-price">@rupiah($productItem->original_price)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="product-card">
                <div class="p-2">
                    <h4>No Products Available for {{$category->name}}</h4>
                </div>
            </div>
            @endforelse

        </div>
    </div>
</div>
<div class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <h4>New Arrivals</h4>
            <div class="underline mb-4"></div>
            <div class="row">
                @forelse($newArrivalsProducts as $productItem)
                <div class="col-md-3">
                    <div class="item">
                        <div class="product-card">
                            <div class="product-card-img">
                                <label class="stock bg-danger">New</label>
                                @if($productItem->productImages->count() > 0)
                                <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                    <img src="{{ asset($productItem->productImages[0]->image)}}" alt="{{$productItem->name}}" width="250" height="250">
                                </a>
                                @endif
                            </div>
                            <div class="product-card-body">
                                <p class="product-brand">{{$productItem->brand}}</p>
                                <h5 class="product-name">
                                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                        {{$productItem->name}}
                                    </a>
                                </h5>
                                <div>
                                    <span class="selling-price">@rupiah($productItem->selling_price)</span>
                                    <span class="original-price">@rupiah($productItem->original_price)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12 p-2">
                    <h4>No Products Available</h4>
                </div>
                @endforelse
            </div>
            <div class="text-center">
                <a href="{{ url('collections')}}" class="btn btn-warning px-3">View More</a>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h4>Featured Products</h4>
                <a href="{{ url('featured-products')}}" class="btn btn-warning float-end">View More</a>
                <div class="underline"></div>
                <div class="row">
                    @forelse($featuredProducts as $productItem)
                    <div class="col-md-3">
                        <div class="item">
                            <div class="product-card">
                                <div class="product-card-img">
                                    <label class="stock bg-danger">New</label>
                                    @if($productItem->productImages->count() > 0)
                                    <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                        <img src="{{ asset($productItem->productImages[0]->image)}}" alt="{{$productItem->name}}" width="250" height="250">
                                    </a>
                                    @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{$productItem->brand}}</p>
                                    <h5 class="product-name">
                                        <a href="{{url('/collections/'.$productItem->category->slug.'/'.$productItem->slug)}}">
                                            {{$productItem->name}}
                                        </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">@rupiah($productItem->selling_price)</span>
                                        <span class="original-price">@rupiah($productItem->original_price)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-md-12 p-2">
                        <h4>No Featured Products Available</h4>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('carouselExampleCaptions').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            nav: true
        });
    });
</script>
@endpush