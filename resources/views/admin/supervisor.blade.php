@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
                    <h4>Gerenciar Supervisores
                        <button type="button" class="btn btn-md btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalDefender" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo supervisor"><i class="fa fa-plus"></i> Novo Supervisor</button>
                    </h4>
        </div>
        <div class="card-body">
          <div class="col-lg-12">
           
              <div class="row">
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
                @if(Session::has('status'))
                  <p class="alert alert-info">{{ Session::get('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
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
                      @forelse($supervisors as $supervisor)
                        @if($supervisor->user->type == "supervisor")
                          <tr class="object align-middle" name="{{$supervisor->name}}">
                            <td class="text-center align-middle">
                              @if ($supervisor->status == 'active')
                                <button type="button" class="btn btn-success" role="button" data-toggle="modal" data-target="#desactivateModalSupervisor" onclick="supervisorStatus('{{$supervisor->id}}','{{$supervisor->name}}')" title="Desativar supervisor">
                                  <i class="fas fa-toggle-on"></i>
                                </button>
                              @else
                                <button type="button" class="btn btn-danger" role="button" data-toggle="modal" data-target="#activateModalSupervisor" onclick="supervisorStatus('{{$supervisor->id}}','{{$supervisor->name}}')" title="Ativar supervisor">
                                  <i class="fas fa-toggle-off"></i>
                                </button> 
                              @endif
                            </td>
                            <td class="text-center align-middle">{{$supervisor->name}}</td>
                            <td class="text-center align-middle">{{$supervisor->user->email}}</td>
                            <td class="text-center align-middle">{{$supervisor->gender}}</td>
                            <td class="text-center align-middle">{{$supervisor->phone}}</td>
                            <td style="font-size:18pt;width:15%" class="text-center">
                              <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#editModalSupervisor" onclick="editSupervisor('{{$supervisor->id}}','{{$supervisor->name}}','{{$supervisor->user->email}}','{{$supervisor->gender}}','{{$supervisor->phone}}')" title="Editar {{$supervisor->name}}">
                                <i class="fa fa-edit"></i> Editar
                              </button>
                            </td>
                          </tr>
                        
                        @endif
                      @empty
                   
                         <tr class="my-auto align-middle">
                            <td class="text-center " colspan="6">Nenhum supervisor registrado!</td>
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
<div class="modal fade" id="newModalDefender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Novo Supervisor </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{URL::to('Admin/Supervisor/Cadastrar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">            
            <div class="col-md-4">
              <small class="text-danger">* Campos Obrigatórios</small>
            </div>
          </div>
          <div class="form-group">
            <label for=name"">Nome *</label>
            <input type="text" id="name" name="name" class="form-control" maxlength="80" value="" required>
          </div>
          <div class="form-group">
            <label for="email">E-mail *</label>
            <input type="text" id="email" name="email" class="form-control" maxlength="80" value="" required>
          </div>
          <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                  <label for="gender">Sexo</label>
                  <select class="form-control" id="gender" name="gender" required>
                    <option value="">Selecione o sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Não informar">Não informar</option>
                  </select>
                </div>
            </div>
            <div class="col-lg-7">
              <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="tel" id="phone" name="phone" class="form-control input-phone" value="">
              </div>
            </div>
            </div>
          <div class="form-group">
            <label for="password">Senha *</label>
            <div class="input-group">
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="editModalSupervisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Editar Supervisor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <form action="{{URL::to('Admin/Supervisor/Editar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-8">
              </div>
            </div>
            <input type="hidden" name="id" id="supervisorId">
            <div class="form-group">
              <label for="supervisorName">Nome</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" id="supervisorName" required>
            </div>

            <div class="form-group">
              <label for="supervisorEmail">E-mail</label>
              <input type="text" name="email" class="form-control" maxlength="80" value="" id="supervisorEmail" required>
            </div>
            <div class="row">
                <div class="col-lg-5">
                  <div class="form-group">
                    <label for="supervisorGender">Sexo</label>
                    <select class="form-control" id="supervisorGender" name="gender" required>
                      <option value="">Selecione o sexo</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Feminino">Feminino</option>
                    </select>
                  </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                  <label for="supervisorPhone">Telefone</label>
                  <input type="tel" name="phone" class="form-control input-phone" value="">
                </div>
              </div>
              </div>
            <div class="form-group">
              <label for="supervisorPassword">Senha</label>
              <input type="password" id="supervisorPassowrd" name="password" id="password" class="form-control">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="deleteModalDefender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{URL::to('Admin/Supervisor/Excluir')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" id="deleteIdDefender" value="">
            <div class="text-center">
              <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
            </div>
            <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
            <p class="text-center">Caso deseje excluir o "Supervisor" clique no botão confirmar</p>
            <h4 class="text-center"><strong id="deleteNameDefender"></strong></h4>
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
  <div class="modal fade" id="desactivateModalSupervisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('supervisor.desactivate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="supervisorStatusId" value="">
            <div class="text-center text-danger">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center mt-3 mb-0">Se você realmente deseja desativar o supervisor <strong class="supervisorStatusName"></strong>?</p>
            <div class="text-center">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Não</button>
              <button type="submit" class="btn btn-danger btn-lg">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="activateModalSupervisor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('supervisor.activate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="supervisorStatusId" value="">
            <div class="text-center text-success">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center mt-3 mb-0">Se você realmente deseja ativar o supervisor <strong class="supervisorStatusName"></strong>?</p>
            <div class="text-center">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Não</button>
              <button type="submit" class="btn btn-success btn-lg">Sim</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
