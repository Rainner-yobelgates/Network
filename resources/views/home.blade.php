@extends('layouts.layouts')
@section('title', 'Home Page')
@section('content')
    <div class="comments">
        <div class="close" onclick="comments('')">&times</div>
        <div class="card content" id="content">

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-lg-block d-none">
                <div class="side">
                    <div class="card side-up">
                        <div class="row p-4 align-items-center">
                            <div class="col-lg-3 pe-0">
                                <img class="img-profile-side-up img-fluid" style="object-fit: cover"
                                    src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'user.png' }}"
                                    alt="Image User">
                            </div>
                            <div class="col-lg-9">
                                <p class="m-0 fw-bolder h5">{{ Str::limit(Auth::user()->name, '20', '') }}</p>
                                <p class="m-0 pt-1 text-secondary">{{ Str::limit(Auth::user()->email, '30', '') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card side-down mt-3">
                        <div class="d-flex justify-content-between py-3 px-4">
                            <p class="mb-0 fw-bolder" style="font-size: 18px">Recently Follower</p>
                            <i class="fas fa-users text-primary" style="font-size: 25px"></i>
                        </div>
                        <hr class="m-0" style="height: 7px; color: #d8d8d8d5">
                        <div class="row px-4 py-3">
                            @forelse (Auth::user()->followers()->limit(5)->get() as $user)
                                <div class="d-flex justify-content-between">
                                    <div class="col-lg-3 mb-2 text-center">
                                        <img class="img-profile-side-down"
                                            src="{{ $user->image ? asset('storage/' . $user->image) : '/user.png' }}"
                                            alt="Image User">
                                    </div>
                                    <div class="col-lg-9">
                                        <a style="text-decoration: none" class="text-dark" href="{{ route('profile', $user->username) }}"><p class="m-0 pt-2 fw-bolder h6">{{ Str::limit($user->name, '15', '...') }}</p></a>
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
                            @empty
                                <div class="row px-4">
                                    <p class="fw-bolder mb-0 text-danger text-center">No Recently Followers</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-3">
                        <form action="{{ route('status.store') }}" method="post">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center">
                                <textarea style="resize: none; height: 85px; width: 85%; border-radius: 20px;" name="body"
                                    class="form-control ps-3 pt-2" placeholder="What's on your mind?"></textarea>
                                <button class="btn btn-primary"><i class="fas fa-paper-plane"></i> Post It!</button>
                            </div>
                        </form>
                    </div>
                </div>
                @forelse ($statuses as $status)
                    <div class="card mt-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-2 text-center">
                                    <img class="img-profile-side-up"
                                        src="{{ $status->user->image ? asset('storage/' . $status->user->image) : '/user.png' }}"
                                        alt="Image User">
                                </div>
                                <div class="col-8 ps-0">
                                    <p class="m-0 fw-bolder h5">{{ Str::limit($status->user->name, '25', '') }}</p>
                                    <p class="m-0 pt-1 text-secondary">{{ $status->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="col-2 text-center">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="set.png" width="25px" alt="">
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('profile', $status->user->username) }}">View Profile</a>
                                        </li>
                                        @if ($status->user_id != Auth::user()->id)
                                            <li>
                                                <form action="{{ route('following.store', $status->user) }}" method="post">
                                                    @csrf
                                                    <button style="background: none; border: none;"
                                                        class="settingBtn dropdown-item text-danger">Unfollow</button>
                                                </form>
                                            </li>
                                        @endif
                                        @if ($status->user_id == Auth::user()->id)
                                            <li>
                                                <form action="{{ route('status.delete', $status->identifier) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button style="background: none; border: none;"
                                                        class="settingBtn dropdown-item text-danger">delete</button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="mx-2 my-3">
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
                                    <p class="mt-1 mb-2">Liked by <span id="totalLikesId{{ $status->id }}" class="fw-bolder">{{ $status->likes->count() }}</span>
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
                            </div>
                            <div class="mx-2">
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
                @empty
                    <div class="card mt-3">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-paper-plane h3 text-primary"></i>
                            <p class="h3">Post Something!</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function likes(id, x) {
            const iconHeart = document.querySelector('.iconHeart')
            const totalLikesId = document.querySelector('#totalLikesId' + id)
            fetch('/home/heart/store?status=' + id)
                .then(res => res.json())
                .then(data => {
                    totalLikesId.innerHTML = data.results
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
