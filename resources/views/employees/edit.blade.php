@extends('layouts.auth')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit Employee</h3>
        </div>

        <form role="form" action="{{ route('employees.update', $employee) }}" method="post">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input
                        type="text"
                        class="form-control"
                        id="first_name"
                        placeholder="First Name"
                        name="first_name"
                        value="{{ old('first_name', $employee->first_name) }}">
                </div>
                @error('first_name')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="first_name">Last Name *</label>
                    <input
                        type="text"
                        class="form-control"
                        id="last_name"
                        placeholder="Last Name"
                        name="last_name"
                        value="{{ old('last_name', $employee->last_name) }}">
                </div>
                @error('last_name')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        placeholder="Enter email"
                        name="email"
                        value="{{ old('email', $employee->email) }}">
                </div>
                @error('email')
                    <p style="color:red">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input
                        type="text"
                        class="form-control"
                        id="phone"
                        placeholder="Enter phone"
                        name="phone"
                        value="{{ old('phone', $employee->phone) }}">
                </div>

                <div class="form-group">
                    <label>Company</label>
                    <select class="form-control" name="company_id">
                        <option value="">Select one...</option>
                        @foreach($companies as $company)
                            <option @if($employee->company_id == $company->id) selected @endif value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
