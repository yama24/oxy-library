<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>{{ $title }}</title>
</head>

<body style="background-color: #F0E0EA;">
    <div class="container position-relative" style="height: 100vh;">
        <div class="position-absolute top-50 start-50 translate-middle">
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
                    <h4>
                        {{ $title }}
                    </h4>
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
