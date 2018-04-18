@extends('layouts.app')

@section('content')
    <div class="col-md- offset-1" id="1">
        <div class="card">
            <div class="card-header">Modifier le produit</div>
            <div class="card-body">
                @foreach($catalog as $article):
                <form action="{{route('PostAltProduct')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label for="name" id="lname" class="form-control">Name <input id="name" type="text" name="name" value="{{$article->name}}"></label><br>
                    <label for="price" id="lprice" class="form-control">price<input id="price" type="number" name="price" min="0.01" max="999.99" step="0.01" value="{{$article->price}}"></label><br>
                    <label for="description" id="ldescription" class="form-control">description<textarea id="description" name="description">{{$article->description}}</textarea></label><br>
                    <label for="category" id="lcategory" class="form-control">category<select name='category' id='category'>
                            <option value='1'>1-Cloths</option>
                            <option value='2'>2-Goodies</option>
                            <option value='3'>3-Miscellaneous</option>
                        </select></label><br>
                    <input type="file" id="image" name="image" class="form-control" value="{{$article->image}}">
                    <input type="hidden" id="oldname" name="oldname" value="{{$article->name}}">
                    <input id="submit" type="submit">
                </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection