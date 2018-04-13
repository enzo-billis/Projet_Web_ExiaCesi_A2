@extends('layouts.app')

@section('content')
    <div class="col-md- offset-1" id="1">
        <div class="card">
            <div class="card-header">nouveau produits</div>
            <div class="card-body">
                <form action="{{route('PostProduct')}}" method="post">
                    @csrf
                    <label for="name" id="lname" class="form-control">Name <input id="name" type="text" name="name"></label><br>
                    <label for="price" id="lprice" class="form-control">price<input id="price" type="number" name="price" min="0.01" max="999.99" step="0.01"></label><br>
                    <label for="description" id="ldescription" class="form-control">description<textarea id="description" name="description"></textarea></label><br>
                    <label for="category" id="lcategory" class="form-control">category<select name='category' id='category'>
                        <option value='1'>1-Cloths</option>
                        <option value='2'>2-Goodies</option>
                        <option value='3'>3-Miscellaneous</option>
                        </select></label><br>
                    <input type="file" id="image" name="image" class="form-control">
                    <input id="submit" type="submit">
                </form>
            </div>
        </div>
    </div>
@endsection