@extends('auth._layout')
@section('content')
    <div class="card-body">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Email sent!</h4>
            <p>Please check your email immediately because the password reset url is only valid for 5 minutes</p>
        </div>
    </div>
    <div class="card-footer text-muted">
        <small>
            <a href="{{ route('register') }}" class="float-start">Register</a>
            <a href="{{ route('login') }}" class="float-end">Login</a>
        </small>
    </div>
@endsection
