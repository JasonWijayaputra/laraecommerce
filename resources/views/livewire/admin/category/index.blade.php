<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form wire:submit.prevent="destroyCategory">
                <div class="modal-body">
                    <h5>Are you sure want to delete this data?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if(session('message'))
        <div class="alert alert-success">{{ session('message')}}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <h1>Category <a href="{{ url('admin/category/create')}}" class="btn btn-primary btn-sm float-end"><i class="fas fa-plus"></i>Add Category</a></h1>
            </div>
            <div class="card-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->status == '1' ? 'Hidden':'Visible'}}</td>
                            <td>
                                <a href="{{ url('admin/category'.$category->id.'/edit')}}" class="btn btn-success">Edit</a>
                                <a href="{{ url('admin/category'.$category->id.'/delete')}}" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">Delete</a>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $categories->links()}}

                </div>
            </div>
        </div>

    </div>
</div>
@push('script')
<script>
    window.addEventListener('close-modal', event => {
        $('#deleteModal').modal('hide');
    });
</script>
@endpush