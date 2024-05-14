<?php

namespace App\Livewire\Frontend;

use App\Models\Wishlist;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WishListShow extends Component
{
    use LivewireAlert;

    public function removeWishlistItem(int $wishlistId)
    {
        Wishlist::where('user_id', auth()->user()->id)->where('id', $wishlistId)->delete();

        $this->alert('success', 'Wishlist Item Removed Successfully', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('livewire.frontend.wish-list-show', [
            'wishlist' => $wishlist
        ]);
    }
}
