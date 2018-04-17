@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row justify-content-ml-center">

            <div class="col-2" class="form-group">
                <label for="sel1">Filtrer</label>
                <select style="margin-bottom: 10px" onchange="expandResults(this.value)"  class="form-control" id="sell" name="manifStatus">
                    <option value="0">Tout</option>
                    <option value="1">A venir</option>
                    <option value="2">Passés</option>
                    <option value="3">Du mois</option>
                </select>
            </div>
            @if(isset(Auth::user()->id) && Auth::user()->rang==1)
                <div class="col-2 offset-7">
                    <button type="submit" class="btn btn-primary " data-toggle="modal" data-target="#addActivitie" >
                        Ajouter une activité
                    </button>
                </div>
            @endif
        </div>
        <div id="container" class="row">

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="addActivitie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une activité</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('newManif')}}" enctype="multipart/form-data">

                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Nom : </label>
                            <input type="text" class="form-control-file" id="name" name="name">
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Description : </label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Image de couverture : </label>
                        <input type="file" accept="image/*" class="form-control-file" id="file" name="photo">
                            </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Reccurence : </label>
                        <select class="form-control" id="recurrence" name="recurrence">
                            <option value="Ponctuelle">Ponctuelle</option>
                            <option value="Mensuelle">Mensuelle</option>
                            <option value="Trimestrielle">Trimestrielle</option>
                            <option value="Annuelle">Annuelle</option>
                            <option value="N/C">N/C</option>
                        </select>
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Date : </label>
                        <input id="date" class="form-control" type="date" name="date">
                        </div>

                        <div class="form-group">
                        <label for="exampleFormControlFile1">Prix : </label>
                        <input type="number" class="form-control" id="price" name="price">
                        </div>

                        <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

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
                        var image = responses[i].image;
                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=/manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src="+image+"><br>"+
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
                            var image = responses[i].image;

                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=/manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src=/"+image+"><br>"+
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
                            var image = responses[i].image;

                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src=/storage/"+image+"><br>"+
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
                                var image = responses[i].image;
                            containerE.innerHTML = containerE.innerHTML +
                                "<div class='col-md-5 offset-1' id='1'>" +
                                "<div class='card'>" +
                                "<a href=/manif/" + responses[i].id + ""+" ><div class='card-header' style='text-align: center'>"+
                                "<img src=/"+image+"><br>"+
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