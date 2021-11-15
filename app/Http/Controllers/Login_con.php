<?php

namespace App\Http\Controllers;
use App\Models\Login;
use Illuminate\Http\Request;
use App;
class Login_con extends Controller
{
    public function index(){
       
          return view("create_acc");
    }
//função pra criar o perfil
    public function create(Request $r){
        
        
        $nome=$r->unome;
        $id=$r->uid;
        $email=$r->uemail;
        $r->validate([
            'unome' => 'required|max:255',
            'uemail' =>'required|max:255',
            'usenha' => 'required|max:255',
        ],[
            'unome.required'=> 'O campo marca precisa ter um valor',
            'unome.max'=>'O maximo de caracteres é 255',
            'uemail.required'=> 'O campo email precisa ter um valor',
            'uemail.max'=>'O maximo de caracteres é 255',
            'usenha.required'=> 'O campo senha precisa ter um valor',
            'usenha.max'=>'O maximo de caracteres é 255',
        ]);
        $check_email=App\models\Login::where('email',$email)->get();
        if(count($check_email)>0){
            return redirect('/create_account')->with('msg','Conta já existe');
        }elseif (App\Models\Login::where('id',$id)->exists()){
            return redirect('/create_account')->with('msg','Conta já existe');
        }else{
            
        
        $senha=$r->usenha;
        $login= new App\models\Login;
        $login->name=$r -> unome;
        $login->email=$r -> uemail;
        $login->password=$r -> usenha;
        $login ->id=$id;
        $login->save();

        $criado=$login->save();

        if($criado){
            $session=Login::where('email',$email)->where('password',$senha)->get();
            if(Login::where('email',$email)->exists()){
                if(count($session)>0){
                    $r->session()->put('user_id',$session[0]->id);
                    $r->session()->put('user_nome',$session[0]->name);
                    $username=$r->session()->get('user_nome');
    $capsule = array('username'=>$username );
    return view('/protect')->with($capsule);
                
                }
           
           
        }
    }
    }
}
//funçao de login
    public function login(){
        return  view("/login");
    }
    //função para pegar o nome do usuario e mostrar na tela home
    public function check_user(Request $r){
        $email=$r->uemail;
        $senha=$r->usenha;
        $r->validate([
            'uemail' =>'required|max:255',
            'usenha' => 'required|max:255',
        ],[
            'uemail.required'=> 'O campo email precisa ter um valor',
            'uemail.max'=>'O maximo de caracteres é 255',
            'usenha.required'=> 'O campo senha precisa ter um valor',
            'usenha.max'=>'O maximo de caracteres é 255',
        ]);

        $session=Login::where('email',$email)->where('password',$senha)->get();
        if(Login::where('email',$email)->exists()){
            if(count($session)>0){
                $r->session()->put('user_id',$session[0]->id);
                $r->session()->put('user_nome',$session[0]->name);
                return redirect('/welcome');
            
            }else{
                return redirect('/login')->with('msg','email ou senha errados');
        }
        }else{
            return redirect('/login')->with('msg','email ou senha errados');
        }
    }
    public function protect(Request $r){
if($r->session()->get('user_id')==""){
return redirect('/login');
}else{
    $username=$r->session()->get('user_nome');
    $capsule = array('username'=>$username );
    return view('/protect')->with($capsule);
}
    }
// função de logout
    public function logout(Request $r){
$r->session()->forget('user_id');
$r->session()->forget('user_nome');

return redirect('/login')
;    }
}
