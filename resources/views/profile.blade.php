@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                       <img src={{ $user->image}} ><br>
                        Profile de {{ $user->firstname }} {{ $user->lastname }}
                    </div>

                    <div class="card-body">
                        Nom : {{ $user->lastname }}<br>
                        Prénom : {{ $user->firstname }} <br>
                        Email : {{$user->email}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection