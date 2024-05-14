@extends('layouts.admin')

@section('content')
<!-- @include('livewire.admin.brand.modal-form') -->

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h1>List Brands <a href="" class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i>Add Brands</a></h1>
            </div>
            <div class="card-body">
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
                                <button wire:click="editBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#updatebrandModal" class="btn btn-sm btn-primary">Edit</button>
                                <button wire:click="deleteBrand({{ $brand->id }})" data-bs-toggle="modal" data-bs-target="#deletebrandModal" class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No data!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection