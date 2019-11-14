<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Services\PetitionService;
use App\Entities\Petition;

class RecordController extends Controller {

    public function __construct(PetitionService $service) {
        $this->service = $service;
    }

    public function index() {
        if(Auth::user()->type!='admin'){
            return redirect()->back();
        }

        $users = User::with(['human' ,'records'])->where('type', 'student')->get();

        return view('admin.record')->with(['users' => $users]);
    }

    public function show($id) {
        $user = User::with(['human' ,'records'])->where('id', $id)->get()->first();
        
        return view('admin.record_show')->with(['user' => $user]);
    }

    public function petition($user_id, $petition_id) {
        $user = User::with('human')->where('id', $user_id)->get()->first();
        $petition = Petition::find($petition_id);
        $dados = $this->service->show($petition);
        $dados['user'] = $user;
        
        return view('admin.petitionShow')->with($dados);
    }
}
