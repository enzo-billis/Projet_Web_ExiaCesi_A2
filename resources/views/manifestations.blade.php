@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row justify-content-md-center">
            <div class="form-group">
                <label for="sel1">Filtrer : </label>
                <select onchange="request();" class="form-control" id="sell" name="manifStatus">
                    <option value="0">Tout</option>
                    <option value="1">A venir</option>
                    <option value="2">Passés</option>
                    <option value="3">Du mois</option>
                </select>
            </div>
        </div>
        <div id="container" class="row">
            {{--@foreach($manifs as $manif)--}}
            {{--<div class="col-md-5 offset-1" id="1">--}}
                {{--<div class="card">--}}
                    {{--<a href={{route('manif',$manif->id)}} ><div class="card-header" style="text-align: center">--}}
                        {{--<img src={{ $manif->image}} ><br>--}}
                        {{--{{ $manif->name }} |  {{ $manif->date_add }}<br>--}}
                        {{--</div> </a>--}}

                    {{--<div class="card-body">--}}
                        {{--Nom : {{ $manif->name }}<br>--}}
                        {{--Description : {{ $manif->description }} <br>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
                <script>
                    function request(){
                        var container = document.getElementById("container");
                        var list = document.getElementById("sell");
                        var request = new XMLHttpRequest();
                        request.open("GET","{{route('APIManifs')}}", false);
                        request.send(null);

                        var responses = JSON.parse(request.responseText);
                        responses.forEach(function(response){
                            //console.log(list.value);
                            if (parseInt(response.status) == list.value){
                                container.innerHTML='<p>some dynamic html</p>';
                            }
                        });

                    }
                </script>
            {{--@endforeach--}}
        </div>

    </div>
@endsection