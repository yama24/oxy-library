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
                    <span class="float-end"><button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                            data-bs-target="#addUser" id="addUserbutton">Add User</button></span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Is Admin?</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1; ?>
                                @foreach ($users as $u)
                                    <tr>
                                        <th scope="row">{{ $num }}</th>
                                        <td>{{ $u->name }}</td>
                                        <td>{{ $u->email }}</td>
                                        <td>{!! $u->admin ? '<span class="badge bg-success">Admin</span>' : '<span class="badge bg-danger">Not Admin</span>' !!}</td>
                                        <td>
                                            <button type="button"
                                                onclick="window.location.href = '{{ route('changestatus', ['id' => $u->id]) }}'"
                                                class="btn btn-sm btn-warning"
                                                {{ session('user')->id == $u->id ? 'disabled' : '' }}>Change Status</button>
                                            <button type="button"
                                                onclick="window.location.href = '{{ route('deleteuser', ['id' => $u->id]) }}'"
                                                class="btn btn-sm btn-danger"
                                                {{ session('user')->id == $u->id ? 'disabled' : '' }}>Delete</button>
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('adduser') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="hidden" name="modalid" value="addUser">
                            <input type="text" name="name"
                                class="form-control  {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email"
                                class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if ($errors->any())
        <span id="modalid" class="d-none">{{ session('modalid') }}</span>
        <script>
            $(document).ready(function() {
                $('#' + $("span#modalid").text() + 'button').click();
            })
        </script>
    @endif
@endsection
