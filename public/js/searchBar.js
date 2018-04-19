var availableTags = [];
$.getJSON("api/shop", function (data) {
    for (var i = 0; i < data.length; i++) {
        availableTags[i] = data[i].name;
    }
});

$(function () {
    $("#search").autocomplete({
        source: availableTags
    });
});

function actionForm(value) {
    let request = new XMLHttpRequest();
    request.open("GET", "/api/shop", false);
    request.send(null);
    let response = JSON.parse(request.responseText);
    filter("0");

    var containterE = document.getElementById("container");

    for (let i in response) {
        if (response[i].name == value) {
            let image = response[i].image;
            let deleteLink = "/shop/modify/" + response[i].id;
            let altLink = "/shop/rem/" + response[i].id;
            containterE.innerHTML = "";
            containterE.innerHTML = containterE.innerHTML +
                "<div class='col-md-4 card' style='padding : 0;'>" +
                "<div class='card-header' style='text-align: center;'>" +
                "<h1>" + response[i].name + "</h1>" +
                "<img src='" + image + "' style='max-width: 100%;' >" +

                "</div>" +
                "<div class='card-body' style='margin-top: 1em'>" +
                "<div style='text-align : center'>" +
                "<a href=" + deleteLink + "><button type=\"button\" class=\"btn btn-primary\"> <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> Modifier</button></a>" + " " +
                "<a href=" + altLink + "><button type=\"button\" class=\"btn btn-primary\"> <i class=\"fa fa-trash\" aria-hidden=\"true\"></i> Supprimer</button></a>" +
                "</div>" +
                "<p>" + response[i].description + "</p>" +
                "<p>" + response[i].price + " €</p>" +
                "<a href='/shop/cart/" + response[i].id + "'><button type=\"button\" class=\"btn btn-success\"> <i class=\"fa fa-shopping-basket\" aria-hidden=\"true\"></i> Ajouter au panier</button></a>" +
                "</div>" +
                "</div>"

        }
    }
}