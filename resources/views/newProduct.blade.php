@extends('layouts.app')

@section('content')
    <div class="container">
            <div class="card">
                <div class="card-header">Ajouter un produit</div>
                <div class="card-body">
                    <form action="{{route('PostNewProduct')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <label for="name" id="lname">Nom :<input  class="form-control" id="name" type="text" name="name"></label><br>
                        <label for="price" id="lprice" >Prix :<input  class="form-control" id="price" type="number" name="price" min="0.01" max="999.99" step="0.01"></label><br>
                        <label for="description" id="ldescription" >Description :<textarea  class="form-control" id="description" name="description"></textarea></label><br>
                        <label for="category" id="lcategory" >Catégorie :<select  class="form-control" name='category' id='category'>
                                <option value='1'>Vêtements</option>
                                <option value='2'>Goodies</option>
                                <option value='3'>Divers</option>
                            </select></label><br>
                        <label>Image du produit :</label>
                        <input type="file" id="image" name="image" class="form-control-file">
                        <br>
                        <button type="submit" class="btn btn-success">Ajouter</button>
                    </form>
                </div>
            </div>
    </div>

@endsection