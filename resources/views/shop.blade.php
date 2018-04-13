@extends('layouts.app')

@section('content')

    <a href="{{route('newProduct')}}">Add product</a>

    <div id="list" class="row"></div>
    @foreach($catalogs as $catalog)
        <div class='col-md- offset-1' id='1'>
            <div class='card'>
                <div class='card-header' style='text-align: center'>
                    <h1>{{$catalog->name}}</h1>
                    <a href="#">edit</a>
                    <a href="{{route('delProduct',$catalog->name)}}">remove</a>
                    <img src="{{$catalog->image}}">
                </div>
                <div class="card-body">
                    <p>{{$catalog->description}}</p>
                    <p>{{$catalog->price}}</p>
                </div>
            </div>
        </div>
    @endforeach
    }}
@endsection