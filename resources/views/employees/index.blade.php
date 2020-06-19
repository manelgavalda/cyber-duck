@extends('layouts.auth')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employees</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
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
