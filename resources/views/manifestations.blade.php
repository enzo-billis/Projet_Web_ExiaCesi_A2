@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-ml-center">
            <div class="form-group">
                <label for="sel1">Filtrer : </label>
                <select onchange="expandResults(this.value)"  class="form-control" id="sell" name="manifStatus">
                    <option value="0">Tout</option>
                    <option value="1">A venir</option>
                    <option value="2">Passés</option>
                    <option value="3">Du mois</option>
                </select>
            </div>
        </div>
        <div id="container" class="row">

        </div>

    </div>

    <script>

        var request = new XMLHttpRequest();
        request.open("GET", "{{route('APIManifs')}}", false);
        request.send(null);
        var responses = JSON.parse(request.responseText);

        expandResults("0");

        function expandResults(filterValue){
            containerE = document.getElementById("container");

            containerE.innerHTML = "";
            var date = new Date();
            actualDate = date.toISOString().substring(0, 10);
            fDate = new Date(date.getFullYear(), date.getMonth(), 2);
            firstDate = fDate.toISOString().substring(0, 10);
            lDate = new Date(date.getFullYear(), date.getMonth() + 1, 1);
            lastDate = lDate.toISOString().substring(0, 10);
            for (var i in responses){
                switch (filterValue) {
                    case "0" :
                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src="+responses[i].image+"><br>"+
                                responses[i].name+" | "+responses[i].date_add+"<br>"+
                                "</div> </a>"+
                                "<div class='card-body'>"+
                                "Nom : "+responses[i].name+"<br>"+
                                "Description : "+responses[i].description+"<br>"+
                                "</div>"+
                                "</div>"+
                                "</div>";
                        break;
                    case "1" :
                        if (responses[i].date_add >= actualDate) {

                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src="+responses[i].image+"><br>"+
                                responses[i].name+" | "+responses[i].date_add+"<br>"+
                                "</div> </a>"+
                                "<div class='card-body'>"+
                                "Nom : "+responses[i].name+"<br>"+
                                "Description : "+responses[i].description+"<br>"+
                                "</div>"+
                                "</div>"+
                                "</div>";
                        }
                        break;
                    case "2" :
                        if (responses[i].date_add < actualDate) {

                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src="+responses[i].image+"><br>"+
                                responses[i].name+" | "+responses[i].date_add+"<br>"+
                                "</div> </a>"+
                                "<div class='card-body'>"+
                                "Nom : "+responses[i].name+"<br>"+
                                "Description : "+responses[i].description+"<br>"+
                                "</div>"+
                                "</div>"+
                                "</div>";
                        }
                        break;
                    case "3" :
                        if (responses[i].date_add >= firstDate && responses[i].date_add <= lastDate) {

                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src="+responses[i].image+"><br>"+
                                responses[i].name+" | "+responses[i].date_add+"<br>"+
                                "</div> </a>"+
                                "<div class='card-body'>"+
                                "Nom : "+responses[i].name+"<br>"+
                                "Description : "+responses[i].description+"<br>"+
                                "</div>"+
                                "</div>"+
                                "</div>";

                        }
                        break;
                }
            }
        }
    </script>
@endsection