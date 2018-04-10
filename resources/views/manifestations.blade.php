@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="form-group">
                <label for="sel1">Filtrer : </label>
                <select class="form-control" id="sel1" name="manifStatus">
                    <option value="4">Tout</option>
                    <option value="1">A venir</option>
                    <option value="0">Passés</option>
                    <option value="5">Du mois</option>
                </select>
            </div>
        </div>
        <div class="row">
            @foreach($manifs as $manif)
            <div class="col-md-5 offset-1" id="1">
                <div class="card">
                    <a href={{route('manif',$manif->id)}} ><div class="card-header" style="text-align: center">
                        <img src={{ $manif->image}} ><br>
                        {{ $manif->name }} |  {{ $manif->date_add }}<br>
                        </div> </a>

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