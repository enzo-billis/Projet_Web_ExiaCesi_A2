@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{ $manif->image}} ><br>
                        {{ $manif->name }} | {{ $manif->status }}  : {{ $manif->date_add }}<br>
                        <form method="post" action="{{route('registerManif', $manif->id)}}">
                            {{csrf_field()}}
                            <button type="submit" class="{{$buttonStyle}}">{{$buttonText}}</button>
                        </form>
                    </div>

                    <div class="card-body">
                        Nom : {{ $manif->name }}<br>
                        Description : {{ $manif->description }} <br>
                        Reccurence : {{ $manif->recurrence }} <br>
                        Prix : {{$manif->price}} €
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection