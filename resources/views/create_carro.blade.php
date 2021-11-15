@extends('layouts.app')


@section('content')

<br>
<h2>Cadastrar Veiculo</h2>
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
        <form action="create_car" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label>Marca</label>
                    <input type="text" name="umarca" class="form-control" >
                </div>
                <div class="col-md-5">
                    <label>Modelo</label>
                    <input type="text" name="umodelo" class="form-control" >
                </div>
                <div class="col-md-5">
                    <label>Placa</label>
                    <input type="text" name="uplaca" class="form-control" >
                </div>
                <div class="form-group col-md-5">
                <label>Tipo: </label>
                    <select name="utipo" class="form-control">
                        <option value="carro">carro</option>
                        <option value="moto">moto</option>
                        <option value="camionete">camionete</option>
                    </select>
                    <br>
                </div>
                <div class="col-md-5">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control" >
                </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Criar Carro</button>
        </form>
    </div>
</div>
</div>
@stop