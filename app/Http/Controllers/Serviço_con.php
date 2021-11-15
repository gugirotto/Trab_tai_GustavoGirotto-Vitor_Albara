<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Login;
use App\Models\Serviço;
use App\Models\Mecanico;
use App\Models\Carro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use App\Mail\sendMailCarro;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMailServico;
use App\Charts\VeiculoChart;

class Serviço_con extends Controller
{

    public function index(Request $c)
    {

        $nome_exibr = $c->name;

        $mecanico =  Mecanico::all();
        $login = Login::all();
        $veiculo = Carro::all();
        if ($c->session()->get('user_id') == "") {
            return redirect('/login');
        } else {
            return view('Create_serviço')->with(['mecanico' => $mecanico, 'usuario' => $login, 'veiculo' => $veiculo]);
        }
    }
    public function create(Request $c)
    {
        $horario = $c->uhorario;
        $id = $c->uvid;
        $meecanico = $c->umecanico;
        $placa = $c->uplaca;
        $mecanico =  Mecanico::all();
        $login = Login::all();
        $nome = $c->session()->get('user_id');
        $c->validate([
            'uhorario' => ['required'],
            'unome' => ['required'],
            'umecanico' => ['required'],
            'uplaca' => ['required', 'max:20'],
            'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
        ], [
            'uhorario.required' => 'O campo horario precisa ter um valor',
            'unome.required' => 'O campo nome precisa ter um valor',
            'uplaca.required' => 'O campo placa precisa ter um valor',
            'uplaca.max' => 'O maximo de caracteres é 20',
            'umecanico.required' => 'O campo tipo precisa ter um valor',
        ]);

        $serviço = new App\Models\Serviço;
        $image = $c->file("nome_arquivo");
            
        if($image){

        
        $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
        $c->nome_arquivo->storeAs(
            'public/imagem',  $nome_arquivo
        );
        $mecanico -> nome_arquivo = $nome_arquivo;
    }
        $serviço->horario = $c->uhorario;
        $serviço->usuario_id = $nome;
        $serviço->id = $id;
        $serviço->mecanico_id = $meecanico;
        $serviço->placa = $placa;



        $criado = $serviço->save();
        $username = $c->session()->get('user_nome');
        $capsule = array('username' => $username);
        if ($criado) {
            $mecanico =  Mecanico::all();
            $login = Login::all();
            $data = Serviço::paginate(10);

            return redirect('Ver_serviço')->with(['mecanico' => $mecanico, 'usuario' => $login, 'data' => $data], $capsule,'success', 'criado com sucesso');
        } else {
            return redirect('/create_serviço')->with('msg', 'Dados não encontrados no banco de dados');
        }
    }
    public function Fetch(Request $c)
    {
        // 1 puxa os dados do usuario
       // $servico=Serviço::find(1)->many()->orderby('placa')->get();
       $servico=Serviço::find(1);
       
        
        $mecanico =  Mecanico::all();
        /*foreach($mecanico as $item){
            \dd($item->cpf);
           }
           */
        $login = Login::all();
        $chart = new VeiculoChart();
        $data = Serviço::paginate(10);
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
        return view('Ver_serviço')->with(['mecanico' => $mecanico, 'usuario' => $login, 'data' => $data, 'chartCarro'=>$chart->build()]);
            }
    }

    public function Edit($id,Request $c)
    {
        $servico = Serviço::findOrFail($id);
        $mecanico =  Mecanico::all();
        $login = Login::all();
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
        return view('Edit_serviço')->with(['servico' => $servico, 'mecanico' => $mecanico, 'usuario' => $login]);
            }
    }
    public function update(Request $request)
    {

        $update = Serviço::find($request->uvid);
        $image = $request->file("nome_arquivo");
            
            if($image){

            
            $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
            $request->nome_arquivo->storeAs(
                'public/imagem',  $nome_arquivo
            );
            $update -> nome_arquivo = $nome_arquivo;
        }
        $update->horario = $request->uhorario;
        $update->usuario_id = $request->unome;
        $update->mecanico_id = $request->umecanico;
        $update->placa = $request->uplaca;
        $request->validate([
            'uhorario' => ['required'],
            'unome' => ['required'],
            'umecanico' => ['required'],
            'uplaca' => ['required', 'max:20'],
            'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
        ], [
            'uhorario.required' => 'O campo horario precisa ter um valor',
            'unome.required' => 'O campo nome precisa ter um valor',
            'uplaca.required' => 'O campo placa precisa ter um valor',
            'uplaca.max' => 'O maximo de caracteres é 20',
            'umecanico.required' => 'O campo tipo precisa ter um valor',
        ]);
        $updated = $update->save();

        if ($updated) {
            return redirect('Ver_serviço')->with('message', "Dados Atualizados com sucesso");
        }
    }
    public function remove(Request $c)
    {
        $delete_id = $c->id;
        $delete_data = App\Models\Serviço::find($delete_id);
        if(Storage::exists("public/imagem/".$delete_data->nome_arquivo)){
            Storage::delete("public/imagem/".$delete_data->nome_arquivo);
        }
        $deleted = $delete_data->delete();

        if ($deleted) {
            return redirect('/Ver_serviço')->with('message', 'Dados Deletados com sucesso');
        }
    }
    public function search(Request $c)
    {
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else
        if ($c->tipo == "nome") {
            $objResult = Serviço::whereHas('loginserviço', function (Builder $query) use (&$c) {
                $query->where('name', 'like', "%" . $c->valor . "%");
            })->paginate(10);
        } else if ($c->tipo == "mecanico") {
            $objResult = Serviço::whereHas('mecanicoserviço', function (Builder $query) use (&$c) {
                $query->where('nome', 'like', "%" . $c->valor . "%");
            })->paginate(10);
        } else if ($c->tipo == "placa") {
            $objResult = Serviço::where('placa', 'like', "%" . $c->valor . "%")->paginate(10);
        } else if ($c->tipo == "horario") {
            $objResult = Serviço::where('horario', 'like', "%" . $c->valor . "%")->paginate(10);
        }
        $chart = new VeiculoChart();
        $capsuleserv = array('data' => $objResult, 'chartCarro'=>$chart->build() );

        return view('Ver_serviço')->with($capsuleserv);
    }
    public function pdfview(Request $c)
    {

        $arrMec = App\Models\Serviço::all();
        $string = '<h1>serviços::</h1>';

        foreach ($arrMec as $m) {
            $string = $string . "<h4>{$m->id} -{$m->loginserviço->name} - {$m->horario} - {$m->placa} - {$m->mecanicoserviço->nome} </h4>";
        }

        $pdf = PDF::loadHtml($string);
        return $pdf->download('pdfview.pdf');
    }
    public function sendEmail(Request $c){
        $fetch_dataa = [];
        $fetch_dataa['servicos'] = App\Models\Serviço::all();
       
        Mail::to('gustavo.g1@aluno.ifsc.edu.br')-> send(new sendMailServico($fetch_dataa));
        $fetch_data = App\Models\Serviço::paginate(10);
        $capsulecar = array('data' => $fetch_data);
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
        return view('Ver_serviço')->with($capsulecar)->with('success','Email enviado com sucesso');
        }
    }
}
