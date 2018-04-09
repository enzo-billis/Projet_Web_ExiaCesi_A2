@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            @foreach($manifs as $manif)
            <div class="col-md-5 offset-1">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{ $manif->image}} ><br>
                        {{ $manif->name }} | {{ $manif->status }}  : {{ $manif->date_add }}<br>
                    </div>

                    <div class="card-body">
                        Nom : {{ $manif->name }}<br>
                        Description : {{ $manif->description }} <br>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
@endsection