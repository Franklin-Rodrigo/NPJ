<?php

namespace App\Services;

use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use Illuminate\Http\Request;

class GroupService
{
    public function index() {

        $petitions = Petition::all();
        $humans = Human::all();
        $groups = Group::all();
        $doubleStudents = DoubleStudent::all();
        return ['petitions' => $petitions, 'humans' => $humans, 'groups' => $groups, 'doubleStudents' => $doubleStudents];
    }
//--------------------------------------------------------------------------------------------------
    public function store(Request $request) {
        $gp = Group::all()->where('name', $request['name'])->first();
        if ($gp != null) {
            $request->session()->flash('status', 'Cadastro indisponível! Já existe um grupo com esse nome.');
            return redirect()->back();
        }

        $group = Group::create([
            'name' => $request['name'],
            'teacher_id' => $request['teacher_id'],
            'qtdPetitions' => 0,
        ]);

        $teacher = Human::find($group->teacher_id);
        if ($teacher != null) {
            $teacher->groupT = 'SIM';
            $teacher->save();
            $request->session()->flash('status', 'Grupo cadastrado com sucesso!');
            return redirect()->back();
        }
        $request->session()->flash('status', 'Erro ao tentar cadastrar Grupo!');

    }
//--------------------------------------------------------------------------------------------------
    public function update(Request $request) {
        $group = Group::find($request['id']);
        if ($group->teacher_id != $request['teacher_id'] && $request['teacher_id'] != null) //se houver alteracão do professor
        {
            $teacherVelho = Human::find($group->teacher_id);
            $teacherNovo = Human::find($request['teacher_id']);
            dd($request['teacher_id']);
            $teacherVelho->groupT = 'NAO';
            $teacherVelho->save();
            $teacherNovo->groupT = 'SIM';
            $teacherNovo->save();
            $group->teacher_id = $request['teacher_id'];
        }
        if ($group->name != $request['name']) { //se houver alteração no nome do grupo
            if ($request['name'] != null) {
                $group->name = $request['name'];
            } else {
                $request->session()->flash('status', 'Falha ao tentar editar grupo! O nome do grupo não pode ser nulo');
                return redirect()->back();
            }
        }
        $group->save();
        $request->session()->flash('status', 'Grupo editado com sucesso!');
        return redirect()->back();
    }
//--------------------------------------------------------------------------------------------------
    public function destroy(Request $request) {

        $group = Group::find($request['id']);
        //dd($group);

        if ($group != null && $group->status == 'active') { //se o professor participar de algum grupo e se esse for active
            $group->status = 'inactive';
            $teacher = Human::find($group->teacher_id); //pega o professor do grupo
            $teacher->groupT = 'NAO'; //o professor fica sem grupo
            $teacher->save();
            $group->save();

            $doubleStudents = DoubleStudent::all()->where('status', 'active'); //todas as duplas
            foreach ($doubleStudents as $doubleStudent) { ///
                if ($doubleStudent->group_id == $group->id) { //se o grupo da dupla iterada for o grupo
                    $doubleStudent->status = 'inactive';
                    $student1 = Human::find($doubleStudent->student_id);
                    $student1->doubleS = 'NAO';
                    $student1->save();
                    $student2 = Human::find($doubleStudent->student2_id);
                    $student2->doubleS = 'NAO';
                    $student2->save();
                    $doubleStudent->save();
                }
            }
            $request->session()->flash('status', 'Grupo excluído com sucesso!');
            return redirect()->back();
        }

        if ($group != null) {
            $group->status = 'inactive';
            $teacher = Human::find($group->teacher_id);
            $teacher->groupT = 'NAO';
            $teacher->save();
            $group->save();
            $request->session()->flash('status', 'Grupo excluido com sucesso!');
            return redirect()->back();
        }
        $request->session()->flash('status', 'Erro ao tentar excluir Grupo!');
    }
//--------------------------------------------------------------------------------------------------
    public function desactivate(Request $request) {

        $group = Group::find($request['id']);
        //dd($group);

        if ($group != null && $group->status == 'active') { //se o professor participar de algum grupo e se esse for active
            $group->status = 'inactive';
            $teacher = Human::find($group->teacher_id); //pega o professor do grupo
            $teacher->groupT = 'NAO'; //o professor fica sem grupo
            $teacher->save();
            $group->save();

            $doubleStudents = DoubleStudent::all()->where('status', 'active'); //todas as duplas
            foreach ($doubleStudents as $doubleStudent) { ///
                if ($doubleStudent->group_id == $group->id) { //se o grupo da dupla iterada for o grupo
                    $doubleStudent->status = 'inactive';
                    $student1 = Human::find($doubleStudent->student_id);
                    $student1->doubleS = 'NAO';
                    $student1->save();
                    $student2 = Human::find($doubleStudent->student2_id);
                    $student2->doubleS = 'NAO';
                    $student2->save();
                    $doubleStudent->save();
                }
            }
            $request->session()->flash('status', 'Grupo desativado com sucesso!');
            return redirect()->back();
        }

        $request->session()->flash('status', 'Erro ao tentar desativar Grupo!');
    }
//--------------------------------------------------------------------------------------------------
    public function activate(Request $request) {

        $group = Group::find($request['id']);
        //dd($group);

        if ($group != null && $group->status == 'inactive') { //se o professor participar de algum grupo e se esse for inactive
            $doubleStudents = DoubleStudent::all()->where('group_id', $group->id); //todas as duplas
            $teacher = Human::find($group->teacher_id);//Verifica se há algum outro grupo ativo sob responsabilidade do mesmo professor.
            if (count($doubleStudents) > 0) {
                $request->session()->flash('status', 'Este grupo não pode ser reativado, visto que já possuiu duplas vinculadas a ele!');
                return redirect()->back();
            } else if ($teacher->groupT == 'SIM') {
                $request->session()->flash('status', 'Este grupo não pode ser reativado, visto que possui outro grupo ativo sob responsabilidade do mesmo professor!');
                return redirect()->back();
            }
            
            $group->status = 'active';
            $teacher = Human::find($group->teacher_id); //pega o professor do grupo
            $teacher->groupT = 'SIM'; //o professor fica sem grupo
            $teacher->save();
            $group->save();
            
            $request->session()->flash('status', 'Grupo ativado com sucesso!');
            return redirect()->back();
        }
        
        $request->session()->flash('status', 'Erro, grupo não encontrado!');
    }
//--------------------------------------------------------------------------------------------------
}
