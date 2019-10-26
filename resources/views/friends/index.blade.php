@extends('layouts.app')
@section('content')
    <div class="container">
        <h4 class="header">Your Friends</h4>

        @if(!$friends->count())
            <p>You have no friends.</p>
        @else
            <div class="row">
                @foreach($friends as $friend)
                    <div class="col">
                        @if(isset($friend->getProfilePic()->name))
                            <img alt="img" width="132"
                                 src="{{ asset('/images/' . $friend->getProfilePic()->name) }}">
                        @else
                            <img alt="default img" width="100" src="{{ asset('/icons/profile-icon-png-circle.png') }}">
                        @endif
                        <p class="m-2">{{ $friend->name }}</p>
                            <a href="{{ route('message.create', ['user' => $friend->id]) }}" type="button" class="btn btn-primary">
                                Send Message</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
