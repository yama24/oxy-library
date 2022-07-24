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
                <div class="card">
                    <div class="card-header bg-primary text-light">
                        {{ $title }}
                    </div>
                    <div class="card-body">
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
                                        <td><img src="{{ asset(Storage::url('cover/' . $b->cover)) }}" alt="{{ $b->title }}"></td>
                                        <td>{{ $b->author }}</td>
                                        <td>{{ $b->publisher }}</td>
                                        <td>{{ $b->printing_date }}</td>
                                        <td>{{ $b->uploader->name }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-success">edit</button>
                                            <button class="btn btn-sm btn-danger">delete</button>
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                @endforeach
                            </tbody>
                        </table>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
