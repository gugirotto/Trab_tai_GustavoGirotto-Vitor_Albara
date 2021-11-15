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
<h2>Ver dados de serviço</h2>
<br>
<a href="{{ url('pdfview_serviço') }}">Download PDF</a>
<p>Coloque o horario no formato YYYY-MM-DD</p>
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{(session()->get('success'))}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"></button>
    <span aria-hidden="true">&times;</span>
</div>
@endif
<form action="achar_serviço" method="post">
    @csrf
    <div class="form-row">
        <div class="col-3">
            <input type="text" class="form-control" placeholder="Digite sua pesquisa..." name="valor">
        </div>
        <div class="col-3">
            <select name="tipo" class="form-control">
                <option value="nome">Nome</option>
                <option value="mecanico">Mecanico</option>
                <option value="horario">horario</option>
                <option value="placa">Placa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Buscar</button>
        <p><a href="{{url('/create_serviço')}}" class="btn btn-danger">cadastrar Serviço</a></p>
        <p><a href="{{url('/email_serviço')}}" class="btn btn-warning">Enviar Email </a></p>
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
                            <th scope="col">mecanico</th>
                            <th scope="col">horario</th>
                            <th scope="col">placa</th>

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
                                <td><?= $p->loginserviço->name; ?></td>
                                <td><?= $p->mecanicoserviço->nome; ?></td>
                                <td><?= $p->horario; ?></td>
                                <td><?= $p->placa; ?></td>

                                <td><a href="{{ action('App\Http\Controllers\Serviço_con@Edit', $p->id) }}" class="btn btn-info"></a>Editar</td>
                                <td><a href="Delete_serviço/{{$p->id}}" class="btn btn-danger"></a>Deletar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
        </div>

    </div>
    @stop