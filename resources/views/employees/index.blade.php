@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employees</h3>
            <div class="card-tools">
                <a href="{{ route('employees.create') }}">
                    <button type="button" class="btn-lg btn-block btn-outline-primary">
                        Create Employee
                    </button>
                </a>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ optional($employee->company)->name }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}">
                                <button class="btn btn-inline btn-outline-primary">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </button>
                            </a>
                            <a href="{{ route('employees.edit', $employee->id) }}">
                                <button class="btn btn-inline btn-outline-success">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                            <form role="form" action="{{ route('employees.destroy', $employee) }}" method="post">
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
            {{ $employees->links() }}
        </div>
    </div>
@endsection
