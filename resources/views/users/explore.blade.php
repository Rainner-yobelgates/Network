@extends('layouts.layouts')
@section('title', 'Explore People')
@section('content')
    <div class="container">
        <div class="col-8 mx-auto mb-4">
            <form action="{{ route('explore') }}" method="get" class="d-flex">
                <input type="text" name="search" class="form-control p-2 ps-4" placeholder="Find your friend...">
                <button class="btn btn-primary rounded ms-1">Search</button>
            </form>
        </div>
        <div class="row">
            @foreach ($users as $user)
            <div class="col-6 mb-3 col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-4 text-center">
                                <img class="img-profile-side-down" src="{{$user->image ? asset('storage/' . $user->image) : '/user.png'}}" alt="Image User">
                            </div>
                            <div class="col-lg-8 ps-0">
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
                    </div>
                </div>
            </div>
            @endforeach
            {{$users->links()}}
        </div>
    </div>
@stop
