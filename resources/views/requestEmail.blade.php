@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Solicitud</div>
                @if ($error)
                <div class="card-body">
                    <div class="alert alert-danger text-center" role="alert">
                        <p>{{ $message }}</p>
                        <a href="https://parking.derco.com.pe/" class="btn btn-success">Regresar</a>
                    </div>
                </div>
                @else
                <div class="card-body">
                    <div class="alert alert-success text-center" role="alert">
                        <p>{{ $message }}</p>
                        <a href="https://parking.derco.com.pe/" class="btn btn-success">Regresar</a>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection