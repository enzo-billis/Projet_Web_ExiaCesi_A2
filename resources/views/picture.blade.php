@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{$picture->picture}} ><br>
                        <i class="fa fa-flag" aria-hidden="true"></i>
                        [{{$picture->activite->name}}]<br>
                        Par : {{ $user->firstname }} {{ $user->lastname }} | {{$picture->date_image}}<br>
                        {{count($likes)}} <i class="fa fa-heart" aria-hidden="true"></i> - {{count($comments)}} <i class="fa fa-comments" aria-hidden="true"></i>

                        <form method="post" action="{{ route('likePic',$picture->id) }}">
                        <div style="text-align: right">
                            {{csrf_field()}}
                            <button type="submit" class="{{$btnStyle}}"><i class="{{$iconeStyle}}" aria-hidden="true"></i> {{$textValue}}</button>
                        </div>
                        </form>
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
                            {{$comment->date_comment}} | {{$comment->user->firstname}} {{$comment->user->lastname}} dit :
                        </div>
                        <div class="card-body">

                            {{$comment->comment}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection