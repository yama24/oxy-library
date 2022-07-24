@extends('auth._layout')
@section('content')
    <div class="card-body">
        <form method="post" action="{{ route('actionlogin') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    id="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password"
                    class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"
                    value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
    <div class="card-footer text-muted">
        <small>
            <a href="{{ route('register') }}" class="float-start">Register</a>
            <a href="{{ route('forgotpassword') }}" class="float-end">Forgot Password</a>
        </small>
    </div>
@endsection
