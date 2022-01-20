<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    {{-- CSS --}}
    <link rel="stylesheet" href="/css/index/style.css">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="/fontawesome/css/all.css">
    <title>@yield('title')</title>
</head>

<body class="body">
    {{-- desktop --}}
    <nav style="z-index: 1" class="navbar navbar-expand-lg navbar-light fixed-top d-lg-block d-none">
        <div class="container">
            <a class="navbar-brand p-0 m-0" href="{{ route('home') }}">Network</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                        <li class="nav-item">
                            <a class="nav-link icon" href="{{ route('home') }}"><i class="fas fa-home"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link icon" href="{{ route('explore') }}"><i class="fas fa-compass"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link icon" href="#"><i class="fas fa-comments"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-navbar img-fluid" src="{{Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/user.png'}}" alt="Image User">
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile', Auth::user()->username) }}">View Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->username) }}">Edit Profile</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </div>
        </div>
    </nav>
    {{-- Mobile --}}
    <nav class="navbar navbar-expand-lg navbar-light fixed-top d-lg-none d-block">
        <div class="container">
            <a class="navbar-brand p-0 m-auto" href="{{ route('home') }}">Network</a>
        </div>
    </nav>

    <section class="content">
        @yield('content')
    </section>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    @yield('script')
    <script>
        function comments(data) {
            const comments = document.querySelector('.comments')
            const body = document.querySelector('.body')
            const content = document.querySelector('#content')
            comments.classList.toggle('active')
            body.classList.toggle('active')
            if (data) {
                fetch('/home/comments/view?status=' + data)
                    .then(res => res.json())
                    .then(data => content.innerHTML = data.results)
            }
        }

        function saved(id, x) {
            const iconBookmark = document.querySelector('.iconBookmark')
            fetch('/home/bookmark/store?status=' + id)
                .then(res => {
                    if (x.classList.contains('far')) {
                        x.classList.remove('far')
                        x.classList.add('fas')
                    } else if (x.classList.contains('fas')) {
                        x.classList.remove('fas')
                        x.classList.add('far')
                    }
                })
        }
    </script>
</body>

</html>
