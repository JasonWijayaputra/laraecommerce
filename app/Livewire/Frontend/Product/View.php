<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Exceptions\AlertException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class View extends Component
{
    use LivewireAlert;

    public $category, $product, $prodColorSelectedQuantity, $QuantityCount = 1, $productColorId;

    public function addToWishList($productId)
    {
        if (Auth::check()) {
            if (Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                session()->flash('message', 'Already added to wishlist');
                $this->alert('warning', 'Already Added to Wishlist');
                return false;
            } else {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId,
                ]);
                $this->alert('success', 'WishList Added');
            }
        } else {
            $this->alert('info', 'Please Login to Continue');
            return false;
        }
    }

    public function colorSelected($productColorId)
    {
        $this->productColorId = $productColorId;
        $productColor = $this->product->productColors()->where('id', $productColorId)->first();
        $this->prodColorSelectedQuantity = $productColor->quantity ?? null;

        if ($this->prodColorSelectedQuantity == 0) {
            $this->prodColorSelectedQuantity = 'outOfStock';
        }
    }

    public function incrementQuantity()
    {
        if ($this->QuantityCount < 10) {
            $this->QuantityCount++;
            $this->alert('success', 'Quantity Incremented!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function decrementQuantity()
    {
        if ($this->QuantityCount > 1) {
            $this->QuantityCount--;
            $this->alert('success', 'Quantity Decremented!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function addToCart(int $productId)
    {
        if (Auth::check()) {
            // Check if the product exists
            $product = Product::where('id', $productId)->where('status', '0')->first();

            if ($product) {
                // Check if the product has color options
                if ($product->productColors()->count() > 0) {
                    // Check if a product color is selected
                    if ($this->productColorId != null) {
                        // Check if the selected product color exists
                        $productColor = $product->productColors()->where('id', $this->productColorId)->first();
                        if ($productColor) {
                            // Check if the selected quantity is valid
                            if ($this->QuantityCount > 0 && $this->QuantityCount <= $productColor->quantity) {
                                // Check if the product is not already in the cart
                                if (!Cart::where('user_id', auth()->user()->id)->where('product_id', $productId)->where('product_color_id', $this->productColorId)->exists()) {
                                    Cart::create([
                                        'user_id' => auth()->user()->id,
                                        'product_id' => $productId,
                                        'product_color_id' => $this->productColorId,
                                        'quantity' => $this->QuantityCount
                                    ]);
                                    $this->alert('success', 'Product Added to Cart', [
                                        'position' => 'top-end',
                                        'timer' => 3000,
                                        'toast' => true
                                    ]);
                                } else {
                                    $this->alert('warning', 'Product Already Added', [
                                        'position' => 'top-end',
                                        'timer' => 3000,
                                        'toast' => true
                                    ]);
                                }
                            } else {
                                $this->alert('warning', 'Invalid Quantity Selected', [
                                    'position' => 'top-end',
                                    'timer' => 3000,
                                    'toast' => true
                                ]);
                            }
                        } else {
                            $this->alert('warning', 'Selected Product Color Not Available', [
                                'position' => 'top-end',
                                'timer' => 3000,
                                'toast' => true
                            ]);
                        }
                    } else {
                        $this->alert('warning', 'Please Select a Product Color', [
                            'position' => 'top-end',
                            'timer' => 3000,
                            'toast' => true
                        ]);
                    }
                } else {
                    // Handle case where there are no product colors
                    $this->alert('warning', 'Product Does Not Have Color Options', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true
                    ]);
                }
            } else {
                $this->alert('warning', 'Product Does Not Exist', [
                    'position' => 'top-end',
                    'timer' => 3000,
                    'toast' => true
                ]);
            }
        } else {
            $this->alert('info', 'Please Login to Add to Cart', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true
            ]);
        }
    }

    public function mount($category, $product)
    {
        $this->category = $category;
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'product' => $this->product
        ]);
    }
}
