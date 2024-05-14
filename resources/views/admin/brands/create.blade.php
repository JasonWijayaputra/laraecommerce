<!-- resources/views/brands/create.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Create Brand</h3>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <form action="{{ url('admin/brands') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" required class="form-control">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Brand Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" name="status" value="1" class="form-check-input">
                            Checked-Hidden, Un-checked- Visible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection