@extends('layouts.app')

@section('content')
<br>
<h2>Criar Conta</h2>
<br>
<div class="container">
    @if(session()->get('msg'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
{{session()->get('msg')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
    <span aria-hidden="true">&times;</span>
</button>
    </div>
    @endif
 <div class="card">
<div class="card-body">
<form action="{{ action('App\Http\Controllers\Login_con@create') }}" method="post">
     @csrf 
     <div class="row">
       <div class="col-md-4">
           <label>Nome</label>
           <input type="text" name="unome" class="form-control">
       </div>
       <div class="col-md-4">
           <label>Email</label>
           <input type="text" name="uemail" class="form-control">
       </div>
       <div class="col-md-4">
           <label>Senha</label>
           <input type="password" name="usenha" class="form-control">
       </div>
     </div>
     <br>
<button type="submit" class="btn btn-primary">Criar Conta</button>
    </form>
</div>
 </div>
</div>
     @stop