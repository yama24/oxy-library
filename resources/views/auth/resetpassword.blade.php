@extends('auth._layout')
@section('content')
    <div class="card-body">
        <form method="post" action="{{ route('actionresetpassword') }}">
            @csrf
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password"
                    class="form-control  {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password"
                    value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Reset</button>
        </form>
    </div>
    <div class="card-footer text-muted">
        <small>
            <a href="{{ route('register') }}" class="float-start">Register</a>
            <a href="{{ route('login') }}" class="float-end">Login</a>
        </small>
    </div>
@endsection
