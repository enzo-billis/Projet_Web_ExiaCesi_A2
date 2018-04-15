@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>Activité bien ajoutée !</li>
                                </ul>
                            </div>
                        @endif
                    <div class="card-header" style="text-align: center">

                        <img src="/storage/{{ $manif->image}}" ><br>

                        {{ $manif->name }} | {{ $manif->status }}  : {{ $manif->date_add }}<br>
                        @if(!isset($modal))
                            <form method="post" action="{{$route}}">

                                {{csrf_field()}}

                                <button type="submit" class="{{$buttonStyle}}" >
                                    {{$buttonText}}
                                </button>

                            </form>
                        @else
                            <button type="submit" class="{{$buttonStyle}}" data-toggle="modal" data-target="#uploadPictures" >
                                {{$buttonText}}
                            </button>
                        @endif

                        @if($manif->status==="Passé" && isset(Auth::user()->rang) && Auth::user()->rang >1)
                            <form method="post" action="{{route('downloadPack')}}" enctype="multipart/form-data">

                                {{csrf_field()}}

                                <input type="hidden" value={{$manif->id}} id="idManif" name="idManif">
                                <input type="hidden" value="{{$manif->name}}" id="name" name="name">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i>Pack photos</button>

                            </form>
                            @endif

                        @if(isset(Auth::user()->id))
                        @if(isset($inscrits) && Auth::user()->rang >0)
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#tablInscrits" >
                                Voir les inscrits
                            </button>
                        @endif
                        @endif

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
                                           <a href="{{route('picture',$picture->id)}}"> <img src="/storage/{{$picture->picture}}"></a>
                                       </div>
                                   @else
                                       <div class="carousel-item">
                                           <a href="{{route('picture',$picture->id)}}"> <img src="/storage/{{$picture->picture}}"></a>
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

    <!-- Modal -->
    <div class="modal fade" id="uploadPictures" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Partagez vos photos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('savePic',$manif->id)}}" enctype="multipart/form-data">

                        {{csrf_field()}}
                        <label for="exampleFormControlFile1">Photo(s) : </label>
                        <input type="file" accept="image/*" class="form-control-file" id="file" name="photo"><br>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Partager</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
@if(isset($inscrits))
    <!-- Modal -->
    <div  class="modal fade" id="tablInscrits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div  class="modal-dialog" role="document">
            <div id='tableRegister' class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Liste des inscrits - {{$manif->name}} - {{$manif->date_add}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div style="text-align: center" class="modal-body">
                        <table  class="table table-hover table-dark">
                            <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inscrits as $inscrit)
                            <tr>
                                <td>{{$inscrit->lastname}}</td>
                                <td>{{$inscrit->firstname}}</td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button onclick="print()" type="button" class="btn btn-success" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Télécharger</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    @endif
@endsection

<script type="text/javascript">
    function print()
    {
        var divToPrint=document.getElementById("tableRegister");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }
</script>