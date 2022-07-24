<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ $title }}</title>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><b>{{ env('APP_NAME') }}</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ $title == 'Dashboard' ? 'active' : '' }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="/books" class="nav-link {{ $title == 'Books' ? 'active' : '' }}">Books</a>
                    </li>
                    <li class="nav-item">
                        <a href="/users" class="nav-link {{ $title == 'Users' ? 'active' : '' }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="/actionlogout" class="nav-link">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="padding-top: 70px;">
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
                        <span class="float-end"><button type="button" class="btn btn-sm btn-success"
                                data-bs-toggle="modal" data-bs-target="#addBook" id="addbookbutton">Add
                                Book</button></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Cover</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Publisher</th>
                                        <th scope="col">Printing Date</th>
                                        <th scope="col">Uploader</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $num = ($books->currentPage() - 1) * 10 + 1; ?>
                                    @foreach ($books as $b)
                                        <tr>
                                            <th scope="row">{{ $num }}</th>
                                            <td>{{ $b->title }}</td>
                                            <td><img data-bs-toggle="popover" title="{{ $b->title }}"
                                                    data-bs-html="true"
                                                    data-bs-content='<img src="{{ asset(Storage::url('cover/' . $b->cover)) }}" alt="{{ $b->title }}" class="img-fluid">'
                                                    src="{{ asset(Storage::url('cover/' . $b->cover)) }}"
                                                    alt="{{ $b->title }}" class="img-thumbnail" width="70px">
                                            </td>
                                            <td>{{ $b->author }}</td>
                                            <td>{{ $b->publisher }}</td>
                                            <td>{{ $b->printing_date }}</td>
                                            <td>{{ $b->uploader->name }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-success" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editBook{{ $b->id }}">edit</button>
                                                <a href="{{ route('deletebook', ['id' => $b->id]) }}"
                                                    class="btn btn-sm btn-danger">delete</a>
                                            </td>
                                        </tr>
                                        <?php $num++; ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        @if ($books->hasPages())
                            <div class="float-end">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <?php
                                        $startPage = $books->currentPage() - 2 < 1 ? 1 : $books->currentPage() - 2;
                                        $endPage = $books->currentPage() + 2 > $books->lastPage() ? $books->lastPage() : $books->currentPage() + 2;
                                        if ($startPage == 1 && $endPage < 5) {
                                            if ($books->lastPage() > 5) {
                                                $endPage = 5;
                                            } else {
                                                $endPage = $books->lastPage();
                                            }
                                        }
                                        if ($endPage - $startPage + 1 < 5) {
                                            if ($books->lastPage() > 5) {
                                                $startPage = $endPage - 4;
                                            } else {
                                                $startPage = $endPage - $books->lastPage() + 1;
                                            }
                                        }
                                        ?>
                                        {!! $startPage == 1
                                            ? ''
                                            : '<li class="page-item"><a class="page-link" href="' . $books->url(1) . '">First</a></li>' !!}
                                        {!! $books->onFirstPage()
                                            ? ''
                                            : '<li class="page-item"><a class="page-link" href="' . $books->previousPageUrl() . '">Previous</a></li>' !!}
                                        @foreach ($books->getUrlRange($startPage, $endPage) as $key => $val)
                                            <li class="page-item {!! $books->currentPage() == $key ? 'active' : '' !!}"><a class="page-link"
                                                    href="{{ $val }}">{{ $key }}</a></li>
                                        @endforeach
                                        {!! $books->currentPage() == $books->lastPage()
                                            ? ''
                                            : '<li class="page-item"><a class="page-link" href="' . $books->nextPageUrl() . '">Next</a></li>' !!}
                                        {!! $endPage == $books->lastPage()
                                            ? ''
                                            : '<li class="page-item"><a class="page-link" href="' . $books->url($books->lastPage()) . '">Last</a></li>' !!}
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($books as $b)
        <!-- Modal -->
        <div class="modal fade" id="editBook{{ $b->id }}" tabindex="-1"
            aria-labelledby="editBookLabel{{ $b->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookLabel{{ $b->id }}">Edit Book</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('editbook') }}" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            @csrf
                            <div class="mb-3">
                                <input type="hidden" name="id" value="{{ $b->id }}">
                                <label for="title{{ $b->id }}" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title"
                                    id="title{{ $b->id }}" value="{{ $b->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="author{{ $b->id }}" class="form-label">Author</label>
                                <input type="text" class="form-control" name="author"
                                    id="author{{ $b->id }}" value="{{ $b->author }}">
                            </div>
                            <div class="mb-3">
                                <label for="publisher{{ $b->id }}" class="form-label">Publisher</label>
                                <input type="text" class="form-control" name="publisher"
                                    id="publisher{{ $b->id }}" value="{{ $b->publisher }}">
                            </div>
                            <div class="mb-3">
                                <label for="printing_date{{ $b->id }}" class="form-label">Printing
                                    Date</label>
                                <input type="date" class="form-control" name="printing_date"
                                    id="printing_date{{ $b->id }}" value="{{ $b->printing_date }}">
                            </div>
                            <div class="mb-3">
                                <label for="cover{{ $b->id }}" class="form-label">Cover</label>
                                <input class="form-control" type="file" name="cover"
                                    onchange="displayImage(this,'{{ $b->id }}')"
                                    id="cover{{ $b->id }}">
                            </div>
                            <div class="mb-3">
                                <img class="img-thumbnail" src="{{ asset(Storage::url('cover/' . $b->cover)) }}"
                                    id="displayImage{{ $b->id }}" alt="{{ $b->title }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <div class="modal fade" id="addBook" tabindex="-1" aria-labelledby="addBookLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookLabel">Add Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('addbook') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="modalid" value="addbook">
                            <label for="title_add" class="form-label">Title</label>
                            <input type="text"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"
                                id="title_add" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="author_add" class="form-label">Author</label>
                            <input type="text"
                                class="form-control {{ $errors->has('author') ? 'is-invalid' : '' }}" name="author"
                                id="author_add" value="{{ old('author') }}">
                            @if ($errors->has('author'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('author') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="publisher_add" class="form-label">Publisher</label>
                            <input type="text"
                                class="form-control {{ $errors->has('publisher') ? 'is-invalid' : '' }}"
                                name="publisher" id="publisher_add" value="{{ old('publisher') }}">
                            @if ($errors->has('publisher'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('publisher') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="printing_date_add" class="form-label">Printing
                                Date</label>
                            <input type="date"
                                class="form-control {{ $errors->has('printing_date') ? 'is-invalid' : '' }}"
                                name="printing_date" id="printing_date_add" value="{{ old('printing_date') }}">
                            @if ($errors->has('printing_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('printing_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="cover_add" class="form-label">Cover</label>
                            <input class="form-control {{ $errors->has('cover') ? 'is-invalid' : '' }}"
                                type="file" name="cover" onchange="displayImage(this,'_add')" id="cover_add">
                            @if ($errors->has('cover'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cover') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <img class="img-thumbnail" src="" id="displayImage_add">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        function displayImage(input, id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#displayImage' + id).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
    @if ($errors->any())
        <span id="modalid">{{ session('modalid') }}</span>
        <script>
            $(document).ready(function() {
                $('#' + $("span#modalid").text() + 'button').click();
            })
        </script>
    @endif
</body>

</html>
