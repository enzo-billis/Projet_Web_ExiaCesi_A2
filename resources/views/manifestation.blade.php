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
        <div style="padding-top: 3vh" class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        @if(!$pictures->isEmpty())
                       <div id="pictures" class="carousel slide" data-ride="carousel">
                           <ul class="carousel-indicators">
                                   <li data-target="#pictures" data-slide-to="0" class="active"></li>
                               @for($i = 1; $i < $numberPicture; $i++)
                                   <li data-target="#pictures" data-slide-to="{{$i}}"></li>
                               @endfor
                           </ul>

                           <div class="carousel-inner">
                               @foreach($pictures as $picture)
                                   @if($loop->first)
                                       <div class="carousel-item active">
                                           <a href="{{route('picture',$picture->id)}}"> <img src={{$picture->picture}}></a>
                                       </div>
                                   @else
                                       <div class="carousel-item">
                                           <a href="{{route('picture',$picture->id)}}"> <img src={{$picture->picture}}></a>
                                       </div>
                                   @endif
                               @endforeach
                           </div>

                           <a class="carousel-control-prev" href="#pictures" data-slide="prev">
                               <span class="carousel-control-prev-icon"></span>
                           </a>
                           <a class="carousel-control-next" href="#pictures" data-slide="next">
                               <span class="carousel-control-next-icon"></span>
                           </a>
                       </div>
                    </div>
                    <div style="text-align: center" class="card-body">
                        Cliquez sur la photo pour voir les commentaires.
                    </div>
                    @else
                        <p>Aucune photo !</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection