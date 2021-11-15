@extends('layouts.app')
@section('script')
<script>$(document).ready(function($){
  $('#cpf').mask('000.000.000-00', {reverse: true});
 
  
});</script>
@endsection
@section('content')
<br>
<h2>Cadastrar Mecanico</h2>
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
        <form action="create_mec" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label>Nome</label>
                    <input type="text" name="unome" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>CPF</label>
                    <input type="text" name="ucpf" data-mask="000.000.000-00" class="form-control">
                </div>
                <div class="col-md-5">
                    <label>Imagem:</label>
                    <input type="file" name="nome_arquivo" class="form-control" >
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Cadastrar mecanico</button>
        </form>
    </div>
</div>
</div>
@stop