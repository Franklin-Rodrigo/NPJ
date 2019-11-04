@extends('layouts.student')
@section('component')
<div class="container-fluid">
  <div class="row justify-content-center mt-3">
    <div class="text-center">
      <h1 class="h1 h1-responsive text-center">Status das Petições</h1>
    </div>
  </div>

  <div class="row justify-content-center mt-3">

    <div class="col-lg-4 col-md-4 col-12 mb-3">
      @cardhome(['items' => ['title' => 'ALUNO', 'icon' => 'fa-user', 'color' => 'primary']])
      {{$petitions->where('student_ok','=','false')->count()}}
      @endcardhome
    </div>

    <div class="col-lg-4 col-md-4 col-12 mb-3">
      @cardhome(['items' => ['title' => 'PROFESSOR', 'icon' => 'fa-user-graduate', 'color' => 'primary']])
      {{$petitions->where('student_ok','true')->where('teacher_ok','')->where('defender_ok','')->count()}}
      @endcardhome
    </div>

    <div class="col-lg-4 col-md-4 col-12">
      @cardhome(['items' => ['title' => 'DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'primary']])
      {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','')->count()}}
      @endcardhome
    </div>
  </div>

  <div class="row justify-content-center mt-3">

    <div class="col-lg-4 col-md-4 col-12 mb-3">
      @cardhome(['items' => ['title' => 'RECUSADAS - PROFESSOR', 'icon' => 'fa-user-graduate', 'color' => 'danger']])
      {{$petitions->where('student_ok','false')->where('teacher_ok','false')->count()}}
      @endcardhome
    </div>

    <div class="col-lg-4 col-md-4 col-12 mb-3">
      @cardhome(['items' => ['title' => 'RECUSADAS - DEFENSOR', 'icon' => 'fa-user-tie', 'color' => 'danger']])
      {{$petitions->where('defender_ok','=','false')->count()}}
      @endcardhome
    </div>

    <div class="col-lg-4 col-md-4 col-12 mb-3">
      @cardhome(['items' => ['title' => 'FINALIZADAS', 'icon' => 'fa-check', 'color' => 'success']])
      {{$petitions->where('student_ok','true')->where('teacher_ok','true')->where('defender_ok','true')->count()}}
      @endcardhome
    </div>

  </div>

</div>
@endsection