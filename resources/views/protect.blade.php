@extends('layouts.app')

@section('content')

<br>
<div class="container">
   
 <div class="card">
<div class="card-body">
    <h1>Bem-vindo {{$username}}</h1>
    <p><a href="{{url('/Ver_carro')}}" class = "btn btn-danger">Carros</a></p>
    <p><a href="{{url('/Ver_serviço')}}" class = "btn btn-danger"> Serviços</a></p>
    <p><a href="{{url('/Ver_mecanico')}}" class = "btn btn-danger"> Mecanicos</a></p>
    <p><a href="{{url('/logout')}}" class = "btn btn-danger">Log Out</a></p>

</div>
 </div>
</div>

@stop