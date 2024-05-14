@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message')}}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3>Edit Color</h3>
            </div>
            <div class="card-body">
                <form action="{{ url('admin/colors/'.$color->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Color Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $color->name }}">
                    </div>
                    <div class="mb-3">
                        <label>Color Code</label>
                        <input type="text" name="code" class="form-control" value="{{ $color->code }}">
                    </div>
                    <div class="mb-3">
                        <label>Status</label><br>
                        <input type="checkbox" name="status" style="width:50px; height:50px;" {{ $color->status ? 'checked' : '' }}>
                        Checked=Hidden, Unchecked=Visible
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection