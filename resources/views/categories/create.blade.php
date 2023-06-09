@extends('layouts.admin-panel.app')

@section('content')
    <div class="card">

        <div class="card-header"><h2>Add New Category</div>

        <div class="card-body">
            <form action="{{ route('categories.store')}}" method="POST">
                @csrf
                <div class="from-group">
                    <label for="name">Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           value = "{{ old('name') }}"
                           placeholder="Enter Category Name"
                           name="name">
                           @error('name')
                               <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                </div>
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </form>
        </div>

@endsection
