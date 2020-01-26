<?php

namespace App\Services;

use App\Entities\DoubleStudent;
use App\Entities\Group;
use App\Entities\Human;
use App\Entities\Petition;
use App\User;
use Auth;
use Illuminate\Http\Request;

class StudentService {

    public function index() {
        $student = Human::all()->where('user_id', '=', Auth::user()->id)->where('status', '=', 'active')->first();

        if (!$student) {
            return ['error' => 'Usuário não registrado, ou destivado.'];
        }

        $doubleStudent = DoubleStudent::all()->where('student_id', '=', $student->id)->where('status', 'active')->first();

        if ($doubleStudent == null) { // se não for o aluno 1 da dupla talvez seja o 2
            $doubleStudent = DoubleStudent::all()->where('status', '=', 'active')->where('student2_id', '=', $student->id)->first();
        }

        if ($doubleStudent != null) { // se for da dupla
            $petitions = Petition::all()->where('doubleStudent_id', '=', $doubleStudent->id);
            $group = Group::all()->where('status', '=', 'active')->where('id', '=', $doubleStudent->group_id)->first();
            $teacher = Human::all()->where('id', '=', $group->teacher_id)->where('status', '=', 'active')->first();
            $humans = Human::all()->where('status', '=', 'active');
            $user = Auth::user();

            return ['student' => $student, 'doubleStudent' => $doubleStudent, 'petitions' => $petitions, 'group' => $group, 'teacher' => $teacher, 'humans' => $humans, 'user' => $user];
        } else {
            return ['error' => 'Aluno não registrado em nenhuma dupla.'];
        }
    }

    public function studentEmailVerify(Request $request) {
        $url = "https://api-cf.fapce.edu.br/v1/user-email-edu/" . $request->email;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Basic a0d2Yyo0dUA0OEtRNjQydzpXSjQhSDhzc2czeVdHOHB0",
            "Content-Type: application/json"
        ));
    
        $res = curl_exec($curl);
        $arrayRes = json_decode($res, true);
    
        curl_close($curl);
    
        if ($arrayRes['resposta']) {
            //Email existe
            return 'true';
        } else {
            //Email não existe
            return 'false';
        }
    }
    
    public function store(Request $request) {
        //cria uma senha aleatória com dígitos do email do aluno, concatenado a dia, mês e ano
        $password = $request->email[random_int(0, (strlen($request->email) - 1))] . $request->email[random_int(0, (strlen($request->email) - 1))] . $request->email[random_int(0, (strlen($request->email) - 1))] . date('d') . date('m') . date('y');
        
        $user = User::create([
            'type' => 'student',
            'email' => $request->email . '@aluno.fapce.edu.br',
            'password' => bcrypt($password),
        ]);

        $human = Human::create([
            'status' => 'active',
            'name' => $request->name,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'doubleS' => 'NAO',
            'user_id' => $user->id, //id do human Student
        ]);
            
        $request->session()->flash('status', "Aluno cadastrado com a senha: $password <br> A senha poderá ser editada após o login, em 'Preferências'.");
        return redirect()->back();
    }

    public function editar(Human $human, User $user, Request $request) {

        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];

        if ($request['password'] != null) {
            $user->password = bcrypt($request['password']);
        }
        
        $human->save();
        $user->save();
        $request->session()->flash('status', 'Dados atualizados com sucesso!');

        return redirect()->back();

    }
        
    public function update(Human $human, User $user, Request $request) {

        $human->name = $request['name'];
        $human->gender = $request['gender'];
        $human->phone = $request['phone'];
        $user->email = $request['email'] . '@aluno.fapce.edu.br';

        !empty($request['password']) ? $user->password = bcrypt($request['password']) : null;

        $user->save();
        $human->save();
        $request->session()->flash('status', 'Aluno editado com sucesso!');
        return redirect()->back();
    }

    public function destroy(Request $request, Human $student) {
        if ($student != null) { //se estudante existir
            if ($student->status == "active" && $student->user->type == "student") { //se estudante for active e for do type student
                $doubleStudents = DoubleStudent::all()->where('status', 'active');
                if ($doubleStudents != null) { //se houver duplas
                    foreach ($doubleStudents as $doubleStudent) {
                        if ($doubleStudent->student_id == $student->id) { //se o primeiro aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = 'inactive'; //dupla torna-se inativa
                            $student2 = Human::find($doubleStudent->student2_id); //pegar estudante2
                            $student2->doubleS = 'NAO'; //O estudante2 nao esta mais em nenhuma dupla
                            $student2->save();
                            $doubleStudent->save();
                        }
                        if ($doubleStudent->student2_id == $student->id) { //se o segundo aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = "inactive"; //dupla torna-se inativa
                            $student1 = Human::find($doubleStudent->student_id); //pegar estudante1
                            $student1->doubleS = 'NAO'; //O estudante1 nao esta mais em nenhuma dupla
                            $student1->save();
                            $doubleStudent->save();
                        }
                    } //fim foreach
                }

                $student->status = "inactive";
                $student->save();
                $request->session()->flash('status', 'Aluno excluído com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, aluno não encontrado!');
            return redirect()->back();
        }
    }

    public function desactivate(Request $request, Human $student) {
        if ($student != null) { //se estudante existir
            if ($student->status == "active" && $student->user->type == "student") { //se estudante for active e for do type student
                $doubleStudents = DoubleStudent::all()->where('status', 'active');
                if ($doubleStudents != null) { //se houver duplas
                    foreach ($doubleStudents as $doubleStudent) {
                        if ($doubleStudent->student_id == $student->id) { //se o primeiro aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = 'inactive'; //dupla torna-se inativa
                            $student2 = Human::find($doubleStudent->student2_id); //pegar estudante2
                            $student2->doubleS = 'NAO'; //O estudante2 nao esta mais em nenhuma dupla
                            $student2->save();
                            $doubleStudent->save();
                        }
                        if ($doubleStudent->student2_id == $student->id) { //se o segundo aluno da dupla for o aluno da requisicao
                            $doubleStudent->status = "inactive"; //dupla torna-se inativa
                            $student1 = Human::find($doubleStudent->student_id); //pegar estudante1
                            $student1->doubleS = 'NAO'; //O estudante1 nao esta mais em nenhuma dupla
                            $student1->save();
                            $doubleStudent->save();
                        }
                    } //fim foreach
                }

                $student->status = "inactive";
                $student->save();
                $request->session()->flash('status', 'Aluno desativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, aluno não encontrado!');
            return redirect()->back();
        }
    }

    public function activate(Request $request, Human $student) {
        if ($student != null) { //se estudante existir
            if ($student->status == "inactive" && $student->user->type == "student") { //se estudante for active e for do type student

                $student->status = "active";
                $student->save();
                $request->session()->flash('status', 'Aluno ativado com sucesso!');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('status', 'Erro, aluno não encontrado!');
            return redirect()->back();
        }
    }
}
