@extends('layouts.app')
@section('content')
    <div class="user-info ml-5">
        <div class="profile-avatar">
            <div class="inner m-2">
                @if(isset($user->getProfilePic()->name))
                    <img alt="img" width="132"
                         src="{{ asset('/images/' . $user->getProfilePic()->name) }}">
                @else
                    <img alt="default img" width="132" src="{{ asset('/icons/profile-icon-png-circle.png') }}">
                @endif
            </div>
        </div>
        <div class="m-2">
            <h1>{{ $user->name }}</h1>
            <h2>{{ $user->email }}</h2>
        </div>
        <div class="">
            <ul>
                <li><a href="{{ route('photos') }}"><i></i> Photos </a></li>
                <li><a href="{{ route('photos.add') }}"><i></i>Add Photos</a></li>
            </ul>
        </div>
    </div>

    <section class="right-col">

        @if($frReqUsers=$user->friend_requests_pending)
            <h4>You have friend requests from:</h4><br>
            @foreach($frReqUsers as $frReqUser)
                <p> {{$frReqUser->name}} </p>
            <a href="{{ route('friends.accept', [$frReqUser->email]) }}" style="border: #3490dc solid 1px">
                Accept Friend Request
            </a><br>
                <a href="{{ route('friends.reject', [$frReqUser->email]) }}" style="border: #e3342f solid 1px">
                Reject Friend Request
            </a><br>
                <hr>
            @endforeach
        @endif
        <h4>{{ $user->name }}'s friends:</h4><br>
        @if(!$user->friends()->count())
            <p>{{ $user->name }} has not friends.</p>
        @else
            @foreach(($user->friends()) as $friend)
                @if(isset($friend->getProfilePic()->name))
                    <img alt="img" width="132"
                         src="{{ asset('/images/' . $friend->getProfilePic()->name) }}">
                @else
                    <img alt="default img" width="25" src="{{ asset('/icons/profile-icon-png-circle.png') }}">
                @endif
                <p>{{ $friend->name }}</p>
            @endforeach
        @endif
    </section>
@endsection

