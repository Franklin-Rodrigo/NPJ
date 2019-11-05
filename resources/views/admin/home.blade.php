@extends('layouts.admin')
@section('component')
<div class="container-fluid">
  <div class="row justify-content-center mt-3 mb-3">
    <div class="col-md-9"></div>
    <div class="col-lg-3 col-md-3 col-12">
      <div class="input-group">
        <div class="input-group-prepend">
          <a class="btn btn-outline-secondary" style="pointer-events: none;cursor: default;text-decoration: none;color: black;"><i
              class="fa fa-filter fa-1x"></i></a>
        </div>
        <select class="custom-select" id="valueHome" style="cursor:pointer" onchange="verifica(this.value)">
          <option value="1" selected>
            <p>Status das petições</p>
          </option>
          <option value="2">Ranking de duplas</option>
          <option value="3">Ranking de grupos</option>
        </select>
      </div>
    </div>
  </div>
  <div id="option1" style="display:block">
    <div class="text-center">
      <h1 class="h1 h1-responsive text-center">Status das Petições</h1>
    </div>
    <br>

    <div class="row justify-content-center">

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'ALUNO', 'icon' => 'fa-user', 'color' => 'primary']])
        {{$petitions->where('student_ok','=','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'PROFESSOR', 'icon' => 'fa-user-graduate', 'color' => 'primary']])
        {{$petitions->where('student_ok','true')->where('teacher_ok','')->where('defender_ok','')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12">
        @cardhome(['items' => ['title' => 'SURPEVISOR', 'icon' => 'fa-user-edit', 'color' => 'primary']])
        {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('supervisor_ok','')->where('defender_ok','')->count()}}
        @endcardhome
      </div>
      <div class="col-lg-3 col-md-3 col-12">
        @cardhome(['items' => ['title' => 'DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'primary']])
        {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('supervisor_ok','true')->where('defender_ok','')->count()}}
        @endcardhome
      </div>
    </div>


    <div class="row justify-content-center mt-3">

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS - PROFESSOR', 'icon' => 'fa-user-graduate', 'color' => 'danger']])
        {{$petitions->where('student_ok','false')->where('teacher_ok','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS-SURPEVISOR', 'icon' => 'fa-user-edit', 'color' => 'danger']])
        {{$petitions->where('surpevisor_ok','=','false')->count()}}
        @endcardhome
      </div>
      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS - DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'danger']])
        {{$petitions->where('defender_ok','=','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'FINALIZADAS', 'icon' => 'fa-check', 'color' => 'success']])
        {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->count()}}
        @endcardhome
      </div>
    </div>

  </div>

  <div id="option2" style="display:none;width:100%">
    <!--ranking de Duplas-->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Ranking de Duplas</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Colocação</th>
                      <th class="text-center">Dupla</th>
                      <th class="text-center">N° de Petições</th>
                      <th class="text-center">Grupo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <br>
                    @forelse($doubleStudents as $doubleStudent)
                    <tr>
                      <td class="text-center">{{$count++}}</td>
                      <td class="text-center">
                        {{$humans->where('id',$doubleStudent->student_id)->first()->name}} |
                        {{$humans->where('id',$doubleStudent->student2_id)->first()->name}}
                      </td>
                      <td class="text-center">{{$doubleStudent->qtdPetitions}}</td>
                      <td class="text-center">{{$groups->where('id',$doubleStudent->group_id)->first()->name}}</td>
                    </tr>
                    @empty
                    <td>Não há duplas cadastradas</td>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <div id="option3" style="display:none;margin-left:2%">
    <!--ranking de GRUPOS-->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h4>Ranking de Duplas</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Colocação</th>
                      <th class="text-center">Grupo</th>
                      <th class="text-center">N° de Petições</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($groups as $group)
                    <tr>
                      <td class="text-center">{{$countG++}}</td>
                      <td class="text-center">{{$group->name}}</td>
                      <td class="text-center">{{$group->qtdPetitions}}</td>
                    </tr>
                    @empty
                    <td>Não há grupos cadastrados</td>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection