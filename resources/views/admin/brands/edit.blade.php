<!-- resources/views/brands/edit.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Edit Brand</h3>
            </div>
            <div class="card-body">
                @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                <form action="{{ url('admin/brands/'.$brand->id )}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" required class="form-control">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $brand->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $brand->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Brand Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" value="{{ $brand->slug }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-check-label">
                            <input type="checkbox" name="status" value="1" class="form-check-input" {{ $brand->status == 1 ? 'checked' : '' }}>
                            Checked-Hidden, Un-checked- Visible
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection