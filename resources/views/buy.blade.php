@extends('layouts.app')

@section('content')

    <div class="col-md- offset-1" id="1">
        <div class="card">
            <div class="card-header">
                <h2>ta commande</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>quantité</th>
                            <th>date</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="tab-content">
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        let request = new XMLHttpRequest();
        request.open("GET", "{{route('APIBuy')}}", false);
        request.send(null);
        let response = JSON.parse(request.responseText);
        showCatalog();

        function showCatalog() {
        containerE = document.getElementById("tab-content");
        containerE.innerHTML = "";
        for (let i in response) {
                let removeBuy = "/cart/rem/"+response[i].id;
                let produit = "/cart/name/"+response[i].product;
                containerE.innerHTML = containerE.innerHTML +
                        "<tr>"+
                        "<td>"+"<p>"+produit+"</p>"+"</td>"+
                        "<td>"+"<p>"+response[i].quantity+"</p>"+"</td>"+
                        "<td>"+"<p>"+response[i].created_at+"</p>"+"</td>"+
                        "<td>"+"<a href='"+removeBuy+"'>"+"retirer"+"</a>" +"</td>"+
                        "</tr>"
            }
        }
    </script>
@endsection