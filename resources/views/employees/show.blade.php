@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employee Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-lg-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">First Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->first_name }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Last Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->last_name }}</span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Email</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->email }}<span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Phone</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->phone }}<span>
                                </div>
                            </div>
                        </div>
                        @if($employee->company()->exists())
                            <div class="col-12 col-lg-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Company Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        <a href="{{ route('companies.show', $employee->company) }}">{{ $employee->company->name }}</a>
                                    <span>
                                </div>
                            </div>
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Company Logo</span>
                                    <span class="info-box-number text-center text-muted mb-0">
                                        <img src="{{ asset($employee->company->logo_path) }}" height="235" width="220">
                                    <span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
