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
                        <div >
                        <form style="display: inline-block" method="post" action="{{ route('VoteUp',$idea->id) }}">
                            {{csrf_field()}}
                            <button id="upButton" type="submit" onmouseover="changeToPrimary(this)" onmouseleave="changeUpToLight(this)" class="{{$buttonStyleUp}}"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like</button>
                        </form>
                        <form style="display: inline-block" method="post" action="{{ route('VoteDown',$idea->id) }}">
                            {{csrf_field()}}
                            <button id="downButton" type="submit" onmouseover="changeToDanger(this)" onmouseleave="changeDownToLight(this)" class="{{$buttonStyleDown}}"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Dislike</button>
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
    </script>
@endsection