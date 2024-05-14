<!-- resources/views/brands/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1>List Brands</h1>
                <a href="{{ url('admin/brands/create') }}" class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i> Add Brands</a>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->status == '1' ? 'hidden' : 'visible' }}</td>
                            <td>
                                <a href="{{ url('admin/brands/'.$brand->id.'/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="{{ url('admin/brands/'.$brand->id. '/delete')}}" onclick return confirm('Are you sure want to delete?') class="btn btn-danger btn-sm">Delete

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No data!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection