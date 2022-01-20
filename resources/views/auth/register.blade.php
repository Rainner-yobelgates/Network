<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/auth/auth.css">
    <title>Login Page</title>
  </head>
  <body>
    <div class="my-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="py-4 px-5">
                                <h4 class="brand text-center mb-0">Network</h4>
                                <p class="text-muted text-center mb-4">Connect with us</p>
                                @if(session('message'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('message')}}
                                </div>
                                @endif
                                <form class="form-horizontal" action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="{{ old('name') }}">
                                        @error('name') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{ old('email') }}">
                                        @error('email') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="password">Password</label>
                                        <input required autocomplete="new-password" type="password" name="password" class="form-control" id="password" placeholder="Enter your password">
                                        @error('password') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input required type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter your password">
                                    </div>

                                    <button class="mt-4 btn text-light col-12" type="submit">Register</button>

                                    <div class="mt-3 text-center">
                                        <p class="text-bottom mb-1">Already register? <a href="{{ route('login') }}" class="text-primary"> Sign in </a> </p>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>