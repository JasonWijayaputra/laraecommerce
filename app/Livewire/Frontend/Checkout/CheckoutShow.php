<?php

namespace App\Livewire\Frontend\Checkout;

use App\Mail\PlaceOrderMailable;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Orderitem;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Midtrans\Config;
use Midtrans\Snap;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;

class CheckoutShow extends Component
{
    use LivewireAlert;
    public $carts, $totalProductAmount = 0;
    public $fullname, $email, $phone, $pincode, $address, $payment_mode = NULL, $payment_id = NULL;
    public $snapTokenUrl = '';

    public function rules()
    {
        return [
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:6|min:6',
            'address' => 'required|string|max:500',

        ];
    }

    public function placeOrder()
    {
        $this->validate();

        // Create the order
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'tracking_no' => 'funda-' . Str::random(10),
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'pincode' => $this->pincode,
            'address' => $this->address,
            'status_message' => 'In Progress',
            'payment_mode'  => $this->payment_mode,
            'payment_id' => $this->payment_id,
        ]);

        // Add order items
        foreach ($this->carts as $cartItem) {
            Orderitem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_color_id' => $cartItem->product_color_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->selling_price
            ]);

            // Decrement product quantity
            if ($cartItem->product_color_id != NULL) {
                $cartItem->productColor()->where('id', $cartItem->product_color_id)->decrement('quantity', $cartItem->quantity);
            } else {
                $cartItem->product()->where('id', $cartItem->product_id)->decrement('quantity', $cartItem->quantity);
            }
        }

        return $order;
    }
    public function codOrder()
    {
        $this->payment_mode = 'Cash On Delivery';
        $codOrder = $this->placeOrder();
        if ($codOrder) {
            Cart::where('user_id', auth()->user()->id)->delete();
            try {
                $order = Order::findOrFail($codOrder->id);
                Mail::to($order->email)->send(new PlaceOrderMailable($order));
            } catch (\Exception $e) {
            }
        }

        $this->alert('success', 'Success Order, wait for 1-3 days!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        return redirect()->to('thank-you');
    }
    public function midtransPayment()
    {
        $this->payment_mode = 'Online Payment';

        // Set Midtrans configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;

        // Transaction details
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $this->totalProductAmount,
        ];

        // Create a new transaction
        $order = $this->placeOrder(); // Save order details before creating a transaction

        // Additional customer details
        $customerDetails = [
            'first_name' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            // Add more customer details as needed
        ];

        try {
            // Generate SNAP token
            $snapToken = Snap::getSnapToken([
                'transaction_details' => $transactionDetails,
                'customer_details' => $customerDetails,
                // Add more configuration options as needed
            ]);

            // Store the generated SNAP token to database
            $order->update([
                'payment_id' => $transactionDetails['order_id'],
                'snap_token' => $snapToken, // Store snap token in the database
            ]);

            // Empty the cart
            $this->emptyCart();
            // Redirect to Midtrans payment page
            return redirect('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken);
        } catch (\Exception $e) {
            // Handle payment initiation error
            $this->alert('error', $e->getMessage(), [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    protected function emptyCart()
    {
        // Delete cart items for the current user
        Cart::where('user_id', auth()->user()->id)->delete();
    }


    // protected function sendSnapTokenToApi($snapToken)
    // {
    //     $client = new Client();
    //     $apiUrl = 'YOUR_API_ENDPOINT'; // Replace with your actual API endpoint URL

    //     try {
    //         // Send POST request to your API endpoint with the SNAP token
    //         $response = $client->post($apiUrl, [
    //             'json' => ['snap_token' => $snapToken],
    //             // Add more options as needed (headers, authentication, etc.)
    //         ]);

    //         // Handle API response as needed
    //         $responseData = $response->getBody()->getContents();
    //         // Process API response...
    //     } catch (\Exception $e) {
    //         // Handle API request error
    //         // Log or display error message...
    //     }
    // }

    public function totalProductAmount()
    {
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        foreach ($this->carts as $cartItem) {
            $this->totalProductAmount += $cartItem->product->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;
    }

    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->email;
        $this->phone = auth()->user()->userDetail->phone;
        $this->pincode = auth()->user()->userDetail->pin_code;
        $this->address = auth()->user()->userDetail->address;

        $this->totalProductAmount = $this->totalProductAmount();

        return view('livewire.frontend.checkout.checkout-show', [
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}
