@extends('layouts.app')

@section('content')
    <?php $idCom = 0?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src="/storage/{{$picture->picture}}"><br>
                        <i class="fa fa-flag" aria-hidden="true"></i>
                        [{{$picture->activite->name}}]<br>
                        Par : {{ $user->firstname }} {{ $user->lastname }} | {{$picture->date_image}}<br>
                        {{count($likes)}} <i class="fa fa-heart" aria-hidden="true"></i> - {{count($comments)}} <i class="fa fa-comments" aria-hidden="true"></i>
                        <br>
                        <div style="display: flex; float: right">

                            <form method="post" action="{{ route('likePic',$picture->id) }}">
                            <div style="text-align: right; margin-right: 1em">
                                {{csrf_field()}}
                                <button type="submit" class="{{$btnStyle}}"><i class="{{$iconeStyle}}" aria-hidden="true"></i> {{$textValue}}</button>
                            </div>
                            </form>
                            @if(Auth::user()->rang >= 1)
                            <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#censurePic"><i class="fa fa-trash" aria-hidden="true" ></i></button>
                                @endif
                        </div>


                    </div>
                </div>

                <div class="card" style="margin-top : 2vh">

                        <div class="card-header">
                           Laisser un commentaire :
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="formComment" method="post" action="{{ route('commentPic',$picture->id) }}">
                                <div style="text-align: right">
                                    {{csrf_field()}}
                                    <textarea class="form-control form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" rows="3" name="comment" id="comment"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer" style="text-align: right">
                            <button type="submit" form="formComment" class="btn btn-primary"><i aria-hidden="true"></i> Publier</button></form>
                        </div>
                </div>

                <div class="card" style="margin-top : 2vh">

                    @foreach($comments as $comment)
                        <div class="card-header">
                                <div style="float: left;">
                                    {{$comment->date_comment}} | {{$comment->user->firstname}} {{$comment->user->lastname}} dit :
                                </div>
                            @if(Auth::user()->rang >= 1)
                                <div style="float: right">
                                    <form method="post" action="{{route('deleteCom')}}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <input type="hidden" id="idCom" name="idCom" value="{{$comment->id}}">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true" ></i></button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">

                            {{$comment->comment}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="censurePic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supprimer le commentaire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('deletePic')}}" enctype="multipart/form-data">

                        {{csrf_field()}}

                        <input type="hidden" name="idPic" value="{{$picture->id}}">

                        <p>Etes-vous sûr de vouloir supprimer cette photo ? Les commentaires associés seront supprimés. Ceci est irréversible.</p>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Supprimer</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
@endsection