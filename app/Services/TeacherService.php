<?php

namespace App\Services;

use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\User;
use Auth;
use Illuminate\Http\Request;

class TeacherService
{

    public function index() {
        $teacher = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();

        $group = Group::all()->where('status', '=', 'active')->where('teacher_id', '=', $teacher->id)->first();

        if ($group == null) {
            return redirect('Sair');
        }

        $doubleStudents = DoubleStudent::all()->where('status', '=', 'active')->where('group_id', $group->id)->sortByDesc('qtdPetitions');

        $petitions = Petition::all()->where('group_id', $group->id);

        $humans = Human::all()->where('status', '=', 'active');
        $user = Auth::user();
        $count = 1;

        return ['teacher' => $teacher, 'group' => $group, 'doubleStudents' => $doubleStudents, 'petitions' => $petitions, 'humans' => $humans, 'user' => $user, 'count' => $count];
    }

    public function store(Request $request) {
        //cria uma senha aleatória com dígitos do email do aluno, concatenado a dia, mês e ano
        $password = $request->email[random_int(0, strlen($request->email))] . $request->email[random_int(0, strlen($request->email))] . $request->email[random_int(0, strlen($request->email))] . date('d') . date('m') . date('y');

        $user = User::create([
            'type' => 'teacher',
            'email' => $request->email,
            'password' => bcrypt($password),
        ]);

        $human = Human::create([
            'status' => 'active',
            'name' => $request->name,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'user_id' => $user->id,
            'groupT' => 'NAO',
        ]);

        
        // Cadastrar Grupo automaticamente -------------------------            
        $periodo = date('Y') . '.' . ((date('n') > 6) ? 2 : 1); //Cadastra o grupo [período] - [professor]
        
        Group::create([
            'name' => $periodo . ' - ' . $human->name,
            'teacher_id' => $human->id,
            'qtdPetitions' => 0,
        ]);
            
        $human->groupT = 'SIM';
        $human->save();
        
        $request->session()->flash('status', "Professor cadastrado com a senha: $password <br> A senha poderá ser editada após o login, em 'Preferências'. <br>
        Um grupo, referênte ao período e o professor, também foi criado!");
        return redirect()->back();
    }

    public function editar(Human $human, User $user, Request $request) {

        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        
        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }

        $user->save();
        $human->save();
        $request->session()->flash('status', 'Dados atualizados com sucesso!');
        return redirect()->back();
    }

    public function destroy(Request $request, Human $teacher) {
        if($teacher != null && $teacher->status == 'active'){
            $groups = Group::all();
            foreach ($groups as $group) {
                if ($group->teacher_id == $teacher->id) {
                    if ($group != null && $group->status == 'active') { //se o professor participar de algum grupo e se esse for active
                        $group->status = 'inactive';
                        $group->save();

                        $doubleStudents = DoubleStudent::all(); //todas as duplas
                        //dd($doubleStudents);
                        if ($doubleStudents != null) {
                            foreach ($doubleStudents as $doubleStudent) {
                                if ($doubleStudent->group_id == $group->id) { //se o grupo da dupla iterada for o grupo a qual o professor pertence
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
                        }
                    }
                }
            }
            $teacher->status = 'inactive';

            $teacher->save();
            $request->session()->flash('status', 'Professor excluído com sucesso!');
            return redirect()->back();
        } else {
            $request->session()->flash('status', 'Erro, professor não encontrado!');
            return redirect()->back();
        }
    }

    public function desactivate(Request $request, Human $teacher) {
        if($teacher != null && $teacher->status == 'active'){
            $groups = Group::all();
            foreach ($groups as $group) {
                if ($group->teacher_id == $teacher->id) {
                    if ($group != null && $group->status == 'active') { //se o professor participar de algum grupo e se esse for active
                        $group->status = 'inactive';
                        $group->save();
                        $teacher->groupT = 'NAO';
                        $teacher->save();

                        $doubleStudents = DoubleStudent::all(); //todas as duplas
                        //dd($doubleStudents);
                        if ($doubleStudents != null) {
                            foreach ($doubleStudents as $doubleStudent) {
                                if ($doubleStudent->group_id == $group->id) { //se o grupo da dupla iterada for o grupo a qual o professor pertence
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
                        }
                    }
                }
            }
            $teacher->status = 'inactive';

            $teacher->save();
            $request->session()->flash('status', 'Professor desativado com sucesso!');
            return redirect()->back();
        } else {
            $request->session()->flash('status', 'Erro, professor não encontrado!');
            return redirect()->back();
        }
    }

    public function activate(Request $request, Human $teacher) {
        if ($teacher != null && $teacher->status == 'inactive'){

            $teacher->status = 'active';
            $teacher->save();
            $request->session()->flash('status', 'Professor ativado com sucesso!');
            return redirect()->back();
        } else {
            $request->session()->flash('status', 'Erro, professor não encontrado!');
            return redirect()->back();
        }
    }
}
