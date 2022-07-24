@extends('auth._layout')
@section('content')
    <div class="card-body">
        <form method="post" action="{{ route('actionregister') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}"
                    id="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                @endif
            </div>
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
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <div class="card-footer text-muted">
        <small>
            <a href="{{ route('login') }}" class="float-start">Login</a>
        </small>
    </div>
@endsection
