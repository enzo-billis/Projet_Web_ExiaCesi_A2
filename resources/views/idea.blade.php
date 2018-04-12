@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        <img src={{$idea->image}} ><br>
                        {{ $idea->name }} | Par : {{ $firstname }} {{ $lastname }}<br>
                        Pour : {{ $upVotes }} | Contre : {{ $downVotes }}<br><br>
                        <div >
                        <form style="display: inline-block" method="post" action="{{ route('VoteUp',$idea->id) }}">
                            {{csrf_field()}}
                            <button type="submit" onmouseover="changeToPrimary(this)" onmouseleave="changeToLight(this)" class="{{$buttonStyleUp}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</button>
                        </form>
                        <form style="display: inline-block" method="post" action="{{ route('VoteDown',$idea->id) }}">
                            {{csrf_field()}}
                            <button type="submit" onmouseover="changeToDanger(this)" onmouseleave="changeToLight(this)" class="{{$buttonStyleDown}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Dislike</button>
                        </form>
                        </div>
                    </div>

                    <div class="card-body">
                        Nom : {{ $idea->name }}<br>
                        Description : {{ $idea->description }} <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function changeToDanger(elem){
            elem.classList.remove('btn-light');
            elem.classList.remove('btn-primary');
            elem.classList.add('btn-danger');
        }
        function changeToPrimary(elem){
            elem.classList.remove('btn-light');
            elem.classList.remove('btn-danger');
            elem.classList.add('btn-primary');
        }
        function changeToLight(elem){
            elem.classList.remove('btn-danger');
            elem.classList.remove('btn-primary');
            elem.classList.add('btn-light');
        }
    </script>
@endsection