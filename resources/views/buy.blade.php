@extends('layouts.app')

@section('content')

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
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($commands as $command)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$command->catalog->name}}</td>
                                <td>{{$command->quantity}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection