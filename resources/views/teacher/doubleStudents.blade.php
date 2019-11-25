@extends('layouts.teacher')
@section('subtitle', 'Duplas')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
          <h4>
            Visualizar duplas
          </h4>
        </div>
          <div class="card-body">
            <div class="col-lg-12">

              <div>
                @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Os seguinte erros foram informados:</strong>
                    <ul class="m-0">
                      @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                @if(Session::has('status'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! Session::get('status') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>                  
                @endif
                @if(Session::has('erro'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('erro') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>                  
                @endif
              </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                      <div class="input-group">
                        <input type="search" name="" class="form-control" value="" placeholder="Buscar por nome..." onkeyup="filtroDeBusca(this.value)">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fas fa-search"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                </div>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th class="text-center">Dupla</th>
                          <th class="text-center">Grupo</th>
                          <th class="text-center">N° petições</th>
                          <!--<th class="text-center">Ações</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($doubleStudents as $doubleStudent)
                            <tr class="object align-middle" name="{{$humans->find($doubleStudent->student_id)->name}}">
                              <td class="text-center align-middle">
                                {{$humans->find($doubleStudent->student_id)->name}} |
                                {{$humans->find($doubleStudent->student2_id)->name}}</td>
                              <td class="text-center align-middle">{{$doubleStudent->group->name}}</td>
                              <td class="text-center align-middle">{{$petitions->where('visible','true')->where('doubleStudent_id',$doubleStudent->id)->count()}}</td>
                            </tr>
                        @empty
                        <td class="text-center">Nenhuma dupla registrada!</td>
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

@endsection
