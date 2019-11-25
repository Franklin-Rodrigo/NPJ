@extends('layouts.admin')
@section('subtitle', 'Grupos')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>Gerenciar grupos
            <button type="button" class="btn btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalGroup" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo aluno">
              <i class="fa fa-plus mr-1"></i>
              Novo grupo
            </button>
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
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th class="text-center">Status</th>
                      <th class="text-center">Nome</th>
                      <th class="text-center">Professor</th>
                      <th class="text-center">Duplas</th>
                      <th class="text-center">Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($groups as $group)
                      <tr class="object align-middle" name="{{$group->name}}">
                        <td class="text-center align-middle">
                          @if ($group->status == 'active')
                            <button type="button" class="btn btn-success" role="button" data-toggle="modal" data-target="#desactivateModalGroup" onclick="groupStatus('{{$group->id}}','{{$group->name}}')" title="Desativar grupo">
                              <i class="fas fa-toggle-on"></i>
                            </button>
                          @else
                            <button type="button" class="btn btn-danger" role="button" data-toggle="modal" data-target="#activateModalGroup" onclick="groupStatus('{{$group->id}}','{{$group->name}}')" title="Ativar grupo">
                              <i class="fas fa-toggle-off"></i>
                            </button> 
                          @endif
                        </td>
                        <td class="text-center align-middle">{{$group->name}}</td>
                        <td class="text-center align-middle">{{$humans->find($group->teacher_id)->name}}</td>
                        <td class="text-center align-middle">{{$doubleStudents->where('group_id',$group->id)->count()}}</td>
                        <!--Pegar qtd de peticoes por dupla-->
                        <td style="font-size:10pt;width:15%" class="text-center">
                          <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#editModalGroup" onclick="editModalGroup('{{$group->id}}','{{$group->name}}','{{$group->teacher_id}}')" title="Editar Grupo">
                            <i class="fa fa-edit"></i> Editar
                          </button>
                        </td>
                      </tr>
                    @empty
                    <tr class="my-auto align-middle">
                      <td class="text-center" colspan="5">Nenhuma grupo registrado!</td>
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

  <!-- Modal -->
  <div class="modal fade" id="newModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Novo grupo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="row">            
            <div class="col-md-4">
              <small class="pull-right text-danger">*Campos obrigatórios</small>
            </div>
          </div>
          <form action="{{URL::to('Admin/Grupo/Cadastrar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="name">Nome</label>
                  <input type="text" id="name" name="name" class="form-control" maxlength="80" value="" required>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="">Professor</label>
                  <select class="form-control" name="teacher_id" required>
                    <option value="">Selecione o professor</option>
                    @foreach($humans as $human)
                      <!--Está sem validação-->
                      @if($human->user->type == 'teacher' && $human->status == 'active' && $human->groupT == 'NAO')
                        <option value="{{$human->id}}">{{$human->name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Cancelar</button>
              <button type="submit" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i> Cadastrar</button>
            </div>        
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="editModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Editar grupo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <form action="{{URL::to('Admin/Grupo/Editar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="groupId">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="groupName">Nome</label>
                  <input type="text" name="name" class="form-control" maxlength="80" value="" id="groupName" required>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="form-group">
                  <label for="groupTeacher_id">Professor</label>
                  <select class="form-control" name="teacher_id" id="groupTeacher_id">
                    <option value="">Selecione o professor</option>
                    @foreach($humans as $human)
                      <!--Está sem validação(precisa)-->
                      @if($human->user->type == 'teacher' && $human->status == 'active' && $human->groupT == 'NÃO')
                        <option value="{{$human->id}}">{{$human->name}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Cancelar</button>
              <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="deleteModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{URL::to('Admin/Grupo/Excluir')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="deleteIdGroup" value="">
            <div class="text-center">
              <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
            </div>
            <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
            <p class="text-center">Caso deseje excluir o "GRUPO" clique no botão confirmar</p>
            <h4 class="text-center"><strong id="deleteNameGroup"></strong></h4>
            <br>
            <div class="text-center">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-danger btn-lg">Confirmar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="desactivateModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('grupo.desactivate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="groupStatusId" value="">
            <div class="text-center text-danger">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center mt-3 mb-0">Se você realmente deseja desativar o grupo <strong class="groupStatusName"></strong>?</p>
            <div class="text-center">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Não</button>
              <button type="submit" class="btn btn-danger btn-lg"><i class="fas fa-check-circle"></i> Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="activateModalGroup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('grupo.activate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="groupStatusId" value="">
            <div class="text-center text-success">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center mt-3 mb-0">Se você realmente deseja ativar o grupo <strong class="groupStatusName"></strong>?</p>
            <div class="text-center">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Não</button>
              <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-check-circle"></i> Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
