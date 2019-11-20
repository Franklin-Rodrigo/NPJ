@extends('layouts.defender')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
          <h4>Gerenciar petições
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
                  <input type="search" name="" class="form-control" value="" placeholder="Buscar pela descrição..." onkeyup="filtroDeBusca(this.value)">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">Status</th>
                    <th class="text-center">Descrição</th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($petitions as $petition)
                    @if($petition->defender_id == $defender->id || ($petition->student_ok == 'true' &&
                      $petition->teacher_ok == 'true' && $petition->defender_ok == '' && $petition->defender_id == ''))
                      <tr class="object" name="{{$petition->description}}">
                        <td class="text-center align-middle">
                          @if($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok == 'true' && $petition->defender_ok != 'true')
                            Avaliação Pendente
                          @elseif($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok == 'false')
                            Recusada - Aguardando correção do supervisor
                          @elseif($petition->student_ok == 'true' && $petition->teacher_ok == 'false' && $petition->supervisor_ok == 'false')
                            Recusada - Aguardando correção do professor
                          @elseif($petition->student_ok == 'false' && $petition->teacher_ok == 'false' && $petition->supervisor_ok == 'false')
                            Recusada - Aguardando correção do aluno
                          @elseif($petition->defender_ok == 'true' && $petition->defender_id == $defender->id )
                            Finalizada
                          @endif
                        </td>
                        <td class="text-center align-middle">
                          {{$petition->description}}
                        </td>
                        <td style="font-size:18pt;width:15%" class="text-center">
                          @if($petition->defender_ok == 'true' && $petition->defender_id == $defender->id)
                            <button type="button" class="btn btn-success" role="button" onClick="location.href='Peticao/Emitir/{{$petition->id}}'"
                              title="Emitir petição">
                              <span class="fas fa-file-download"></span>
                            </button>
                          @endif
                          @if(($petition->defender_ok == 'false' && $petition->supervisor_ok == 'false') || $petition->defender_ok == null)
                            <button type="button" class="btn btn-success" role="button" onClick="location.href='Peticao/Show/{{$petition->id}}'"
                              title="Visualizar petição">
                              <i class="fas fa-eye"></i>
                            </button>
                          @endif
                          @if($petition->student_ok == 'true' && $petition->teacher_ok == 'true' && $petition->supervisor_ok == 'true' && $petition->defender_ok != 'true')
                          <button type="button" class="btn btn-primary" role="button" onClick="location.href='Peticao/Avaliar/{{$petition->id}}'"
                            title="Avaliar petição">
                            <span class="fas fa-gavel"></span>
                          </button>
                          @endif
                        </td>
                      </tr>
                    @endif
                    @empty
                    <td class="text-center">Nenhuma petição registrada!</td>
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
@stop