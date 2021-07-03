@extends('layouts.admin-panel.app')

@section('content')

    <div class="card">
        <div class="card-header"><h2>User Accounts</h2></div>
        <div class="card-body">
            <table class="table">
                <thead>

                </thead>
                <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><img src="{{$user->gravatar_image }}" width="80"></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->posts->count() }}</td>
                                <td>

                                        @if(! $user->isAdmin())
                                        <form action="{{route('users.make-admin', $user->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                Make Admin
                                            </button>
                                        </form>

                                        @else
                                            <form action="{{route('users.revoke-admin', $user->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Revoke Admin
                                                </button>
                                            </form>
                                        @endif


                                </td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="mt-5">
        {{ $users->links('vendor.pagination.bootstrap-4') }}
    </div>
@endsection


