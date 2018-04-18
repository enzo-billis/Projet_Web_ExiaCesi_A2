@extends('layouts.app')

@section('content')

    <div class="col-md- offset-1" id="1">
        <div class="card">
            <div class="card-header">

                <tr>
                    <th>Produit</th>
                    <th>quantité</th>
                    <th>action</th>
                </tr>
                @foreach($command as $brought)
                    @if (Auth::user() == $brought->user)
                <tr>
                    <td>{{route('showProductName')}}</td>
                    <td>{{$brought-quantity}}</td>
                    <td>{{$brought->action}}</td>
                </tr>
                    @endif
                @endforeach
            </div>
        </div>
    </div>