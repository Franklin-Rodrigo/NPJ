@extends('layouts.supervisor')
@section('subtitle', 'Petições')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
            <h4>
              Avaliar petições
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
                  <table class="table table-striped ">
                    <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Versão</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($petitions as $petition)
                        @if($petition->student_ok != null)
                          <tr class="object align-middle" name="{{$petition->description}}">
                            <td class="text-center align-middle">
                              {{$petition->version}}.0
                            </td>
                            <td class="text-center align-middle">
                                @if($petition->defender_ok == 'true')
                                  Finalizada
                                @elseif($petition->student_ok == null)
                                  Rascunho
                                @elseif($petition->teacher_ok == 'false' && $petition->student_ok == 'false')
                                  Petição recusada - Professor
                                @elseif($petition->student_ok == 'true' && $petition->teacher_ok != 'true')
                                  Avaliação pendente - Professor
                                @elseif($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok != 'true')
                                  Avaliação pendente - Supervisor
                                @elseif($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok == 'true')
                                  Avaliação pendente - Defensor
                                @endif
                            </td>
                            <td class="text-center align-middle">
                              {{$petition->description}}
                            </td>
                            <td class="text-center align-middle">
                              @if($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok != 'true')
                                <button type="button" class="btn btn-primary" role="button" onClick="location.href='Peticao/Avaliar/{{$petition->id}}'" title="Avaliar petição">
                                  <i class="fas fa-gavel"></i> Avaliar
                                </button>
                                <button type="button" class="btn btn-warning" role="button" onClick="location.href='Peticao/Edit/{{$petition->id}}'" title="Editar petição">
                                  <i class="fa fa-edit"></i> Editar
                                </button>
                              @else
                                <button type="button" class="btn btn-success" role="button" onClick="location.href='Peticao/Show/{{$petition->id}}'" title="Visualizar petição">
                                  <i class="fas fa-eye"></i> Visualizar
                                </button>
                              @endif
                            </td>
                          </tr>
                        @endif
                        @empty
                        <tr>
                          <td class="text-center" colspan="3">Nenhuma petição a ser avaliada!</td>
                        </tr>
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
