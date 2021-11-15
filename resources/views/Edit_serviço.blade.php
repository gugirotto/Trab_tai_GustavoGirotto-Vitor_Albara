@extends('layouts.app')

@section('content')
<br>
<h2>editar Serviço</h2>
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
        <form action="{{ action('App\Http\Controllers\Serviço_con@update', $servico->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="uvid" value="{{ $servico->id }}">
                    <label>horario</label>

                    <input type="date" name="uhorario" value="{{$servico->horario}}" class="form-control">
                </div>

                <div class="form-group col-md-5">
                    <label for="usuario">Nome: </label>
                    <select name="unome" class="form-control">
                        @foreach ($usuario as $item)
                        <option value="{{ $item->id }}" @if ($item->id == old('usuario_id', !empty($servico->usuario_id)
                            ?? "")) selected="selected" @endif >
                            {{$item->name}}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <label>placa</label>
                    <input type="text" name="uplaca" value="{{$servico->placa}}" class="form-control">
                </div>

                <div class="form-group col-md-5">
                    <label for="mecanico">mecanico: </label>
                    <select name="umecanico" class="form-control">
                        @foreach ($mecanico as $item)
                        <option value="{{ $item->id }}" @if ($item->id == old('mecanico_id', !empty($servico->mecanico_id)
                            ?? "")) selected="selected" @endif >
                            {{$item->nome}}
                        </option>
                        @endforeach
                    </select>
                    <br>
                    @php
                !empty($servico->nome_arquivo)?$nome_arquivo= $servico->nome_arquivo : $nome_arquivo = "sem_imagem.jpg"
                @endphp
                <div class="col-md-40">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control">
                    <img src="/storage/imagem/{{$nome_arquivo}}" value="{{$serviço->nome_arquivo}" width="300px">
                </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Editar serviço</button>
        </form>
    </div>
</div>
</div>
@stop