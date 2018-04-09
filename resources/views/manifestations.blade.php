@extends('layouts.app')

@section('js')
    <script type="text/javascript">
        
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="form-group">
                <label for="sel1">Filtrer : </label>
                <select class="form-control" id="sel1">
                    <option>Tout</option>
                    <option>A venir</option>
                    <option>Passés</option>
                    <option>Annulés</option>
                </select>
            </div>
        </div>
        <div class="row">
            @foreach($manifs as $manif)
            <div class="col-md-5 offset-1">
                <div class="card">
                    <a href={{route('manif',$manif->id)}} ><div class="card-header" style="text-align: center">
                        <img src={{ $manif->image}} ><br>
                        {{ $manif->name }} | {{ $manif->status }}  : {{ $manif->date_add }}<br>
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