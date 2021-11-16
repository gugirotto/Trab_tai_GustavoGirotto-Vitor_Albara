<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Login;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMailCarro;
use App\Charts\VeiculoChart;
class Carro_con extends Controller
{
    public function index(Request $c)
    {
        
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }
            else{ return view("create_carro");}
       
    }

    public function createc(Request $c)
    {
        
        //função de criar o carro
        $marca = $c->umarca;
        $id = $c->uvid;
        $modelo = $c->umodelo;
        $nome = $c->session()->get('user_id');
        $tipo = $c->utipo;
        $placa = $c->uplaca;
        
        // ifs para ver se já não existe
        if (App\Models\Carro::where('id', $id)->exists()) {
            return redirect('/create_carro')->with('msg', 'Veiculo já cadastrado');
        } elseif (App\Models\Carro::where('placa', $placa)->exists()) {
            return redirect('/create_carro')->with('msg', 'Veiculo já cadastrado');
        } else {
            $veiculo = new App\Models\Carro;
            $c->validate([
                'umarca' => 'required|max:80',
                'umodelo' =>'required|max:150',
                'uplaca' => 'required|max:20',
                'utipo' => 'required|max:50',
                'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
            ],[
                'umarca.required'=> 'O campo marca precisa ter um valor',
                'umarca.max'=>'O maximo de caracteres é 80',
                'umodelo.required'=> 'O campo modelo precisa ter um valor',
                'umodelo.max'=>'O maximo de caracteres é 150',
                'uplaca.required'=> 'O campo placa precisa ter um valor',
                'uplaca.max'=>'O maximo de caracteres é 20',
                'utipo.required'=> 'O campo tipo precisa ter um valor',
                'utipo.max'=>'O maximo de caracteres é 50',
            ]);
            $input= $c->all();
            $image = $c->file("nome_arquivo");
            
            if($image){

            
            $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
            $c->nome_arquivo->storeAs(
                'public/imagem',  $nome_arquivo
            );
            $veiculo -> nome_arquivo = $nome_arquivo;
        }
            $veiculo->marca = $marca;
            $veiculo->modelo = $modelo;
            $veiculo->placa = $placa;
            $veiculo->id = $id;
            $veiculo->usuario_id = $nome;
            $veiculo->tipo = $tipo;
            
            
            $criado = $veiculo->save();
            $username = $c->session()->get('user_nome');
            $capsule = array('username' => $username);
            if ($criado) {
                
                $fetch_data = App\Models\Carro::paginate(10);
        $capsulecar = array('data' => $fetch_data);
        return redirect('Ver_carro')->with($capsulecar,$capsule)->with('success', 'criado com sucesso');
               
            }
        }
    }
    // função para mostrar  na tabela
    public function Fetchcar(Request $c)
    {
        $fetch_data = App\Models\Carro::paginate(10);
        $chart = new VeiculoChart();
        $capsulecar = array('data' => $fetch_data,'chartCarro'=>$chart->build());
        if($c->session()->get('user_id')==""){
            \dd($c);
            return redirect('/login');
            }else{
        return view('Ver_carro')->with($capsulecar);
        }
    }
    //função para editar
    public function EditCarro($id, Request $c)
    {
        $veiculo = Carro::findOrFail($id);
        //$teste_relaçao =  $veiculo->loginveiculo;
    //\dd($teste_relaçao ->name);
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
                return view('Edit_car')->with(['veiculo' => $veiculo]);
            }
    }
    public function updatecar(Request $c)
    {
        $c->validate([
            'umarca' => 'required|max:80',
            'umodelo' =>'required|max:150',
            'uplaca' => 'required|max:20',
            'utipo' => 'required|max:50',
            'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
        ],[
            'umarca.required'=> 'O campo marca precisa ter um valor',
            'umarca.max'=>'O maximo de caracteres é 80',
            'umodelo.required'=> 'O campo modelo precisa ter um valor',
            'umodelo.max'=>'O maximo de caracteres é 150',
            'uplaca.required'=> 'O campo placa precisa ter um valor',
            'uplaca.max'=>'O maximo de caracteres é 20',
            'utipo.required'=> 'O campo tipo precisa ter um valor',
            'utipo.max'=>'O maximo de caracteres é 50',
        ]);
        $updatecar_id = $c->uvid;

        $marca = $c->umarca;
        $modelo = $c->umodelo;
        $placa = $c->uplaca;
        $tipo = $c->utipo;

        $update = App\Models\Carro::find($updatecar_id);
        $image = $c->file("nome_arquivo");
            
            if($image){

            
            $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
            $c->nome_arquivo->storeAs(
                'public/imagem',  $nome_arquivo
            );
            $update -> nome_arquivo = $nome_arquivo;
        }
        $update->marca = $marca;
        $update->tipo = $tipo;
        $update->modelo = $modelo;
        $update->placa = $placa;
        $updated = $update->save();

        if ($updated) {
            return redirect('Ver_carro')->with('success', "Dados Atualizados com sucesso");
        }
    }
    //função para remover
    public function removecarro(Request $c)
    {
        
        $delete_id = $c->id; 
        $delete_data = App\Models\Carro::find($delete_id);
        $deleta_imagem = $c->nome_arquivo;
        $deletaimg= App\Models\Carro::find($deleta_imagem);
        
        if(Storage::exists("public/imagem/".$delete_data->nome_arquivo)){
            Storage::delete("public/imagem/".$delete_data->nome_arquivo);
        }
        $deleted = $delete_data->delete();

        if ($deleted) {
            return redirect('/Ver_carro')->with('success', 'Dados Deletados com sucesso');
        }
    }
    //funçao de busca
    public function searchcar(Request $c)
    {
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else
        if ($c->tipo == "name") {
            $objResult = Carro::whereHas('loginveiculo', function (Builder $query) use (&$c) {
                $query->where('name', 'like', "%" . $c->valor . "%");
            })->paginate(10);
        } else if ($c->tipo == "modelo") {
            $objResult =  Carro::where('modelo', 'like', "%" . $c->valor . "%")->paginate(10);
        } else if ($c->tipo == "tipeo") {
            $objResult =  Carro::where('tipo', 'like', "%" . $c->valor . "%")->paginate(10);
        } else if ($c->tipo == "placa") {
            $objResult =  Carro::where('placa', 'like', "%" . $c->valor . "%")->paginate(10);
        }else if ($c->tipo == "marca") {
            $objResult =  Carro::where('marca', 'like', "%" . $c->valor . "%")->paginate(10);
        }
        $chart = new VeiculoChart();
        return view('Ver_carro')->with(['data' => $objResult, 'chartCarro'=>$chart->build()]);
    }
    // função pra gerar o pdf
    public function pdfview(Request $c)
    {

        $arrCarr = App\Models\Carro::all();
        $string = '<h1>Carros:</h1>';

        foreach ($arrCarr as $m) {
            $string = $string . "<h4>{$m->id}-{$m->loginveiculo->name} - {$m->marca} - {$m->modelo} - {$m->placa} - {$m->tipo}</h4>";
        }


        $pdf = PDF::loadHtml($string);
        return $pdf->download('pdfview.pdf');
    }
    public function sendEmail(Request $c){
        $fetch_dataa = [];
        $fetch_dataa['veiculo'] = App\Models\Carro::all();
       
        Mail::to('gustavo.g1@aluno.ifsc.edu.br')-> send(new sendMailCarro($fetch_dataa));
        $fetch_data = App\Models\Carro::paginate(10);
        $capsulecar = array('data' => $fetch_data);
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
        return view('Ver_carro')->with($capsulecar)->with('success','Email enviado com sucesso');
        }
    }

}
