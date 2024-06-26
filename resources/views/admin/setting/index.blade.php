@extends('layouts.admin')
@section('title', 'Admin Setting')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <form action="{{ url('admin/settings')}}" method="POST">
            @csrf
            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h2 class="text-white mb-0">Website</h2>
                </div>
                <p style="color: red;">* is Required</p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Website Name</label>
                        <input type="text" name="website_name" value="{{$setting->website_name ?? ''}}" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Website URL</label>
                        <input type="text" name="website_url" value="{{$setting->website_url ?? ''}}" class="form-control" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Page Title</label>
                        <input type="text" name="title" value="{{$setting->page_title ?? ''}}" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Meta keywords</label>
                        <textarea name="meta_keyword" value="{{$setting->meta_keyword ?? ''}}" class="form-control" rows="3">{{$setting->meta_keyword ?? ''}}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Meta Description</label>
                        <textarea name="meta_description" class="form-control" value="{{$setting->meta_description ?? ''}}" rows="3">{{$setting->meta_description ?? ''}}</textarea>
                    </div>
                </div>
            </div> <!-- Closing .card.mb-3 -->

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website - Information</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Address</label>
                            <textarea name="address" class="form-control" value="{{$setting->address ?? ''}}" rows="3">{{$setting->address ?? ''}}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Phone 1 *</label>
                            <input type="text" name="phone1" value="{{$setting->phone1 ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Phone No. 2</label>
                            <input type="text" name="phone2" value="{{$setting->phone2 ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email Id 1 *</label>
                            <input type="text" name="email1" value="{{$setting->email1 ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email Id 2</label>
                            <input type="text" name="email2" value="{{$setting->email2 ?? ''}}" class="form-control" />
                        </div>
                    </div>
                </div>
            </div> <!-- Closing .card.mb-3 -->

            <div class="card mb-3">
                <div class="card-header bg-primary">
                    <h3 class="text-white mb-0">Website - Social Media</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Facebook (Optional)</label>
                            <input type="text" name="facebook" value="{{$setting->facebook ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Twitter (Optional)</label>
                            <input type="text" name="twitter" value="{{$setting->twitter ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Instagram (Optional)</label>
                            <input type="text" name="instagram" value="{{$setting->instagram ?? ''}}" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>YouTube (Optional)</label>
                            <input type="text" name="youtube" value="{{$setting->youtube ?? ''}}" class="form-control" />
                        </div>
                    </div>
                </div>
            </div> <!-- Closing .card.mb-3 -->

            <div class="text-end">
                <button type="submit" class="btn btn-primary text-white">Save Setting</button>
            </div>
        </form>
    </div>
</div>

@endsection