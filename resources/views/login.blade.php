@extends('layouts.app')

@section('content')
<br>
<h2>Login</h2>
<br>
<div class="container">
    @if(session()->get('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
{{session()->get('msg')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
    <span aria-hidden="true">&times;</span>
</button>
    </div>
    @endif
 <div class="card">
<div class="card-body">
<form action="check" method="post" enctype="multipart/form-data">
     @csrf 
     <div class="row">
       
       <div class="col-md-6">
           <label>Insira seu Email</label>
           <input type="text" name="uemail" class="form-control" >
       </div>
       <div class="col-md-6">
           <label>insira sua Senha</label>
           <input type="password" name="usenha" class="form-control" >
       </div>
       
     </div>
     <br>
<button type="submit" class="btn btn-primary">Logar</button>
<a href="{{url('/create_account')}}" class="btn btn-primary">Criar Conta</a>
    </form>
    
</div>
 </div>
</div>

@stop