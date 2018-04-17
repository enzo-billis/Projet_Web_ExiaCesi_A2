@extends('layouts.app')
@section('content')
<div class="container">
    <a href="{{route('newProduct')}}">Add product</a>
    <label for="filterValue">filtrer par catégorie</label>
    <select id="filterValue" name="filterValue" onchange="filter(this.value)">
        <option value="0">Tout</option>
        <option value="1">Vêtements</option>
        <option value="2">Goodies</option>
        <option value="3">Divers</option>
    </select>
<div id="container" class="col">

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
                let deleteLink = "/shop/modify/"+response[i].name;
                let altLink = "/shop/rem/"+response[i].name;
                containterE.innerHTML = containterE.innerHTML +
                    "<div class='col-md- offset-1' id='1'>" +
                    "<div class='card'>" +
                    "<div class='card-header' style='text-align: center'>" +
                    "<h1>"+ response[i].name +"</h1>" +
                    "<a href="+ deleteLink +">"+"modifier"+"</a>" + "<br>" +
                    "<a href="+ altLink +">"+"retirer"+"</a>" +
                    "<img src="+ image +">" +
                    "</div>" +
                    "<div class='card-body'>" +
                    "<p>"+response[i].description+"</p>" +
                    "<p>"+response[i].price+"</p>" +
                    "<a href='/shop/cart/"+response[i].name+"'>add to cart</a>"
                    "</div>" +
                    "</div>"
            }
            else {
                if (response[i].category == filterValue) {
                    let image = response[i].image;
                    let deleteLink = "/shop/modify/"+response[i].name;
                    let altLink = "/shop/rem/"+response[i].name;
                    containterE.innerHTML = containterE.innerHTML +
                        "<div class='col-md- offset-1' id='1'>" +
                        "<div class='card'>" +
                        "<div class='card-header' style='text-align: center'>" +
                        "<h1>"+ response[i].name +"</h1>" +
                        "<a href="+ deleteLink +">modifier</a>" + "<br>" +
                        "<a href="+ altLink +">retirer</a>" +
                        "<img src="+ image +">" +
                        "</div>" +
                        "<div class='card-body'>" +
                        "<p>"+response[i].description+"</p>" +
                        "<p>"+response[i].price+"</p>" +
                        "<a href='/shop/cart/"+response[i].name+"'>add to cart</a>"
                        "</div>" +
                        "</div>"
                    }
                }
            }
        }
    </script>
@endsection