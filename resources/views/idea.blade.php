@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{$idea->image}} ><br>
                        {{ $idea->name }} | Par : {{ $firstname }} {{ $lastname }}<br>
                        Pour : {{ $upVotes }} | Contre : {{ $downVotes }}<br><br>
                        <form method="post" action="{{ route('VoteUp',$idea->id) }}">
                            {{csrf_field()}}
                            <button type="submit" class="{{$buttonStyleUp}}">+1</button>
                        </form>
                        <form method="post" action="{{ route('VoteDown',$idea->id) }}">
                            {{csrf_field()}}
                            <button type="submit" class="{{$buttonStyleDown}}">-1</button>
                        </form>
                    </div>

                    <div class="card-body">
                        Nom : {{ $idea->name }}<br>
                        Description : {{ $idea->description }} <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection