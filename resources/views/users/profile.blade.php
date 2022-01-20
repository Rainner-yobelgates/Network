@extends('layouts.layouts')
@section('title', 'Profile')
@section('content')
<div class="comments">
    <div class="close" onclick="comments('')">&times</div>
    <div class="card content" id="content">

    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="row p-4 align-items-center">
                        <div class="col-3 text-center ">
                            <img class="image-profile"
                                src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/user.png' }}"
                                alt="Image User">
                        </div>
                        <div class="col-9">
                            <div class="d-flex">
                                <p class="m-0 fw-bolder h4">{{ Str::limit($user->name, '30', '') }}</p>
                                @if (Auth::user()->id == $user->id)
                                    <a class="text-secondary ms-3" href="{{ route('profile.edit', $user) }}"
                                        style="font-size: 20px;"><i class="fas fa-cog"></i></a>
                                @endif
                            </div>
                            <div class="d-flex mt-2">
                                <p class="mb-2 profilelinks" onclick="openTab(event, 'posts')"><span
                                        class="fw-bolder">{{ $user->statuses->count() }}</span> Post</p>
                                <p class="mx-4 mb-2 profilelinks" onclick="openTab(event, 'followers')"><span
                                        class="fw-bolder">{{ $user->followers->count() }}</span> Follower</p>
                                <p class="mb-2 profilelinks" onclick="openTab(event, 'following')"><span
                                        class="fw-bolder">{{ $user->follows->count() }}</span> Following</p>
                            </div>
                            <p class="mb-0">{{ $user->bio }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($user->id == Auth::user()->id)
        <div class="d-flex justify-content-between col-2 mx-auto mt-4">
            <p class="mb-1 fw-bolder profilelinks" style="color: rgb(140, 140, 140);" onclick="openTab(event, 'posts')">
                <span>Posts</span></p>
            <p class="mb-1 fw-bolder profilelinks" style="color: rgb(140, 140, 140);" onclick="openTab(event, 'saved')">
                <span>Saved</span></p>
        </div>
        <div>
            <hr class="text-dark mb-2">
        </div>
        @endif
        <div class="row tabcontent" id="posts">
            @forelse ($statuses as $status)
                <div class="col-lg-6">
                    <div class="card mt-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                    <img class="img-profile-side-up"
                                        src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : '/user.png' }}"
                                        alt="Image User">
                                </div>
                                <div class="col-7 ps-0">
                                    <p class="m-0 fw-bolder h5">{{ Str::limit($status->user->name, '25', '') }}</p>
                                    <p class="m-0 pt-1 text-secondary">{{ $status->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="col-2 text-center">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="/set.png" width="25px" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('profile', $status->user->username) }}">View Profile</a>
                                        </li>
                                        @if ($status->user_id != Auth::user()->id)
                                            <li>
                                                <form action="{{ route('following.store', $status->user) }}"
                                                    method="post">
                                                    @csrf
                                                    @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                                        <button style="background: none; border: none;"
                                                            class="settingBtn dropdown-item text-danger">Unfollow</button>
                                                    @else
                                                        <button style="background: none; border: none;"
                                                            class="settingBtn dropdown-item text-primary">Follow</button>
                                                    @endif
                                                </form>
                                            </li>
                                        @endif
                                        @if ($status->user_id == Auth::user()->id)
                                            <li>
                                                <form action="{{ route('status.delete', $status->identifier) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button style="background: none; border: none;"
                                                        class="settingBtn dropdown-item text-danger">Delete Post</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="mx-2 mt-3">
                                <p style="font-size: 15px;" class="fw-bolder">{{ $status->body }}</p>
                                <div>
                                    <i class="icon {{ like($status->id) }} fa-heart iconHeart"
                                        onclick="likes({{ $status->id }}, this)"></i>
                                    <i class="icon far fa-comments iconComments"
                                        onclick="comments({{ $status->id }})"></i>
                                    <i class="icon {{ checkBookmark($status->id) }} fa-bookmark iconBookmark"
                                        onclick="saved({{ $status->id }}, this)"></i>
                                </div>
                                <div>
                                    <p class="mt-1 mb-2">Liked by <span id="totalLikesId{{ $status->id }}"
                                            class="fw-bolder">{{ $status->likes->count() }}</span>
                                        people</p>
                                </div>
                                <div>
                                    @foreach ($status->comments->take(3) as $comment)
                                        <p style="font-size: 14px" class="mb-1"><span
                                                class="fw-bolder me-1">{{ $comment->user->name }}</span>
                                            {{ $comment->body }}</p>
                                    @endforeach
                                    @if ($status->comments->count() >= 1)
                                        <p style="font-size: 14px" class="text-secondary viewComments" onclick="comments({{ $status->id }})">View all
                                            {{ $status->comments->count() }} comments</p>
                                    @endif
                                </div>
                                <div>
                                    <form action="{{ route('comment.store', $status->id) }}" method="post">
                                        @csrf
                                        <div class="d-flex justify-content-between align-items-center">
                                            <textarea style="resize: none; height: 40px; width: 90%; border-radius: 20px;"
                                                name="body" class="form-control ps-3 pt-2"
                                                placeholder="Add a comment..."></textarea>
                                            <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card mt-3">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-paper-plane h3 text-primary"></i>
                        <p class="h3">Post Something!</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="row tabcontent" id="saved" style="display: none">
            @forelse ($saveds as $saved)
                <div class="col-lg-6">
                    <div class="card mt-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                    <img class="img-profile-side-up"
                                        src="{{ $saved->status->user->image ? asset('storage/' . $saved->status->user->image) : '/user.png' }}"
                                        alt="Image User">
                                </div>
                                <div class="col-7 ps-0">
                                    <p class="m-0 fw-bolder h5">{{ Str::limit($saved->status->user->name, '25', '') }}
                                    </p>
                                    <p class="m-0 pt-1 text-secondary">{{ $saved->status->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="col-2 text-center">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="/set.png" width="25px" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('profile', $saved->status->user->username) }}">View
                                                Profile</a>
                                        </li>
                                        @if ($saved->status->user_id != Auth::user()->id)
                                            <li>
                                                <form action="{{ route('following.store', $saved->user) }}"
                                                    method="post">
                                                    @csrf
                                                    @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                                        <button style="background: none; border: none;"
                                                            class="settingBtn dropdown-item text-danger">Unfollow</button>
                                                    @else
                                                        <button style="background: none; border: none;"
                                                            class="settingBtn dropdown-item text-primary">Follow</button>
                                                    @endif
                                                </form>
                                            </li>
                                        @endif
                                        @if ($saved->status->user_id == Auth::user()->id)
                                            <li>
                                                <form action="{{ route('status.delete', $status->identifier) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button style="background: none; border: none;"
                                                        class="settingBtn dropdown-item text-danger">Delete Post</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="mx-2 my-3">
                                <p style="font-size: 15px;" class="fw-bolder">{{ $saved->status->body }}</p>
                                <div>
                                    <i class="icon {{ like($saved->status->id) }} fa-heart iconHeart"
                                        onclick="likes({{ $saved->status->id }}, this)"></i>
                                    <i class="icon far fa-comments iconComments"
                                        onclick="comments({{ $saved->status->id }})"></i>
                                    <i class="icon {{ checkBookmark($saved->status->id) }} fa-bookmark iconBookmark"
                                        onclick="saved({{ $saved->status->id }}, this)"></i>
                                </div>
                                <div>
                                    <p class="mt-1 mb-2">Liked by <span id="totalLikesSavedId{{ $saved->status->id }}"
                                            class="fw-bolder">{{ $saved->status->likes->count() }}</span>
                                        people</p>
                                </div>
                                <div>
                                    @foreach ($saved->status->comments->take(3) as $comment)
                                        <p style="font-size: 14px" class="mb-1"><span
                                                class="fw-bolder me-1">{{ $comment->user->name }}</span>
                                            {{ $comment->body }}</p>
                                    @endforeach
                                    @if ($saved->status->comments->count() >= 1)
                                        <p style="font-size: 14px" class="text-secondary viewComments" onclick="comments({{ $saved->status->id }})">View all
                                            {{ $saved->status->comments->count() }} comments</p>
                                    @endif
                                </div>
                                <div>
                                    <form action="{{ route('comment.store', $saved->status->id) }}" method="post">
                                        @csrf
                                        <div class="d-flex justify-content-between align-items-center">
                                            <textarea style="resize: none; height: 40px; width: 90%; border-radius: 20px;"
                                                name="body" class="form-control ps-3 pt-2"
                                                placeholder="Add a comment..."></textarea>
                                            <button class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card mt-3">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-paper-plane h3 text-primary"></i>
                        <p class="h3">You Don't Save Any Post</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="row tabcontent" id="followers" style="display: none">
            @forelse ($followers as $user)
                <div class="col-6 mb-3 col-md-3">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-4 text-center">
                                    <img class="img-profile-side-down"
                                        src="{{ $user->image ? asset('storage/' . $user->image) : '/user.png' }}"
                                        alt="Image User">
                                </div>
                                <div class="col-lg-8">
                                    <a style="text-decoration: none" class="text-dark"
                                        href="{{ route('profile', $user->username) }}">
                                        <p class="m-0 pt-2 fw-bolder h6">{{ Str::limit($user->name, '15', '...') }}</p>
                                    </a>
                                    <form action="{{ route('following.store', $user) }}" method="post">
                                        @csrf
                                        @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                            <button style="background: none; border: none;"
                                                class="m-0 p-0 pt-1 fw-bolder text-danger">Unfollow</button>
                                        @else
                                            <button style="background: none; border: none;"
                                                class="m-0 p-0 pt-1 fw-bolder text-primary">Follow</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card mt-3">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-users h3 text-primary"></i>
                        <p class="h3">You Don't Have Followers</p>
                    </div>
                </div>
            @endforelse
        </div>
        <div class="row tabcontent" id="following" style="display: none">
            @forelse ($following as $user)
                <div class="col-6 mb-3 col-md-3">
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-4 text-center">
                                    <img class="img-profile-side-down"
                                        src="{{ $user->image ? asset('storage/' . $user->image) : '/user.png' }}"
                                        alt="Image User">
                                </div>
                                <div class="col-lg-8">
                                    <a style="text-decoration: none" class="text-dark"
                                        href="{{ route('profile', $user->username) }}">
                                        <p class="m-0 pt-2 fw-bolder h6">{{ Str::limit($user->name, '15', '...') }}</p>
                                    </a>
                                    <form action="{{ route('following.store', $user) }}" method="post">
                                        @csrf
                                        @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                            <button style="background: none; border: none;"
                                                class="m-0 p-0 pt-1 fw-bolder text-danger">Unfollow</button>
                                        @else
                                            <button style="background: none; border: none;"
                                                class="m-0 p-0 pt-1 fw-bolder text-primary">Follow</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card mt-3">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-users h3 text-primary"></i>
                        <p class="h3">You Don't Follow Anyone</p>
                        <p class="h5"><a class="nav-link" href="route('explore')">Find Someone?</a></p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
@section('script')
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, profilelinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            profilelinks = document.getElementsByClassName("profilelinks");
            for (i = 0; i < profilelinks.length; i++) {
                profilelinks[i].className = profilelinks[i].className.replace(" actve", "");
            }
            document.getElementById(tabName).style.display = "flex";
            evt.currentTarget.className += " actve";
        }

        function likes(id, x) {
            const iconHeart = document.querySelector('.iconHeart')
            const totalLikesId = document.querySelector('#totalLikesId' + id)
            const totalLikesSavedId = document.querySelector('#totalLikesSavedId' + id)
            console.log(totalLikesSavedId)
            fetch('/home/heart/store?status=' + id)
                .then(res => res.json())
                .then(data => {
                    totalLikesId.innerHTML = data.results
                    totalLikesSavedId.innerHTML = data.results
                    if (x.classList.contains('far')) {
                        x.classList.remove('far')
                        x.classList.add('fas')
                        x.classList.add('text-danger')
                    } else if (x.classList.contains('fas')) {
                        x.classList.remove('fas')
                        x.classList.remove('text-danger')
                        x.classList.add('far')
                    }
                })

        }
    </script>
@endsection
