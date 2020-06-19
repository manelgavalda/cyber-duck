@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Company Detail</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Name</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $company->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Email</span>
                                    <span class="info-box-number text-center text-muted mb-0">{{ $company->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
