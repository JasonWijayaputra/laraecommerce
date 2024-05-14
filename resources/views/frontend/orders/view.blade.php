@extends('layouts.app')
@section('title', 'My Order Details')

@section('content')
<div class="py-3 py-md-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="shadow bg-white p-3">
                    <h4 class="text-primary">
                        <i class="fa fa-shopping-cart text-dark"></i>My Order Details
                        <a href="{{ url('orders')}}" class="btn btn-danger btn-sm float-end">Back</a>
                    </h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <hr>
                            <h5>Order ID: {{$order->id}}</h5>
                            <h5>Tracking ID/No. : {{$order->tracking_no}}</h5>
                            <h5>Order Created Date: {{$order->created_at->format('d-m-Y h:i A')}}</h5>
                            <h5>Payment Mode: {{$order->payment_mode}}</h5>
                            <h5 class="border p-2 text-success">
                                Order Status Message: <span class="text-uppercase">{{$order->status_message}}</span>
                            </h5>

                        </div>
                        <div class="col-md-6">
                            <h5>User Details</h5>
                            <hr>
                            <h5>FullName: {{$order->fullname}}</h5>
                            <h5>Email ID: {{$order->email}}</h5>
                            <h5>Phone: {{$order->phone}}</h5>
                            <h5>Address: {{$order->address}}</h5>
                            <h5>Pin Code: {{$order->pincode}}</h5>



                        </div>
                    </div>
                    <br />
                    <h5>Order Items</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalPrice = 0;
                                @endphp
                                @foreach($order->orderItems as $orderItem)
                                <tr>
                                    <td with="10%">{{$orderItem->id}}</td>
                                    <td width="10%">
                                        @if($orderItem->product->productImages)
                                        <img src="{{ asset($orderItem->product->productImages[0]->image)}}" style="width: 50px; height: 50px" alt="">
                                        @else
                                        <img src="" style="width: 50px; height: 50px" alt="">
                                        @endif

                                    </td>
                                    <td>
                                        {{ $orderItem->product->name}}
                                        @if($orderItem->productColor)
                                        <br />
                                        @if($orderItem->productColor->color)
                                        <span>With Color: {{ $orderItem->productColor->color->name}}</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td width="10%" class="fw-bold">Rp.{{$orderItem->price}}</td>
                                    <td width="10%">{{$orderItem->quantity}}</td>
                                    <td width="10%" class="fw-bold">Rp.{{$orderItem->quantity * $orderItem->price}}</td>
                                    @php
                                    $totalPrice += $orderItem->quantity * $orderItem->price;
                                    @endphp
                                </tr>

                                @endforeach
                                <tr>
                                    <td colspan="5" class="fw-bold text-center">Total Amount:</td>
                                    <td class="fw-bold">Rp.{{ $totalPrice }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection