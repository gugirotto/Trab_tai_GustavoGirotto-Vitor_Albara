@extends('layouts.app')

@section('content')
<br>
<h2>Cadastrar Serviço</h2>
<br>
@if(session()->get('msg'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session()->get('msg')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
        <span aria-hidden="true">&times;</span>
    </button>
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
        <form action="{{ action('App\Http\Controllers\Serviço_con@create')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label>dia do serviço</label>
                    <input type="date" name="uhorario" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="usuario_id">Nome: </label>
                    <select name="unome" class="form-control">
                        @foreach ($usuario as $item)
                        <option value="{{ $item->id }}" @if ($item->id == old('usuario_id', !empty($serviço->usuario_id)
                            ?? "")) selected="selected" @endif >
                            {{$item->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label>placa</label>
                    <input type="text" name="uplaca" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="mecanico_id">Mecanico: </label>
                    <select name="umecanico" class="form-control">
                        @foreach ($mecanico as $item)
                        <option value="{{ $item->id }}" @if ($item->id == old('mecanico_id', !empty($serviço->mecanico_id)
                            ?? "")) selected="selected" @endif >
                            {{$item->nome}}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control" >
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Cadastrar serviço</button>
        </form>
    </div>
</div>
</div>
@stop