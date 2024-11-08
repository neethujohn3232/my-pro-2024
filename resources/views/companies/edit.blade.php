@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Company</h1>
        <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Company Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $company->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $company->email }}">
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control">
                @if ($company->logo)
                    <img src="{{ asset('storage/logos/' . $company->logo) }}" alt="Logo" width="100" class="mt-2">
                @endif
            </div>
            <div class="mb-3">
                <label for="website" class="form-label">Website</label>
                <input type="url" name="website" id="website" class="form-control" value="{{ $company->website }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
