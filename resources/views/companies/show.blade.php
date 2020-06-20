@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Company Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $company->name }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Email</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $company->email }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Website</span>
                                    <span class="info-box-number text-center text-muted mb-0"><a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Logo</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        <img src="{{ asset($company->logo_path) }}" height="235" width="220">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-3">
        <div class="info-box bg-light">
            <div class="info-box-content text-center">
                <span class="info-box-text text-center text-muted">Employees</span>
                @foreach($company->employees as $employee)
                    <a href="{{ route('employees.show', $employee) }}">{{ $employee->fullName }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
