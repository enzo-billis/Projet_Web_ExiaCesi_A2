@extends('layouts.app')

@section('content')
    <div class="container">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="https://picsum.photos/1080/400" alt="First slide" width="100%" style="max-width: 1080px">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://picsum.photos/1080/401" alt="Second slide" width="100%" style="max-width: 1080px">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="https://picsum.photos/1080/399" alt="Third slide" width="100%" style="max-width: 1080px">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        <div class="container">

            <h1 class="my-4">Bienvenue sur le site du BDE Cesi Rouen !</h1>
            <div class="row">
                <div class="jumbotron">
                    <h1 class="display-4">Qui sommes-nous ?</h1>
                    <p class="lead">Site officiel du bureau des étudiants du CESI Rouen. </p>
                    <hr class="my-4">
                    <p>Ici, vous pourrez retrouver les prochaines activités que nous proposons, vous inscrire, poster des photos et des idées. Enfin une magnifique boutique est en place pour que vous puissiez vous procurez nos produits à un prix exorbitant !</p>
                    <p class="lead">
                        <a class="btn btn-primary btn-lg" href="/manif" role="button">Visiter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

