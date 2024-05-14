<div>
    <div class="py-3 py-md-5">
        <div class="container">
            @if(session()->has('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
            @endif
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border" wire:ignore>
                        @if($product->productImages)
                        <div class="exzoom" id="exzoom">
                            <div class="exzoom_img_box">
                                <ul class='exzoom_img_ul'>
                                    @foreach($product->productImages as $itemImg)
                                    <li><img src="{{asset($itemImg->image)}}" /></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="exzoom_nav"></div>
                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn">
                                    < </a>
                                        <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                            </p>
                        </div>
                        @else
                        No Image Added
                        @endif
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        @if($product)
                        <h4 class="product-name">
                            {{ $product->name }}
                            <label class="btn-sm py-1 mt-2 text-white bg-success"> IN STOCK</label>
                        </h4>
                        <hr>
                        <p class="product-path">
                            Home / {{ $category->name }} / {{ $product->name }}
                        </p>
                        <div>
                            <span class="selling-price">Rp. {{ $product->selling_price }}</span>
                            <span class="original-price">Rp. {{ $product->original_price }}</span>
                        </div>
                        <div>
                            @if($product->productColors->isNotEmpty())
                            @foreach($product->productColors as $colorItem)
                            <label class="colorSelectionLabel rounded" style="background-color: {{ $colorItem->color->code }}; cursor: pointer;" wire:click="colorSelected({{ $colorItem->id }})">
                                {{ $colorItem->color->name }}
                            </label>
                            @endforeach
                            <div>
                                @if($prodColorSelectedQuantity == 'outOfStock')
                                <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                                @elseif($prodColorSelectedQuantity > 0)
                                <label class="btn-sm py-1 mt-2 text-white bg-success"> IN STOCK</label>
                                @endif
                            </div>
                            @else
                            @if($product->quantity)
                            <label class="stock bg-success">In Stock</label>
                            @else
                            <label class="stock bg-success">Out of Stock</label>
                            @endif
                            @endif
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <button class="btn btn1" wire:click="decrementQuantity" wire:loading.attr="disabled"><i class="fa fa-minus"></i></button>
                                <input type="text" wire:model="QuantityCount" class="input-quantity" />
                                <button class="btn btn1" wire:click="incrementQuantity" wire:loading.attr="disabled"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" wire:click="addToCart({{ $product->id }})" class="btn btn1">
                                <i class="fa fa-shopping-cart"></i> Add To Cart
                            </button>
                            <button type="button" wire:click="addToWishList({{ $product->id }})" class="btn btn1">
                                <span wire:loading.remove wire:target="addToWishList">
                                    <i class="fa fa-heart"></i> Add To Wishlist
                                </span>
                                <span wire:loading wire:target="addToWishList">Adding...</span>
                            </button>
                        </div>
                        <div class=" mt-3">
                            <h5 class="mb-0">Small Description</h5>
                            <p>{!! $product->small_description !!}</p>
                        </div>
                        @else
                        <p>Product not found.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Description</h4>
                        </div>
                        <div class="card-body">
                            @if($product)
                            <p>{!! $product->description !!}</p>
                            @else
                            <p>No description available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 py-md-5 bg-white">
        <div class="container">
            <div class="row">
                <div class="item mb-3">
                    <h3>Related
                        @if($category) {{$category->name}} @endif
                        Products</h3>
                    <div class="underline"></div>
                    <div class="col-md-12">
                        @if($category)
                        <div class="owl-carousel owl-theme four-carousel">
                            @foreach($category->relatedProducts as $relatedProductItem)
                            <div class="item mb-3">
                                <div class="product-card-img">
                                    @if($relatedProductItem->productImages->count() > 0)
                                    <a href="{{url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug)}}">
                                        <img src="{{ asset($relatedProductItem->productImages[0]->image)}}" alt="{{$relatedProductItem->name}}">
                                    </a>
                                    @endif
                                </div>
                                <div class="product-card-body">
                                    <p class="product-brand">{{$relatedProductItem->brand}}</p>
                                    <h5 class="product-name">
                                        <a href="{{url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug)}}">
                                            {{$relatedProductItem->name}}
                                        </a>
                                    </h5>
                                    <div>
                                        <span class="selling-price">@rupiah($relatedProductItem->selling_price)</span>
                                        <span class="original-price">@rupiah($relatedProductItem->original_price)</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-2">
                            <h4>No Related Products Available</h4>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="item mb-3">
                    <h3>Related
                        @if($category) {{$category->brand}} @endif
                        Products
                    </h3>
                    <div class="underline"></div>
                </div>
                <div class="col-md-12">
                    @if($category)
                    <div class="owl-carousel owl-theme four-carousel">
                        @foreach($category->relatedProducts as $relatedProductItem)
                        <div class="item mb-3">
                            <div class="product-card-img">
                                @if($relatedProductItem->productImages->count() > 0)
                                <a href="{{url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug)}}">
                                    <img src="{{ asset($relatedProductItem->productImages[0]->image)}}" alt="{{$relatedProductItem->name}}">
                                </a>
                                @endif
                            </div>
                            <div class="product-card-body">
                                <p class="product-brand">{{$relatedProductItem->brand}}</p>
                                <h5 class="product-name">
                                    <a href="{{url('/collections/'.$relatedProductItem->category->slug.'/'.$relatedProductItem->slug)}}">
                                        {{$relatedProductItem->name}}
                                    </a>
                                </h5>
                                <div>
                                    <span class="selling-price">@rupiah($relatedProductItem->selling_price)</span>
                                    <span class="original-price">@rupiah($relatedProductItem->original_price)</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="col-md-12 p-2">
                        <h4>No Related Products Available</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function() {
        $("#exzoom").exzoom({
            "navWidth": 60,
            "navHeight": 60,
            "navItemNum": 5,
            "navItemMargin": 7,
            "navBorder": 1,
            "autoPlay": true,
            "autoPlayTimeout": 2000
        });
    });

    $('.four-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
</script>
@endpush