@extends('_layout')
@section('content')
    <div class="row mt-5">
        <div class="col-12">
            @if (session('warning'))
                <div class="alert alert-warning">
                    <b>Wait!</b> {{ session('warning') }}
                </div>
            @elseif (session('danger'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{ session('danger') }}
                </div>
            @elseif (session('info'))
                <div class="alert alert-info">
                    <b>Yuhu!</b> {{ session('info') }}
                </div>
            @elseif (session('success'))
                <div class="alert alert-success">
                    <b>Yeah!</b> {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <span class="float-start"><b>{{ $title }}</b></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Total Books</th>
                                    <th scope="col">Total Authors</th>
                                    <th scope="col">Total Publishers</th>
                                    <th scope="col">Total Users</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $books }}</td>
                                    <td>{{ $authors }}</td>
                                    <td>{{ $publishers }}</td>
                                    <td>{{ $users }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
