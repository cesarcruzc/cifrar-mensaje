@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('respuesta'))
                    <div class="alert alert-success">
                        {{ session('razon') }} <a href="{{ route('mensaje.descargar', [session('archivo')]) }}">{{ session('archivo') }}</a>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Mensaje a encriptar</div>

                    <div class="card-body">
                        <form method="post" name="form-encriptar-mensaje" action="{{ route('mensaje.cifrar') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="mensaje">Mensaje</label>
                                <textarea name="mensaje" class="form-control" placeholder="Mensaje"></textarea>
                                <small id="mensajeHelp" class="form-text text-muted">Ingresa el mensaje a encriptar</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Encriptar y descargar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Desencriptar mensaje</div>

                    <div class="card-body">
                        <form method="post" name="form-desencriptar-mensaje" action="{{ route('mensaje.descifrar') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="mensaje">Mensaje encriptado</label>
                                <input type="file" name="archivo" class="form-control" name="archivo-mensaje" placeholder="Archivo">
                                <small id="mensajeHelp" class="form-text text-muted">Sube el archivo encriptado</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Desencriptar mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if (session('mensajeDescifrado'))
            <div class="row justify-content-center mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Contenido mensaje encriptado</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="alert alert-success">
                                    <p class="text-justify">
                                        {{ session('mensajeDescifrado') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
