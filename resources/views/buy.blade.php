@extends('layouts.app')

@section('content')

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>Vous avez bien payé !</li>
                </ul>
            </div>
        @endif
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
                                <td>{{$command->product}}</td>
                                <td>{{$command->quantity}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{route('validateBuy')}}"><button type="button" class="btn btn-primary">Payer</button></a>
            </div>
        </div>
    </div>
    @endsection