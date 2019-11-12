@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>
             Historico do(a) aluno(a): {{$user->human->name}}
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
                        <th class="text-center">Descrição da petição</th>
                        <th class="text-center">Nome do template</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      @foreach($user->records as $record)
                          
                          <tr class="object align-middle" name="{{$record->description}}">
                                <td class="text-center align-middle">
                                    @if ($record->defender_ok == 'true')
                                      <span class="fas fa-check-circle fa-lg text-success" title="Petição finalizada"></span>
                                    @else
                                      <span class="fas fa-times-circle fa-lg text-danger"   title="Petição não finalizada"></span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{$record->description}}</td>
                                <td class="text-center align-middle">{{$record->template->title}}</td>
                                <td class="text-center align-middle"><a class="btn btn-success" role="button" href="{{route('record.petition', $record->id)}}" title="Visualizar Petição"><i class="fa fa-eye mr-1"></i>Visualizar petição</a></td>
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