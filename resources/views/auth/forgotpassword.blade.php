@extends('auth._layout')
@section('content')
    <div class="card-body">
        <form method="post" action="{{ route('actionforgotpassword') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    id="email" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
    <div class="card-footer text-muted">
        <small>
            <a href="{{ route('register') }}" class="float-start">Register</a>
            <a href="{{ route('login') }}" class="float-end">Login</a>
        </small>
    </div>
@endsection
