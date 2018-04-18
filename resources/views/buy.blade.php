@extends('layouts.app')

@section('content')
<?php $total=0 ?>
    <div class="container">
        <div class="col-md" id="1">
            <div class="card">
                <div class="card-header">
                    Votre panier
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($commands as $command)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$command->catalog->name}}</td>
                                <td>{{$command->quantity}}</td>
                                <td>{{$command->catalog->price}}€</td>
                            </tr>
                            <?php $total=($command->catalog->price)*($command->quantity)+$total ?>
                        @endforeach
                        </tbody>
                    </table>
                    Total : {{$total}} €
                </div>
            </div>
        </div>
    </div>
@endsection