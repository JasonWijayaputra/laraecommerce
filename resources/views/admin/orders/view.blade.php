@extends('layouts.admin')
@section('title', 'My Order Details')

@section('content')
<div class="py-3 py-md-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if(session('message'))
                <div class="alert alert-success mb-3">{{ session('message')}}</div>
                @endif
                <div class="shadow bg-white p-3">
                    <h4 class="text-primary">
                        <i class="fa fa-shopping-cart text-dark"></i>User Order Details
                        <a href="{{ url('admin/orders')}}" class="btn btn-danger btn-sm float-end mx-1"><span class="fa fa-arrow-left"></span>Back</a>
                        <a href="{{ url('admin/invoice/'.$order->id.'/generate')}}" class="btn btn-primary btn-sm float-end mx-1"><span class="fa fa-download"></span>Download Invoice</a>
                        <a href="{{ url('admin/invoice/'.$order->id)}}" target="_blank" class="btn btn-warning btn-sm float-end mx-1"><span class="fa fa-eye"></span>View Invoice</a>
                        <a href="{{ url('admin/invoice/'.$order->id.'/mail')}}" class="btn btn-info btn-sm float-end mx-1"><span class="fa fa-eye"></span>Send Invoice Via E-Mail</a>

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

            <div class="card border mt-3">
                <div class="card-body">
                    <h4>Order Process (Order Status Update)</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <form action="{{ url('admin/orders/'.$order->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <label>Update Your Order Status</label>
                                <div class="input-group">
                                    <label>Filter By Status</label>
                                    <select name="order_status" class="form-select">
                                        <option value="">Select Order Status</option>
                                        <option value="in progress" {{ Request::get('status') == 'in progress' ? 'selected': ''}}>In Progress</option>
                                        <option value="completed" {{ Request::get('status') == 'completed' ?'selected': ''}}>Completed</option>
                                        <option value="pending" {{ Request::get('status') == 'pending'? 'selected': ''}}>Pending</option>
                                        <option value="cancelled" {{ Request::get('status') == 'cancelled' ?'selected': ''}}>Cancelled</option>
                                        <option value="out-for-delivery" {{ Request::get('status') == 'out-for-delivery' ?'selected': ''}}>Out for Delivery</option>

                                    </select>
                                    <button type="submit" class="btn btn-primary text-white">Update</button>
                                </div>
                            </form>
                            <div class="col-md-6">
                                <br />
                                <h4 class="mt-3">Current Order Status: <span class="text-uppercase">{{$order->status_message}}</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection