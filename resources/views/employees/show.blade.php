@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employee Detail</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">First Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->first_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Last Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->last_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Email</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->email }}<span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Phone</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $employee->phone }}<span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-2">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Company</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ optional($employee->company)->name }}<span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
