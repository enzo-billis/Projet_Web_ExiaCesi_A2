@extends('layouts.app')

@section('content')
    <nav class="navbar bg-light">

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Link 1</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link 3</a>
            </li>
        </ul>

    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Gestion utilisateurs</div>
                    <div class="card-body">Basic card</div>
                </div>
            </div>
        </div>
    </div>
@endsection