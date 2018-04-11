@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div id="alert" style="height: 60px;" >
                <br><br><br>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Inscription') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                            <div class="col-md-6">
                                <input id="firstname"  type="text" onblur="alertFirstName(this.value)" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" onblur="alertLastName(this.value)" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" onblur="alertMailName(this.value)" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" onblur="alertPassword(this.value)" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation du mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" onblur="alertPasswordConf(this.value)" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="sendButton" type="submit" class="btn btn-primary" disabled>
                                    {{ __("S'enregistrer") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
         elem = document.getElementById("alert");
        function alertFirstName(value){
            var elem = document.getElementById("alert");
            var test = document.getElementById("firstname");
            if (value === "" || value === " "){

                elem.innerHTML="<br>";
                elem.innerHTML = "<div class='alert alert-danger' role='alert'>\n" +
                    "  Merci de renseigner votre prénom ! " +
                    "</div>";
                test.setAttribute("data-toggle","popover");
                test.setAttribute("data-placement","right");
                test.setAttribute("data-content","Merci de renseigner votre prénom !");
                document.getElementById('sendButton').setAttribute("disabled","disabled");
            }
            else {
                elem.innerHTML="<br>";
                document.getElementById('sendButton').removeAttribute("disabled");
            }

        }
        function alertLastName(value){
            var elem = document.getElementById("alert");
            if (value === "" || value === " ") {
                elem.innerHTML = "";
                elem.innerHTML = "<div class='alert alert-danger' role='alert'>\n" +
                    "  Merci de renseigner votre nom de famille ! " +
                    "</div>";

                document.getElementById('sendButton').setAttribute("disabled","disabled");
            }
            else {
                elem.innerHTML="<br>";
                document.getElementById('sendButton').removeAttribute("disabled");

            }
        }
        function alertMailName(value){
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var elem = document.getElementById("alert");
            if (re.test(value)==true) {
                elem.innerHTML = "<br>";
                document.getElementById('sendButton').removeAttribute("disabled");
            }
            else {
                elem.innerHTML = "<br>";
                elem.innerHTML = "<div class='alert alert-danger' role='alert'>\n" +
                    "  Merci de rentrer une adresse mail valide " +
                    "</div>";
                document.getElementById('sendButton').setAttribute("disabled","disabled");
            }
        }
        function alertPassword(value){
            var re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/;
            var elem = document.getElementById("alert");
            if (re.test(value)==true) {
                elem.innerHTML = "<br>";
                document.getElementById('sendButton').removeAttribute("disabled");
            }
            else {
                elem.innerHTML = "<br>";
                elem.innerHTML = "<div class='alert alert-danger' role='alert'>\n" +
                    "  Le mot de passe doit contenir une majuscule, un chiffre et au moins 6 caractères ! " +
                    "</div>";
                document.getElementById('sendButton').setAttribute("disabled","disabled");
            }
        }
        function alertPasswordConf(value){
            var elem = document.getElementById("alert");
            if (value !== password.value || !value){
                elem.innerHTML = "<br>";
                elem.innerHTML = "<div class='alert alert-danger' role='alert'>\n" +
                    "  Les mots de passes ne correspondent pas ! " +
                    "</div>";
                document.getElementById('sendButton').setAttribute("disabled","disabled");
            }
            else{
                elem.innerHTML = "<br>";
                document.getElementById('sendButton').removeAttribute("disabled");
            }
        }
    </script>
@endsection
