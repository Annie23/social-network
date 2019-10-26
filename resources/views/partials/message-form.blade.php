@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <h5>Message to</h5> <h4>{{($user)->name}}</h4>
                    <form method="post" action="{{route('message.send', [$user->id])}}">
                        @csrf
                        <div class="form-group">
                            <label for="message">Input message</label>
                            <textarea name="message" class="form-control" rows="5" id="message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
