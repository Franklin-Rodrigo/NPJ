<?php

namespace App\Services;

use App\Entities\Human;
use App\User;
use Illuminate\Http\Request;
use Validator;

class DefenderService {

    public function index() {

    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request) {
        $user = User::create([
            'type' => 'defender',
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

        $request->session()->flash('status', 'Defensor cadastrado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function update(Human $human, User $user, Request $request)
    {
        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        $user->email = $request['email'];

        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        $human->save();
        $request->session()->flash('status', 'Defensor editado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function destroy(Request $request, Human $defender, User $defender_user)
    {
        if ($defender != null) {
            if ($defender->status == "active" && $defender_user->type == "defender") {
                $defender->status = "inactive";
                $defender->save();
                $request->session()->flash('status', 'Defensor excluído com sucesso!');
            }
        }
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function desactivate(Request $request, Human $defender, User $defender_user) {
        if ($defender != null) {
            if ($defender->status == "active" && $defender_user->type == "defender") {
                $defender->status = "inactive";
                $defender->save();
                $request->session()->flash('status', 'Defensor desativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, defensor não encontrado!');
            return redirect()->back();
        }
    }
//--------------------------------------------------------------------------------------------------
    public function activate(Request $request, Human $defender, User $defender_user) {
        if ($defender != null) {
            if ($defender->status == "inactive" && $defender_user->type == "defender") {
                $defender->status = "active";
                $defender->save();
                $request->session()->flash('status', 'Defensor ativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, defensor não encontrado!');
            return redirect()->back();
        }
    }
}
