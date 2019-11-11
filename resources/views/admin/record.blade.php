@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>
            Historico de Alunos
          </h4>
        </div>
        <div class="card-body">
          <div>
            <div>
              <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="m-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                @if(Session::has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ Session::get('status') }}
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
                  <table class="table table-striped">
                    <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Gênero</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                        @foreach($records as $record)
                            <tr class="object align-middle" name="{{$record->human->name}}">
                                <td class="text-center align-middle">
                                    @if ($record->human->status == 'active')
                                    <button type="button" class="btn btn-success" role="button"  title="Aluno em atividade">
                                    <i class="fas fa-toggle-on"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-danger" role="button"  title="Aluno desativado">
                                    <i class="fas fa-toggle-off"></i>
                                    </button> 
                                @endif
                                </td>
                                <td class="text-center align-middle">{{$record->human->name}}</td>
                                <td class="text-center align-middle">{{$record->email}}</td>
                                <td class="text-center align-middle">{{$record->human->gender}}</td>
                                @if($record->human->phone == ' ')
                                <td class="text-center align-middle">{{$record->human->phone}}</td>
                                @else
                                <td class="text-center align-middle">Telefone não cadastrado</td>
                                @endif
                                <td class="text-center align-middle">
                                    <button type="button" class="btn btn-success" role="button" onClick="location.href='Aluno/History/{{$record->->id}}" title="Ver Historico do Aluno">
                                        <i class="fas fa-eye"></i> Historico
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>


</div>
@endsection