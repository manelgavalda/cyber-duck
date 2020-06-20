@extends('layouts.auth')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Company edit</h3>
        </div>

        <form role="form" action="{{ route('companies.update', $company) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        placeholder="Name"
                        name="name"
                        value="{{ old('name', $company->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Enter email"
                        name="email"
                        value="{{ old('email', $company->email) }}">
                </div>
                <div class="form-group">
                    <label for="logo">File input</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo"">
                            <label class="custom-file-label" for="logo">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">Upload</span>
                        </div>
                    </div>
                    <img src="{{ asset($company->logo_path) }}" alt="">
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
