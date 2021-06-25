@extends('layouts.admin-panel.app')

@section('content')
    <div class="card">

        <div class="card-header"><h2>Add New Tag</div>

        <div class="card-body">
            <form action="{{ route('tags.store')}}" method="POST">
                @csrf
                <div class="from-group">
                    <label for="name">Name</label>
                    <input type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           id="name"
                           value = "{{ old('name') }}"
                           placeholder="Enter Tag Name"
                           name="name">
                           @error('name')
                               <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                </div>
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </form>
        </div>

@endsection
