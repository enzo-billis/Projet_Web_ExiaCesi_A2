@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @foreach($ideas as $idea)
            <div class="col-md-4">
                <div class="card">
                    <a href={{route('idea',$idea->id)}}>
                    <div class="card-header" style="text-align: center">
                        {{ $idea->name }}<br>
                    </div></a>
                    <div class="card-body">
                        {{ $idea->description }} <br>
                    </div>
                </div>
            </div>
                @endforeach
        </div>
    </div>
@endsection