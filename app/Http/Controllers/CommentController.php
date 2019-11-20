<?php

namespace App\Http\Controllers;

use App\Entities\Petition;
use App\Services\CommentService;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {

        $petition = Petition::find($request['idPetition']);
        if (Auth::user()->type == 'teacher') {

            $this->service->professorStore($request, $petition);

            return redirect('Professor/Peticoes');

        } else if (Auth::user()->type == 'supervisor') { //Área do Defensor

            $this->service->supervisorStore($request, $petition);

            return redirect('Supervisor/Peticoes');

        } else if (Auth::user()->type == 'defender') { //Área do Defensor

            $this->service->defensorStore($request, $petition);

            return redirect('Defensor/Peticoes');

        } else {
            $request->session()->flash('status', 'Você não possui autorização de acesso!!');
            return redirect()->back();
        }
    }
}
