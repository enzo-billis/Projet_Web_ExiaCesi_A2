@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{$picture->picture}} ><br>
                        Par : {{ $user->firstname }} {{ $user->lastname }} | {{$picture->date_image}}<br>
                        @if(count($likes)<=1)
                            {{count($likes)}} Like
                            @else
                            {{count($likes)}} Likes
                            @endif
                        </div>
                    </div>
                @foreach($comments as $comment)
                    <div class="card-body">
                        {{$comment->date_comment}} | {{$comment->user->firstname}} {{$comment->user->lastname}} dit : <br>
                        {{$comment->comment}}
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection