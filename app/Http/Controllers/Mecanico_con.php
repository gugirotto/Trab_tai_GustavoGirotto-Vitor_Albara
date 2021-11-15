<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mecanico;
use App;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Login;
use App\Models\Serviço;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendMailMec;

use App\Charts\VeiculoChart;

class Mecanico_con extends Controller
{
    public function index(Request $c)
    {
        if ($c->session()->get('user_id') == "") {
            return redirect('/login');
        } else {
            return view("Create_mecanico");
        }
    }

    public function create(Request $c)
    {
        $mecanico = new App\Models\Mecanico;
        $cpf = $c->ucpf;
        $id = $c->uvid;
        $nome = $c->unome;
        $c->validate([
            'unome' => ['required', 'max:80'],
            'ucpf' => ['required', 'max:20'],
            'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
        ], [
            'unome.required' => 'O campo nome precisa ter um valor',
            'unome.max' => 'O maximo de caracteres é 80',
            'ucpf.required' => 'O campo cpf precisa ter um valor',
            'ucpf.max' => 'O maximo de caracteres é 20',
        ]);
        if (App\Models\mecanico::where('id', $id)->exists()) {
            return redirect('/create_mecanico')->with('msg', 'Mecanico já cadastrado');
        } elseif (App\Models\Mecanico::where('cpf', $cpf)->exists()) {
            return redirect('/create_mecanico')->with('msg', 'Mecanico já cadastrado');
        } else {
            $image = $c->file("nome_arquivo");
            
            if($image){

            
            $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
            $c->nome_arquivo->storeAs(
                'public/imagem',  $nome_arquivo
            );
            $mecanico -> nome_arquivo = $nome_arquivo;
        }
            $mecanico->cpf = $cpf;
            $mecanico->nome = $nome;
            $mecanico->id = $id;


            $criado = $mecanico->save();
            $username = $c->session()->get('user_nome');
            $capsule = array('username' => $username);
            if ($criado) {
                $fetch_data = App\Models\Mecanico::paginate(10);;
                $capsulemec = array('data' => $fetch_data);
                return redirect('Ver_mecanico')->with($capsulemec, $capsule,'success', 'criado com sucesso');
            }
        }
    }
    public function Fetch(Request $c)
    {
        $fetch_data = App\Models\Mecanico::paginate(10);
        // mostra os usuarios que se relaciona no servico
        //$servico=Mecanico::find(1)->many()->orderby('placa')->get();
        //\dd($servico);
       // $servico=Serviço::find(1);
        
        //foreach($servico->usuario as $item){
        // \dd($item);
        $chart = new VeiculoChart();
        $capsulemec = array('data' => $fetch_data,'chartCarro'=>$chart->build());
        if ($c->session()->get('user_id') == "") {
            return redirect('/login');
        } else {
            return view('Ver_mecanico')->with($capsulemec);
        }
    }
    public function Edit($id, Request $c)
    {
        $mecanico = Mecanico::findOrFail($id);
        if ($c->session()->get('user_id') == "") {
            return redirect('/login');
        } else {
            return view('edit_mec')->with(['mecanico' => $mecanico]);
        }
    }
    public function update(Request $c)
    {
        $updatemec_id = $c->uvid;
        $cpf = $c->ucpf;
        $nome = $c->unome;
        $c->validate([
            'unome' => ['required', 'max:80'],
            'ucpf' => ['required', 'max:20'],
            'nome_arquivo' => 'image|mimes:jpg, jpeg,png|max:2048'
        ], [
            'unome.required' => 'O campo nome precisa ter um valor',
            'unome.max' => 'O maximo de caracteres é 80',
            'ucpf.required' => 'O campo cpf precisa ter um valor',
            'ucpf.max' => 'O maximo de caracteres é 20',
        ]);


        $update = App\Models\Mecanico::find($updatemec_id);
        $image = $c->file("nome_arquivo");
            
            if($image){

            
            $nome_arquivo = date("YmdHis").".". $image ->getClientOriginalExtension();
            $c->nome_arquivo->storeAs(
                'public/imagem',  $nome_arquivo
            );
            $update -> nome_arquivo = $nome_arquivo;
        }
        $update->cpf = $cpf;
        $update->nome = $nome;
        $updated = $update->save();

        if ($updated) {
            return redirect('Ver_mecanico')->with('success', "Dados Atualizados com sucesso");
        }
    }
    public function remove(Request $c)
    {
        $delete_id = $c->id;
        $deleta_imagem = $c->nome_arquivo;
        $delete_data = App\Models\Mecanico::find($delete_id);
        if(Storage::exists("public/imagem/".$delete_data->nome_arquivo)){
            Storage::delete("public/imagem/".$delete_data->nome_arquivo);
        }
        $deleted = $delete_data->delete();

        if ($deleted) {
            return redirect('/Ver_mecanico')->with('success', 'Dados Deletados com sucesso');
        }
    }
    public function search(Request $c)

    {
        $objResult = App\Models\Mecanico::where($c->tipo, 'like', "%" . $c->valor . "%")->paginate(10);
        $chart = new VeiculoChart();
        $capsulemec = array('data' => $objResult,'chartCarro'=>$chart->build());
        if ($c->session()->get('user_id') == "") {
            return redirect('/login');
        } else {
            return view('Ver_mecanico')->with($capsulemec);
        }
    }
    public function pdfview(Request $c)
    {

        $arrMec = App\Models\Mecanico::all();
        $string = '<h1>Mecanicos:</h1>';

        foreach ($arrMec as $m) {
            $string = $string . "<h4>{$m->id}-{$m->nome} - {$m->cpf} </h4>";
        }

        $pdf = PDF::loadHtml($string);
        return $pdf->download('pdfview.pdf');
    }
    public function sendEmail(Request $c){
        $fetch_dataa = [];
        $fetch_dataa['mecanicos'] = App\Models\Mecanico::all();
       
        Mail::to('gustavo.g1@aluno.ifsc.edu.br')-> send(new sendMailMec($fetch_dataa));
        $fetch_data = App\Models\Mecanico::paginate(10);
        $capsulecar = array('data' => $fetch_data);
        if($c->session()->get('user_id')==""){
            return redirect('/login');
            }else{
        return view('Ver_mecanico')->with($capsulecar)->with('success','Email enviado com sucesso');
        }
    }

}
