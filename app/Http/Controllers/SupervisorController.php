<?php

namespace App\Http\Controllers;

use App\Entities\Human;
use App\Entities\Petition;
use App\Services\SupervisorService;
use App\User;
use Auth;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{

    public function __construct(SupervisorService $service) {
        $this->service = $service;
    }

    //
    public function index() {
        if (Auth::user()->type == 'admin') {
            $petitions = Petition::all()->where('visible', 'true');
            $supervisors = Human::all()->sortBy('name');
            return view('admin.supervisor')->with(['supervisors' => $supervisors, 'petitions' => $petitions]);
        } else if (Auth::user()->type == 'supervisor') {
            $supervisors = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active');
            $supervisor = $supervisors->first();
            if ($supervisor == null) {
                return redirect('Sair');
            }
            $petitions = Petition::all();
            $user = Auth::user();

            return view('supervisor.home')->with(['supervisor' => $supervisor, 'petitions' => $petitions, 'user' => $user]);
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
            // 'password' => 'required|string|min:6',
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
    public function destroy(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $supervisor = Human::find($request['id']);
        $supervisor_user = User::find($supervisor->user_id);

        return $this->service->destroy($request, $supervisor, $supervisor_user);
    }
//--------------------------------------------------------------------------------------------------
    public function desactivate(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $supervisor = Human::find($request['id']);
        $supervisor_user = User::find($supervisor->user_id);

        return $this->service->desactivate($request, $supervisor, $supervisor_user);
    }
//--------------------------------------------------------------------------------------------------
    public function activate(Request $request) {
        if (Auth::user()->type != 'admin') {
            return redirect()->back();
        }

        $supervisor = Human::find($request['id']);
        $supervisor_user = User::find($supervisor->user_id);

        return $this->service->activate($request, $supervisor, $supervisor_user);
    }
//--------------------------------------------------------------------------------------------------
  public function preferences() {
      $user = User::find(Auth::user()->id);
      $human = Human::where('user_id', $user->id)->first();
      return view('supervisor.preferences')->with(['user' => $user, 'human' => $human]);
  }
//--------------------------------------------------------------------------------------------------
  public function preferencesEditar(Request $request) {

    $this->validate($request, [
        'name' => 'required|string|min:3',
        // 'email' => 'required|string|email|max:255|unique:users,email,'.$request['idUser'],
        'password' => 'confirmed|nullable|string|min:4',
    ]);

    $user = User::find($request['idUser']);
    $human = Human::find($request['idHuman']);

    return $this->service->editar($human, $user, $request);
  }
}
