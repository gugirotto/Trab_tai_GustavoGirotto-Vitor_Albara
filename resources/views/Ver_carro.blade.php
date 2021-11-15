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
<h2>Veiculos</h2>
<br>
<a href="{{ url('pdfview_carro') }}">Download PDF</a>
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{(session()->get('success'))}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Fechar"></button>
    <span aria-hidden="true">&times;</span>
</div>
@endif
<form action="achar_carro" method="post">
    @csrf
    <div class="form-row">
        <div class="col-4">
            <input type="text" class="form-control" placeholder="Digite sua pesquisa..." name="valor" id="">
        </div>
        <div class="col-3">

            <select name="tipo" class="form-control" id="">
                <option value="name">Nome</option>
                <option value="marca">Marca</option>
                <option value="modelo">Modelo</option>
                <option value="tipeo">Tipo</option>
                <option value="placa">placa</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary"> <i class="fas fa-search"></i> Buscar</button>
        <p><a href="{{url('/create_carro')}}" class="btn btn-danger">cadastrar Veiculo</a></p>
        <p><a href="{{url('/email_carro')}}" class="btn btn-warning">Enviar Email </a></p>

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
                            <th scope="col">marca</th>
                            <th scope="col">modelo</th>
                            <th scope="col">tipo</th>
                            <th scope="col">placa</th>
                            <th scope="col">editar</th>
                            <th scope="col">deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $p) : ?>
                            @php
                            !empty($p->nome_arquivo)?$nome_arquivo= $p->nome_arquivo : $nome_arquivo = "sem_imagem.jpg"
                            @endphp
                            <tr>
                                <td><?= $p->id; ?></td>
                                <td> <img src="/storage/imagem/{{$nome_arquivo}}" width="200px"></td>

                                <td><?= $p->loginveiculo->name; ?></td>

                                <td><?= $p->marca; ?></td>
                                <td><?= $p->modelo; ?></td>
                                <td><?= $p->tipo; ?></td>
                                <td><?= $p->placa; ?> </td>
                                <td><a href="{{ action('App\Http\Controllers\Carro_con@Editcarro', $p->id) }}" class="btn btn-info"></a>Editar</td>
                                <td><a href="Delete_Carro/{{$p->id}}" class="btn btn-danger"></a>Deletar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
        </div>

    </div>
    @stop
 