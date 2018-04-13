@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src="/storage/{{$idea->image}}" ><br>
                        {{ $idea->name }} | Par : {{ $firstname }} {{ $lastname }}<br>
                        Pour : {{ $upVotes }} | Contre : {{ $downVotes }}<br><br>
                        <div>
                        <form style="display: inline-block" method="post" action="{{ route('VoteUp',$idea->id) }}">
                            {{csrf_field()}}
                            <button id="upButton" type="submit" onmouseover="changeToPrimary(this)" onmouseleave="changeUpToLight(this)" class="{{$buttonStyleUp}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</button>
                        </form>
                        <form style="display: inline-block" method="post" action="{{ route('VoteDown',$idea->id) }}">
                            {{csrf_field()}}
                            <button id="downButton" type="submit" onmouseover="changeToDanger(this)" onmouseleave="changeDownToLight(this)" class="{{$buttonStyleDown}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Dislike</button>
                        </form>
                        </div>
                        @if(isset(Auth::user()->id))
                            @if(Auth::user()->rang==1)
                                <button type="submit" class="btn btn-success " data-toggle="modal" data-target="#selectIdea" >
                                    Valider cette idée
                                </button>
                            @endif
                        @endif
                    </div>

                    <div class="card-body">
                        Nom : {{ $idea->name }}<br>
                        Description : {{ $idea->description }} <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="selectIdea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Valider & ajouter cette idée</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('newManif')}}" enctype="multipart/form-data">

                        {{csrf_field()}}

                        <input type="hidden" name="oldPhoto" value="{{$idea->image}}">

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Nom : </label>
                            <input type="text" class="form-control-file" id="name" name="name" value="{{$idea->name}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description : </label>
                            <textarea class="form-control" id="description" name="description" rows="3" >{{$idea->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Voulez-vous changer la photo de couverture ?</label>
                            <input type="radio" onchange="votePicture()"  id="yes" name="vote" value="yes"> Oui<br>
                            <input type="radio" onchange="votePicture()" checked="checked" id="no" name="vote" value="no"> Non<br>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image de couverture : </label>
                            <input type="file" accept="image/*" class="form-control-file" id="file" name="photo">
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Reccurence : </label>
                        <select class="form-control" id="recurrence" name="recurrence">
                            <option value="Ponctuelle">Ponctuelle</option>
                            <option value="Mensuelle">Mensuelle</option>
                            <option value="Trimestrielle">Trimestrielle</option>
                            <option value="Annuelle">Annuelle</option>
                            <option value="N/C">N/C</option>
                        </select>
                        </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Date : </label>
                    <input id="date" class="form-control" type="date" name="date">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Prix : </label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <script type="text/javascript">
        document.getElementById('file').setAttribute('disabled',"disabled");

        if(document.getElementById('upButton').classList.contains('btn-primary')){
            UpPresent = true;
        }
        else{
            UpPresent = false;
        }
        if(document.getElementById('downButton').classList.contains('btn-danger')){
            DownPresent = true;
        }
        else{
            DownPresent = false;
        }

        function changeToDanger(elem){
            if (DownPresent==false){
                elem.classList.remove('btn-light');
                elem.classList.remove('btn-primary');
                elem.classList.add('btn-danger');
            }

        }
        function changeToPrimary(elem){
            if (UpPresent==false) {
                elem.classList.remove('btn-light');
                elem.classList.remove('btn-danger');
                elem.classList.add('btn-primary');
            }
        }
        function changeUpToLight(elem){
            if (UpPresent==false) {
                elem.classList.remove('btn-danger');
                elem.classList.remove('btn-primary');
                elem.classList.add('btn-light');
            }
        }
        function changeDownToLight(elem){
            if (DownPresent==false) {
                elem.classList.remove('btn-danger');
                elem.classList.remove('btn-primary');
                elem.classList.add('btn-light');
            }
        }

        function votePicture(){
            if(document.getElementById('yes').checked){
                document.getElementById('file').removeAttribute('disabled');
            }
            if(document.getElementById('no').checked){
                document.getElementById('file').setAttribute('disabled',"disabled");
            }
        }

    </script>
@endsection