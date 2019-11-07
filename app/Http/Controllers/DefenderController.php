<?php

namespace App\Http\Controllers;

use App\Entities\Human;
use App\Entities\Petition;
use App\Services\DefenderService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class DefenderController extends Controller
{

    public function __construct(DefenderService $service) {

        $this->service = $service;

    }

    //
    public function index() {
        if (Auth::user()->type == 'admin') {
            $petitions = Petition::all()->where('visible', 'true');
            $defenders = Human::all()->sortBy('name');
            return view('admin.defender')->with(['defenders' => $defenders, 'petitions' => $petitions]);
        } else if (Auth::user()->type == 'defender') {
            $defenders = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active');
            $defender = $defenders->first();
            if ($defender == null) {
                return redirect('Sair');
            }
            $petitions = Petition::all();
            $user = Auth::user();

            return view('defender.home')->with(['defender' => $defender, 'petitions' => $petitions, 'user' => $user]);
        } else {
            return redirect()->back();
        }

    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return $this->service->store($request);
    }
//--------------------------------------------------------------------------------------------------
    public function update(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $this->validate($request, [
            'name' => 'required|string|min:3',
            'email' => 'required|string|email|max:255|unique:users,email,'.$request['id'],
            'password' => 'nullable|string|min:6',
        ]);

        $human = Human::find($request['id']);
        $user = User::find($human->user_id);

        return $this->service->update($human, $user, $request);
    }
//--------------------------------------------------------------------------------------------------
    public function destroy(Request $request) { //
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $defender = Human::find($request['id']);
        $defender_user = User::find($defender->user_id);

   return $this->service->destroy($request,$defender, $defender_user);
  }
//--------------------------------------------------------------------------------------------------
public function desactivate(Request $request) {
    if (Auth::user()->type != 'admin') {
        return redirect()->back();
    }

    $defender = Human::find($request['id']);
    $defender_user = User::find($defender->user_id);

    return $this->service->desactivate($request, $defender, $defender_user);
}
//--------------------------------------------------------------------------------------------------
public function activate(Request $request) {
    if (Auth::user()->type != 'admin') {
        return redirect()->back();
    }

    $defender = Human::find($request['id']);
    $defender_user = User::find($defender->user_id);

    return $this->service->activate($request, $defender, $defender_user);
}
//--------------------------------------------------------------------------------------------------
public function preferences() {
      $user = User::find(Auth::user()->id);
      $human = Human::where('user_id', $user->id)->first();
      return view('defender.preferences')->with(['user' => $user, 'human' => $human]);
  }
//--------------------------------------------------------------------------------------------------
  public function preferencesEditar(Request $request) {
    $user = User::find($request['idUser']);
    $human = Human::find($request['idHuman']);

    return $this->service->editar($human, $user, $request);
  }
}
