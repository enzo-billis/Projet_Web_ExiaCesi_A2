@extends('layouts.app')

@section('content')
    <a href="new"></a>
    <div id="list" class="row"></div>
    <script>
        let request = new XMLHttpRequest();
        request.open("GET","{{route('APICatalog')}}",false);
        request.send(null);
        let response = JSON.parse(request.responseText);

        expandResults();

        function expandResults () {

            for (let i in response) {
                list.innerHTML = list.innerHTML +
                    "<div class='col-md- offset-1' id='1'>" +
                    "<div class='card'>" +
                    "<div class='card-header' style='text-align: center'>" +
                    "<h1>" + response[i].name + "</h1>" +
                    "<img src=" + response[i].image + "><br>" +
                    "</div>" +
                    "<div class='card-body'>" +
                    response[i].description + "<br>" +
                    response[i].price + "<br>" +
                    "</div>" + "</div>" + "</div>";
            }
        }
        </script>
@endsection