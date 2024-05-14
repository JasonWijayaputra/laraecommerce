@extends('layouts.app')
@section('title', 'My Orders')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="shadow bg-white p-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-4">My Orders</h4>
                    <hr>
                </div>
                <div class="card-body">
                    <!-- <form action="" method="get">
                        <div class="row">
                            <div class="col-md-3"><label>Filter By Date</label></div>
                            <input type="date" name="date" value="{{ Request::get('date') ?? date('Y-m-d')}}" class="form-control" />
                            <div class="col-md-3">
                                <label>Filter By Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="in progress" {{ Request::get('status') == 'in progress' ? 'selected': ''}}>In Progress</option>
                                    <option value="completed" {{ Request::get('status') == 'completed' ?'selected': ''}}>Completed</option>
                                    <option value="pending" {{ Request::get('status') == 'pending'? 'selected': ''}}>Pending</option>
                                    <option value="cancelled" {{ Request::get('status') == 'cancelled' ?'selected': ''}}>Cancelled</option>
                                    <option value="out-for-delivery" {{ Request::get('status') == 'out-for-delivery' ?'selected': ''}}>Out for Delivery</option>

                                </select>
                            </div>
                            <div class="col-md-6">
                                <br />
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>

                        </div>
                    </form> -->
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Order ID</th>
                            <th>Tracking No</th>
                            <th>UserName</th>
                            <th>Payment Mode</th>
                            <th>Ordered Date</th>
                            <th>Status Message</th>
                            <th>Action</th>

                        </thead>
                        <tbody>
                            @forelse($orders as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->tracking_no}}</td>
                                <td>{{$item->fullname}}</td>
                                <td>{{$item->payment_mode}}</td>
                                <td>{{$item->created_at->format('d-m-Y h:i:A')}}</td>
                                <td>{{$item->status_message}}</td>
                                <td>
                                    <a href="{{ url('orders/'.$item->id)}}" class="btn btn-primary btn-sm">View</a>
                                </td>

                            </tr>

                            @empty
                            <tr>
                                <td colspan="7">No Orders Available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection