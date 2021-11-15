@extends('layouts.app')
@section('grafico')
<div class="row">
        <div class="col-6">
        {{ $chartCarro->container()}}
        {{ $chartCarro->script() }}
        </div>
@stop

@section('content')
<br>
<h2>Ver dados de mecanicos</h2>
<br>
<a href="{{ url('pdfview_mecanico') }}">Download PDF</a>
<p>(coloque o cpf com os pontos e os traços)</p>
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{(session()->get('success'))}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"></button>
    <span aria-hidden="true">&times;</span>
</div>
@endif
<form action="achar_mecanico" method="post">
    @csrf
    <div class="form-row">
        <div class="col-3">
            <input type="text" class="form-control" placeholder="Digite sua pesquisa..." name="valor">
        </div>
        <div class="col-3">

            <select name="tipo" class="form-control">
                <option value="nome">Nome</option>
                <option value="cpf "  data-mask="000.000.000-00">CPF</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Buscar</button>
        <p><a href="{{url('/create_mecanico')}}" class="btn btn-danger">Cadastrar Mecanico </a></p>
        <p><a href="{{url('/email_mecanico')}}" class="btn btn-warning">Enviar Email </a></p>
    </div>

</form>
<div class='container'>
    <div class='card'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">imagem</th>
                            <th scope="col">nome</th>
                            <th scope="col">CPF</th>

                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php foreach ($data as $p) : ?>
                            @php
                !empty($p->nome_arquivo)?$nome_arquivo= $p->nome_arquivo : $nome_arquivo = "sem_imagem.jpg"
                @endphp
                            <tr>
                                <td><?= $p->id; ?></td>
                                <td>    <img src="/storage/imagem/{{$nome_arquivo}}" width="200px"></td>
                                <td><?= $p->nome; ?></td>
                                <td><?= $p->cpf; ?></td>

                                <td><a href="Edit_mecanico/{{$p->id}}" class="btn btn-info"></a>Editar</td>
                                <td><a href="Delete_mecanico/{{$p->id}}" class="btn btn-danger"></a>Deletar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
        </div>

    </div>
    @stop