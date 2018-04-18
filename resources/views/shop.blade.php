@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
            <div class=" col-4-md">
                <a href="{{route('cart')}}"><button type="button" class="btn btn-info"><i class="fa fa-shopping-basket" aria-hidden="true"></i> Mon panier</button></a>
            </div>
        @if(Auth::user()->isRang(1))
            <div class="offset-8 col-4-md ">
                <a href="{{route('newProduct')}}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter un produit</button></a>
            </div>
        @endif
    </div>
    <br>
    <div class="row">
        <div class="col-4-md" >
            <label style="padding-top: 6px "  for="filterValue">Filtrer:</label>
            <select class="form-control " id="filterValue" name="filterValue" onchange="filter(this.value)">
                <option value="0">Tout</option>
                <option value="1">Vêtements</option>
                <option value="2">Goodies</option>
                <option value="3">Divers</option>
            </select>

        </div>
        <div class="offset-2 col-3-md">
            <label style="padding-top: 6px ">Rechercher :</label><input class="form-control" type="search">
        </div>
    </div>


<div id="container" class="d-flex flex-wrap container" style="margin-top: 2em">

    </div>
</div>
    <script>
        let request = new XMLHttpRequest();
        request.open("GET", "{{route('APICatalog')}}", false);
        request.send(null);
        let response = JSON.parse(request.responseText);
        filter("0");

        function filter(filterValue) {
        containterE = document.getElementById("container");
        containterE.innerHTML = "";
            for (let i in response) {
            if (filterValue == 0) {
                let image = response[i].image;
                let deleteLink = "/shop/modify/"+response[i].id;
                let altLink = "/shop/rem/"+response[i].id;
                containterE.innerHTML = containterE.innerHTML +
                    "<div class='col-md-4 card' style='padding : 0;'>" +
                    "<div class='card-header' style='text-align: center;'>" +
                    "<h1>"+ response[i].name +"</h1>" +
                    "<img src='"+ image +"' style='max-width: 100%;' >" +

                    "</div>" +
                    "<div class='card-body' style='margin-top: 1em'>" +
                    "<div style='text-align : center'>" +
                    "<a href="+ deleteLink +"><button type=\"button\" class=\"btn btn-primary\"> <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> Modifier</button></a>" + " "+
                    "<a href="+ altLink +"><button type=\"button\" class=\"btn btn-primary\"> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> Supprimer</button></a>" +
                    "</div>" +
                    "<p>"+response[i].description+"</p>" +
                    "<p>"+response[i].price+ " €</p>" +
                    "<a href='/shop/cart/"+response[i].id+"'><button type=\"button\" class=\"btn btn-success\"> <i class=\"fa fa-shopping-basket\" aria-hidden=\"true\"></i> Ajouter au panier</button></a>"
                    "</div>" +
                    "</div>"
            }
            else {
                if (response[i].category == filterValue) {
                    let image = response[i].image;
                    let deleteLink = "/shop/modify/"+response[i].id;
                    let altLink = "/shop/rem/"+response[i].id;
                    containterE.innerHTML = containterE.innerHTML +
                        "<div class='col-md-4 card' style='padding : 0;'>" +
                        "<div class='card-header' style='text-align: center;'>" +
                        "<h1>"+ response[i].name +"</h1>" +
                        "<img src='"+ image +"' style='max-width: 100%;' >" +

                        "</div>" +
                        "<div class='card-body' style='margin-top: 1em'>" +
                        "<div style='text-align : center'>" +
                        "<a href="+ deleteLink +"><button type=\"button\" class=\"btn btn-primary\"> <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> Modifier</button></a>" + " "+
                        "<a href="+ altLink +"><button type=\"button\" class=\"btn btn-primary\">Supprimer</button></a>" +
                        "</div>" +
                        "<p>"+response[i].description+"</p>" +
                        "<p>"+response[i].price+ " €</p>" +
                        "<a href='/shop/cart/"+response[i].id+"'><button type=\"button\" class=\"btn btn-success\"> <i class=\"fa fa-shopping-basket\" aria-hidden=\"true\"></i> Ajouter au panier</button></a>"
                        "</div>" +
                        "</div>"
                    }
                }
            }
        }
    </script>
@endsection