@extends('layouts.defender')
@section('component')
<div class="container-fluid">
  <div class="row justify-content-center mt-3">
    <div class="text-center">
      <h1 class="h1 h1-responsive text-center">Status das petições</h1>
    </div>
  </div>

    <div class="row justify-content-center mt-3">
      
      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'ALUNO', 'icon' => 'fa-user', 'color' => 'primary']])
          {{$petitions->where('defender_id',$defender->id)->where('student_ok','!=','true')->count()}}
        @endcardhome
      </div>
      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'PROFESSOR', 'icon' => 'fa-user', 'color' => 'primary']])
          {{$petitions->where('defender_id',$defender->id)->where('student_ok','true')->where('professor_ok','!=','true')->where('supervisor_ok','=','')->where('defender_id','=','')->count()}}
        @endcardhome
      </div>
      
      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'SUPERVISOR', 'icon' => 'fa-user-tie', 'color' => 'primary']])  
          {{$petitions->where('defender_id',$defender->id)->where('supervisor_ok','!=','true')->where('teacher_ok','true')->where('student_ok','true')->count()}}
        @endcardhome
      </div>
      
      <div class="col-lg-3 col-md-3 col-12">
        @cardhome(['items' => ['title' => 'DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'primary']])  
          {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('supervisor_ok','true')->where('defender_id','=','')->count()}}
        @endcardhome
      </div>
    </div>

    <div class="row justify-content-center mt-3">
    
    <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS - PROFESSOR', 'icon' => 'fa-user-graduate', 'color' => 'danger']])
        {{$petitions->where('teacher_ok','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS-SUPERVISOR', 'icon' => 'fa-user-edit', 'color' => 'danger']])
        {{$petitions->where('supervisor_ok','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'RECUSADAS - DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'danger']])
        {{$petitions->where('defender_ok','false')->count()}}
        @endcardhome
      </div>

      <div class="col-lg-3 col-md-3 col-12 mb-3">
        @cardhome(['items' => ['title' => 'FINALIZADAS', 'icon' => 'fa-check', 'color' => 'success']])
        {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('supervisor_ok','true')->where('defender_ok','true')->count()}}
        @endcardhome
      </div>
    
    </div>
  </div>

@endsection