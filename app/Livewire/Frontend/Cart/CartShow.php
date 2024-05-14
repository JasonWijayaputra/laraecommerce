<?php

namespace App\Livewire\Frontend\Cart;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\Exceptions\AlertException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CartShow extends Component
{
    use LivewireAlert;

    public $cart, $totalPrice = 0;

    public function removeCartItem(int $cartId)
    {
        $cartRemoveData = Cart::where('user_id', auth()->user()->id)->where('id', $cartId)->first();
        if ($cartRemoveData) {
            $cartRemoveData->delete();
            $this->alert('error', 'Cart Item Removed', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            $this->alert('error', 'Something Went Wrong', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }
    public function decrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id', $cartId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cartData) {
            $this->alert('error', 'Cart not found.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        if ($cartData->quantity > 1) {
            $cartData->decrement('quantity');
            $this->alert('success', 'Quantity Decremented!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            $this->alert('error', 'Minimum quantity reached.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function incrementQuantity(int $cartId)
    {
        $cartData = Cart::where('id', $cartId)->where('user_id', auth()->user()->id)->first();
        if ($cartData) {
            if ($cartData->productColor()->where('id', $cartData->product_color_id)->exists()) {
                $productColor = $cartData->productColor()->where('id', $cartData->product_color_id)->first();
                if ($productColor->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                    $this->alert('success', 'Quantity Updated!', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                } else {
                    $this->alert('error', 'Only ' . $productColor->quantity . ' Quantity Are Available', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                }
            } else {

                if ($cartData->product->quantity > $cartData->quantity) {
                    $cartData->increment('quantity');
                    $this->alert('success', 'Quantity Updated!', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                } else {
                    $this->alert('error', 'Only ' . $cartData->product->quantity . ' Quantity Are Available', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                }
            }
        } else {
            $this->alert('error', 'Something Went Wrong', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        $this->cart = Cart::where('user_id', auth()->user()->id)->get();

        return view('livewire.frontend.cart.cart-show', [
            'cart' => $this->cart,
        ]);
    }
}
