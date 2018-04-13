@extends('layouts.app')

@section('content')
    <div class="container">
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
                    <li>Idée bien ajoutée !</li>
                </ul>
            </div>
        @endif
        @if(Auth::user()->rang!==1)
                <div class="col-2" style="margin-bottom: 1em">
                    <button type="submit" class="btn btn-primary " data-toggle="modal" data-target="#addIdea" >
                        Proposer votre idée
                    </button>
                </div>
            @endif
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
    <!-- Modal -->
    <div class="modal fade" id="addIdea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Proposer une idée</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('newIdea')}}" enctype="multipart/form-data">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Nom : </label>
                            <input type="text" class="form-control-file" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Description : </label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Image de couverture : </label>
                            <input type="file" accept="image/*" class="form-control-file" id="file" name="photo">
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

@endsection