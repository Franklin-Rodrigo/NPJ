@extends('layouts.admin')
@section('component')
<div style="width:100%">
  <div class="row">
    <div class="col-md-6">
      <div class="input-group" style="width:50%;">
        <div class="input-group-prepend">
          <a class="btn btn-outline-secondary" style="pointer-events: none;cursor: default;text-decoration: none;color: black;"><i class="fa fa-filter fa-1x"></i></a>
        </div>
        <select class="custom-select" id="valueHome" style="cursor:pointer" onchange="verifica(this.value)">
          <option value="1" selected><p>ESTÁGIOS DAS PETIÇÕES</p></option>
          <option value="2"><p>RANKING DE DUPLAS</p></option>
          <option value="3"><p>RANKING DE GRUPOS</p></option>
        </select>
      </div>
    </div>
  </div>
  <div id="option1" style="display:block">    
      <div class="text-center">
        <h1 class="text-center">PETIÇÕES</h1>
      </div>    
    <br><br>    
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6">
        <div class="card bg-info text-white">
          <div class="card-body bg-primary">
            <div class="row">
              <div class="col-md-6">
                <i class="fas fa-user fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>ALUNO</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','=','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card bg-success text-white">
          <div class="card-body bg-primary">
            <div class="row">
              <div class="col-md-6">
                <i class="fas fa-user-graduate fa-5x" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>PROFESSOR</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','')->where('defender_ok','')->count()}}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="card bg-info text-white">
            <div class="card-body bg-primary">
              <div class="row">
                <div class="col-md-6">
                  <i class="fas fa-user-tie fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
                </div>
                <div class="col-md-6">
                  <h6>DEFENSOR</h6>
                  <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','')->count()}}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
      <div class="col-lg-4 col-md-6">
        <div class="card bg-success text-white">
          <div class="card-body bg-warning">
            <div class="row">
              <div class="col-md-6">
                <i class="fa fa-th fa-5x" aria-hidden="true" style="margin-top:10px;"></i>
              </div>
              <div class="col-md-6">
                <h6>PROFESSOR-RECUSADAS</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','false')->where('teacher_ok','false')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-header bg-danger text-white">
            RECUSADAS
            <span class="float-right">{{$petitions->where('defender_ok','=','false')->count()}}</span>
          </div>
          <div class="card-body text-center">
            <span class="fa-stack fa-2x">
                <i class="fas fa-file fa-stack-2x text-danger"></i>
                <i class="fas fa-times fa-stack-1x mt-1 text-white"></i>
              </span>              
          </div>
          <div class="card-footer bg-danger">
            <a href="" class="text-white">
              Detalhes
              <span class="fas fa-arrow-right mr-1"></span>
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="card bg-success text-white">
          <div class="card-body bg-success">
            <div class="row">
              <div class="col-md-6">
              <span class="fa-stack fa-3x">
                <i class="fas fa-file fa-stack-2x"></i>
                <i class="fas fa-check fa-stack-1x mt-1 text-success"></i>
              </span>
              </div>
              <div class="col-md-6">
                <h6>FINALIZADAS</h6>
                <h1 class="display-4">{{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->count()}}</h1>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <div id="option2" style="display:none;width:100%"><!--ranking de Duplas-->
    <ul class="nav nav-primary">
      <li class="nav-item">
        <h1 class="text-center" style="font-family:arial;font-weight:800;padding-left:40%">RANKING DE DUPLAS</h1>
      </li>
    </ul>
    <br><br>
    <table class="table table-condensed table-striped table-bordered">
      <thead class="table">
        <tr>
          <th style="font-size:18pt;width:20%" class="text-center">COLOCAÇÃO</th>
          <th style="font-size:18pt" class="text-center">ALUNO1</th>
          <th style="font-size:18pt" class="text-center">ALUNO2</th>
          <th style="font-size:18pt" class="text-center">N° DE PETIÇÕES</th>
          <th style="font-size:18pt" class="text-center">GRUPO</th>
        </tr>
      </thead>
      <tbody>
        <br>
        @forelse($doubleStudents as $doubleStudent)
            <tr>
              <td class="text-center">{{$count++}}</td>
              <td class="text-center">{{$humans->where('id',$doubleStudent->student_id)->first()->name}}</td>
              <td class="text-center">{{$humans->where('id',$doubleStudent->student2_id)->first()->name}}</td>
              <td class="text-center">{{$doubleStudent->qtdPetitions}}</td>
              <td class="text-center">{{$groups->where('id',$doubleStudent->group_id)->first()->name}}</td>
            </tr>
        @empty
            <td>Não há duplas cadastradas</td>
        @endforelse
      </tbody>
    </table>
  </div>

  <div id="option3" style="display:none;margin-left:2%"><!--ranking de GRUPOS-->
    <ul class="nav nav-primary">
      <li class="nav-item">
        <h1 class="text-center" style="font-family:arial;font-weight:800;padding-left:40%">RANKING DE GRUPOS</h1>
      </li>
    </ul>
    <br><br>
    <table class="table table-condensed table-striped table-bordered">
      <thead class="table">
        <tr>
          <th style="font-size:18pt;width:20%" class="text-center">COLOCAÇÃO</th>
          <th style="font-size:18pt" class="text-center">GRUPO</th>
          <th style="font-size:18pt" class="text-center">N° DE PETIÇÕES</th>
        </tr>
      </thead>
      <tbody>
        <br>
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
@endsection
