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
    <div class="my-5 pt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="p-5">
                                <h4 class="brand text-center mb-0">Network</h4>
                                <p class="text-muted text-center mb-4">Connect with us</p>
                                @if(session('message'))
                                <div class="alert alert-danger" role="alert">
                                    {{session('message')}}
                                </div>
                                @endif
                                <form class="form-horizontal" action="{{ route('login.post') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                                        @error('email') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password">
                                        @error('password') <span class="text-danger">{{$message}}</span>@enderror
                                    </div>

                                    <button class="mt-4 btn text-light col-12" type="submit">Log In</button>

                                    <div class="mt-3 text-center">
                                        <p class="text-bottom mb-1"><a href="{{ route('password.request') }}" class="nav-link text-primary"> Forgot password? </a> </p>
                                        <p class="text-bottom mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary"> Sign Up </a> </p>
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