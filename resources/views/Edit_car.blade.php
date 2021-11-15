@extends('layouts.app')

@section('content')
<br>
<h2>Editar Veiculo</h2>
<br>
@if(session()->get('message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    (session()->get('message'))
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"></button>
    <span aria-hidden="true">&times;</span>
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

<div class="card">
    <div class="card-body">
        <form action="{{ action('App\Http\Controllers\Carro_con@updatecar', $veiculo->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="uvid" value=" {{$veiculo->id}}">
                    <label>Marca</label>
                    <input type="text" name="umarca" value=" {{$veiculo->marca}}" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>Modelo</label>
                    <input type="text" name="umodelo" value="{{$veiculo->modelo}}" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>Placa</label>
                    <input type="text" name="uplaca" value="{{$veiculo->placa}}" class="form-control">
                </div>
                <br>
                <div class="form-group col-md-5">
                    <label>Tipo: </label>
                    <select name="utipo" class="form-control">
                        <option value="{{ $veiculo->tipo }}" @if ($veiculo->tipo == old('tipo', !empty($carro->tipo)
                            ?? "")) selected="selected" @endif >{{ $veiculo->tipo }}</option>
                        <option value="carro">carro</option>
                        <option value="moto">moto</option>
                        <option value="camionete">camionete</option>
                    </select>
                    <br>
                </div>
                @php
                !empty($veiculo->nome_arquivo)?$nome_arquivo= $veiculo->nome_arquivo : $nome_arquivo = "sem_imagem.jpg"
                @endphp
                <div class="col-md-40">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control">
                    <img src="/storage/imagem/{{$nome_arquivo}}" width="300px">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Editar Carro</button>
        </form>
    </div>
</div>

@stop