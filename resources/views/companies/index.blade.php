@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Companies</h3>
            <div class="card-tools">
                <a href="{{ route('companies.create') }}">
                    <button type="button" class="btn-lg btn-block btn-outline-primary">
                        Create Company
                    </button>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->website }}</td>
                        <td>
                            <a href="{{ route('companies.show', $company->id) }}">
                                <button class="btn btn-inline btn-outline-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>
                            <a href="{{ route('companies.edit', $company->id) }}">
                                <button class="btn btn-inline btn-outline-success">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                            <form role="form" action="{{ route('companies.destroy', $company) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-inline btn-outline-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            {{ $companies->links() }}
        </div>
    </div>
@endsection
