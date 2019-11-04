<?php

namespace App\Services;

use App\Entities\Human;
use App\User;
use Illuminate\Http\Request;
use Validator;

class SupervisorService
{

    public function index() {

    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request) {

        $user = User::create([
            'type' => 'supervisor',
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $human = Human::create([
            'status' => 'active',
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'user_id' => $user->id,
        ]);

        $request->session()->flash('status', 'Supervisor cadastrado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function update(Human $human, User $user, Request $request) {
        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        $user->email = $request['email'];

        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }
        
        $user->save();
        $human->save();
        $request->session()->flash('status', 'Supervisor editado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function destroy(Request $request, Human $supervisor, User $supervisor_User) {
        if ($supervisor != null) {
            if ($supervisor->status == "active" && $supervisor_User->type == "supervisor") {
                $supervisor->status = "inactive";
                $supervisor->save();
                $request->session()->flash('status', 'Supervisor excluído com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, supervisor não encontrado!');
            return redirect()->back();
        }
    }
//--------------------------------------------------------------------------------------------------
    public function desactivate(Request $request, Human $supervisor, User $supervisor_User) {
        if ($supervisor != null) {
            if ($supervisor->status == "active" && $supervisor_User->type == "supervisor") {
                $supervisor->status = "inactive";
                $supervisor->save();
                $request->session()->flash('status', 'Supervisor desativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, supervisor não encontrado!');
            return redirect()->back();
        }
    }
//--------------------------------------------------------------------------------------------------
    public function activate(Request $request, Human $supervisor, User $supervisor_User) {
        if ($supervisor != null) {
            if ($supervisor->status == "inactive" && $supervisor_User->type == "supervisor") {
                $supervisor->status = "active";
                $supervisor->save();
                $request->session()->flash('status', 'Supervisor ativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, supervisor não encontrado!');
            return redirect()->back();
        }
    }
}
