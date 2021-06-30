@extends('layouts.admin-panel.app')

@section('content')

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('tags.create') }}" class="btn btn-outline-primary">Create Tag</a>
</div>


<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($tags as $tag)
                   <tr>
                       <td>{{ $tag ->name }}</td>
                       <td>
                           <a href="{{ route('tags.edit', $tag->id)}}" class="btn btn-sm btn-primary">Edit</a>
                           <button type="button" class="btn btn-sm btn-danger" onclick="displayModal({{ $tag->id}})" data-toggle="modal" data-target="#deleteModal">Delete</button>
                       </td>
                   </tr>
               @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade"id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="POST" id="deleteTagForm">
            @csrf
            @method('DELETE')
        <div class="modal-body">
          Are you sure you want to delete Tag ?
        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-danger">Delete Tag</button>
        </div>
        </form>
      </div>
    </div>
  </div>


{{ $tags->links('vendor.pagination.bootstrap-4')}}
@endsection


@section('page-level-scripts')
    <script>
        function displayModal(TagId) {
            var url = "/tags/" + TagId;
            $("#deleteTagForm").attr('action', url);
        }
    </script>
@endsection


