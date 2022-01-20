<x-app-layout>
    <x-container>
        <div class="grid grid-cols-4 gap-5">
            @foreach ($users as $user)
                <div class="border rounded-xl p-5">
                    <div class="flex item-center">
                        <div class="flex-shrink-0 mr-3">
                            <img class="w-10 h-10 rounded-full" src="https://i.pravatar.cc/150" alt="">
                        </div>
                        <div>
                            <a href="{{ route('profile', $user) }}" class="font-semibold block">
                                {{ $user->name }}
                            </a>
                            <form action="{{ route('following.store', $user) }}" method="post">
                                @csrf
                                <x-button>
                                    @if (Auth::user()->follows()->where('following_user_id', $user->id)->first())
                                        Unfollow
                                    @else
                                        Follow
                                    @endif
                                </x-button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{$users->links()}}
    </x-container>
</x-app-layout>
