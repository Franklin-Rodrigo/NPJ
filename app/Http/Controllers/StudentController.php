<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\Human;
use App\User;
use Auth;
use Illuminate\Support\Facades\Session;

use App\Services\StudentService;

class StudentController extends Controller
{
  public function __construct(StudentService $service) {
    $this->service = $service;
  }

  public function index() {
    if(Auth::user()->type == 'admin') {
      $students = Human::all()->sortBy('name');
      return view('admin.student')->with(['students'=>$students]);
    } else if(Auth::user()->type == 'student') {
      $dados = $this->service->index();
      if (!isset($dados['error'])){
        return view('student.home')->with($dados);
      } else {//se o aluno nao tiver dupla
        Auth::logout();
        Session::flash('erro', $dados['error']);
        return view('auth.message');
      }
    }
  }

  public function store(Request $request) {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $this->validate($request, [
      'name' => 'required|string|min:3',
      'email' => 'required|string|max:255|min:3'
    ]);

    if (count(User::all()->where('email', $request->email . '@aluno.fapce.edu.br')) > 0) {
      $request->session()->flash('erro', "O e-mail informado <strong>já está cadastrado</strong>.");
      return redirect()->back();
    }

    if ($this->service->studentEmailVerify($request) == 'true') {
      return $this->service->store($request);              
    } else {
      $request->session()->flash('erro', "O e-mail informado <strong>não foi encontrado</strong> na base de dados de e-mails institucionais.");
      return redirect()->back();
    }

  }


  public function update(Request $request) {
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    
    $this->validate($request, [
      'name' => 'required|string|min:3',
      'email' => 'required|string|max:255|min:3|alpha_dash',
      'password' => 'nullable|string|min:4',
    ]);

    if (count(User::all()->where('email', $request->email . '@aluno.fapce.edu.br')->where('id', '!=', $request->id)) > 0) {
      $request->session()->flash('erro', "O e-mail informado <strong>já está cadastrado</strong>.");
      return redirect()->back();
    }

    if ($this->service->studentEmailVerify($request) == 'true') {              
      $human = Human::find($request['id']);
      $user = User::find($human->user->id);
      return $this->service->update($human, $user, $request);
    } else {
      $request->session()->flash('erro', "O e-mail informado <strong>não foi encontrado</strong> na base de dados de e-mails institucionais.");
      return redirect()->back();
    }
  }

  public function destroy(Request $request) {  
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $student = Human::find($request['id']);
       
    return $this->service->destroy($request, $student);
  }

  public function desactivate(Request $request) {  
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }

    $student = Human::find($request['id']);
       
    return $this->service->desactivate($request, $student);
  }

  public function activate(Request $request) {  
    if(Auth::user()->type != 'admin'){
      return redirect()->back();
    }
    
    $student = Human::find($request['id']);
       
    return $this->service->activate($request, $student);
  }

  public function preferences() {
      $user = User::find(Auth::user()->id);
      $human = Human::where('user_id', $user->id)->first();
      return view('student.preferences')->with(['user' => $user, 'human' => $human]);
  }

  public function preferencesEditar(Request $request) {
    $this->validate($request, [
      'name' => 'required|string|min:3',
      'password' => 'confirmed|nullable|string|min:4',
    ]);

    $user = User::find($request['idUser']);
    $human = Human::find($request['idHuman']);

    return $this->service->editar($human, $user, $request);
  }
}
