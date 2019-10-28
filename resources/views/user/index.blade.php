@extends('layouts.app')
@section('content')
    <div class="container">
        @if(!$users->count())
            <p>There isn't users</p>
        @else
            <div class="row">
                @foreach($users as $user)
                    @auth()
                        @if($user->id === Auth()->id())
                            @continue
                        @endif
                    @endauth
                    <div class="col">
                        @if(isset($user->getProfilePic()->name))
                            <img alt="img" width="132"
                                 src="{{ asset('/images/' . $user->getProfilePic()->name) }}">
                        @else
                            <img alt="default img" width="100" src="{{ asset('/icons/profile-icon-png-circle.png') }}">
                        @endif
                        <p class="m-2">{{ $user->name }}</p>
                        @auth()
                            @if(!empty($user->is_not_friend))
                                @if($user->is_not_friend->pivot->accepted === 0)
                                    <a type="button"
                                       class="btn btn-default">Already Sent</a>
                            @endif
                            @else
                                <a href="{{ route('friends.add', [$user->email]) }}" type="button"
                                   class="btn btn-primary"
                                   onclick=" $(this).text('Request sent')">Add as friend</a>
                            @endif

                            <example-component :user="{{ auth()->user() }}"
                                               :user2="{{ $user }}"></example-component>
                        @endauth
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
