@extends('layouts.app')

@section('content')
<br>
<h2>Editar Mecanico</h2>
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

        <form action="{{url('update_mecanico')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4">

                    <input type="hidden" name="uvid" value=" {{$mecanico->id}}">
                    <label>Nome</label>

                    <input type="text" name="unome" value=" {{$mecanico->nome}}" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>CPF</label>
                    <input type="text" name="ucpf" value="{{$mecanico->cpf}}" data-mask="000.000.000-00" class="form-control">
                </div>
                @php
                !empty($mecanico->nome_arquivo)?$nome_arquivo= $mecanico->nome_arquivo : $nome_arquivo = "sem_imagem.jpg"
                @endphp
                <div class="col-md-40">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control">
                    <img src="/storage/imagem/{{$nome_arquivo}}" width="300px">
                </div>


            </div>

            <br>
            <button type="submit" class="btn btn-primary">Editar Mecanico</button>
        </form>
    </div>
</div>
</div>
@stop