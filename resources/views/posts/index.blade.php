@extends('layouts.admin-panel.app')

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('posts.create') }}" class="btn btn-outline-primary">Add Post</a>
    </div>

    <div class="card">
        <div class="card-header"><h2>Posts</h2></div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Excerpt</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td><img src="{{ asset($post->image_path) }}" width="120"></td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->excerpt }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="displayModal({{ $post->id }})" data-toggle="modal" data-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" id="deletePostForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    Are you sure, you want to delete
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-danger">Delete Post</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="mt-5">
        {{ $posts->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection

@section('page-level-scripts')
    <script>
        function displayModal(postId) {
            var url = "/posts/trash/" + postId;
            $('#deletePostForm').attr('action',url)
        }
    </script>
@endsection
