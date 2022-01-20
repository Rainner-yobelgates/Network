@extends('layouts.layouts')
@section('title', 'Edit Profile')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <div style="background-color: white;" class="rounded">
                            <nav>
                                <ul class="nav nav-pills nav-sidebar flex-column">
                                    <a href="{{ route('profile', $user) }}" class="nav-link editlinks">
                                        <li class="nav-item">
                                            <p class="my-2">Profile</p>
                                        </li>
                                    </a>
                                    <div class="nav-link actv editlinks" onclick="openTab(event, 'profile')">
                                        <li class="nav-item">
                                            <p class="my-2">Edit Profile</p>
                                        </li>
                                    </div>
                                    <div class="nav-link editlinks" onclick="openTab(event, 'password')">
                                        <li class="nav-item">
                                            <p class="my-2">Change Password</p>
                                        </li>
                                    </div>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9 tabcontent" id="profile">
                        <div class="card p-4">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                    <img class="image-profile" src="{{Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/user.png'}}" alt="Image User">
                                </div>
                                <div class="col-9">
                                    <div class="d-flex">
                                        <p class="m-0 fw-bolder h4">{{ Str::limit($user->name, '30', '') }}</p>
                                        <a class="text-secondary ms-3" href="{{ route('profile', $user) }}"
                                            style="font-size: 20px;"><i class="fas fa-user"></i></a>
                                    </div>
                                    <div class="d-flex mt-2">
                                        <p class="mb-2"><span
                                                class="fw-bolder">{{ $user->statuses->count() }}</span> Post</p>
                                        <p class="mx-4 mb-2"><span
                                                class="fw-bolder">{{ $user->followers->count() }}</span> Follower</p>
                                        <p class="mb-2"><span
                                                class="fw-bolder">{{ $user->follows->count() }}</span> Following
                                        </p>
                                    </div>
                                    <p class="mb-0">{{$user->bio}}</p>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <form action="{{ route('profile.update', $user) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="username">Image Profile</label>
                                        <input class="form-control" type="file" name="image" id="image" />
                                        @error('image') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="name">Name</label>
                                        <input value="{{ old('name', $user->name) }}" class="mt-1 form-control"
                                            type="text" name="name" id="name" />
                                        @error('name') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="username">Username</label>
                                        <input value="{{ old('username', $user->username) }}" class="mt-1 form-control"
                                            type="text" name="username" id="username" />
                                        @error('username') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="email">Email</label>
                                        <input value="{{ old('email', $user->email) }}" class="mt-1 form-control"
                                            type="text" name="email" id="email" />
                                        @error('email') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="bio">Bio</label>
                                        <textarea style="resize: none; height: 55px;" name="bio"
                                            class="form-control ps-3 pt-2" placeholder="What's on your mind?">{{old('bio', $user->bio)}}</textarea>
                                        @error('bio') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <button class="btn btn-primary px-3 mt-3" type="submit">Update Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 tabcontent" style="display: none" id="password">
                        <div class="card p-4">
                            <div class="card-body">
                                <form action="{{ route('pass.update', $user) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input class="mt-1 form-control" type="password" name="current_password"
                                            id="current_password" />
                                        @error('current_password') <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input class="mt-1 form-control" type="password" name="password" id="password" />
                                        @error('password') <div class="text-danger">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Confrim Password</label>
                                        <input class="mt-1 form-control" type="password" name="password_confirmation"
                                            id="password_confirmation" />
                                        @error('password_confirmation') <div class="text-danger">{{ $message }}
                                        </div>@enderror
                                    </div>
                                    <button class="btn btn-primary px-3 mt-3">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, editlinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            editlinks = document.getElementsByClassName("editlinks");
            for (i = 0; i < editlinks.length; i++) {
                editlinks[i].className = editlinks[i].className.replace(" actv", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " actv";
        }
    </script>
@endsection
