@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
                    <h4>Gerenciar Defensores
                        <button type="button" class="btn btn-md btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalDefender" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo defensor"><i class="fa fa-plus"></i> Novo Defensor</button>
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
                  <p class="alert alert-info" style="width:20%;">{{ Session::get('status') }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
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
                      @forelse($defenders as $defender)
                        @if($defender->user->type == "defender")
                          <tr class="object align-middle" name="{{$defender->name}}">
                            <td class="text-center align-middle">
                              @if ($defender->status == 'active')
                                <button type="button" class="btn btn-success" role="button" data-toggle="modal" data-target="#desactivateModalDefender" onclick="defenderStatus('{{$defender->id}}','{{$defender->name}}')" title="Desativar supervisor">
                                  <i class="fas fa-toggle-on"></i>
                                </button>
                              @else
                                <button type="button" class="btn btn-danger" role="button" data-toggle="modal" data-target="#activateModalDefender" onclick="defenderStatus('{{$defender->id}}','{{$defender->name}}')" title="Ativar supervisor">
                                  <i class="fas fa-toggle-off"></i>
                                </button> 
                              @endif
                            </td>
                            <td class="text-center align-middle">{{$defender->name}}</td>
                            <td class="text-center align-middle">{{$defender->user->email}}</td>
                            <td class="text-center align-middle">{{$defender->gender}}</td>
                            <td class="text-center align-middle">{{$defender->phone}}</td>
                            <td style="font-size:18pt;width:15%" class="text-center">
                              <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#editModalDefender" onclick="editDefender('{{$defender->id}}','{{$defender->name}}','{{$defender->user->email}}','{{$defender->gender}}','{{$defender->phone}}')" title="Editar {{$defender->name}}">
                                <i class="fa fa-edit"></i> Editar
                              </button>
                            </td>
                          </tr>
                        @endif
                      @empty
                      <td class="text-center">Nenhum Defensor registrado!</td>
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
        <h4 class="modal-title" id="myModalLabel">Novo Defensor </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{URL::to('Admin/Defensor/Cadastrar')}}" method="post" enctype="multipart/form-data">
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
<div class="modal fade" id="editModalDefender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Editar Defensor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">

        <form action="{{URL::to('Admin/Defensor/Editar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-8">
            </div>
          </div>
          <input type="hidden" name="id" id="defenderId">
          <div class="form-group">
            <label for="defenderName">Nome</label>
            <input type="text" name="name" class="form-control" maxlength="80" value="" id="defenderName" required>
          </div>

          <div class="form-group">
            <label for="defenderEmail">E-mail</label>
            <input type="text" name="email" class="form-control" maxlength="80" value="" id="defenderEmail" required>
          </div>
          <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                  <label for="defenderGender">Sexo</label>
                  <select class="form-control" id="defenderGender" name="gender" required>
                    <option value="">Selecione o sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                  </select>
                </div>
            </div>
            <div class="col-lg-7">
              <div class="form-group">
                <label for="defenderPhone">Telefone</label>
                <input type="tel" name="phone" class="form-control input-phone" value="">
              </div>
            </div>
            </div>
          <div class="form-group">
            <label for="defenderPassword">Senha</label>
            <input type="password" id="defenderPassowrd" name="password" id="password" class="form-control">
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
        <form action="{{URL::to('Admin/Defensor/Excluir')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="deleteIdDefender" value="">
          <div class="text-center">
            <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
          </div>
          <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
          <p class="text-center">Caso deseje excluir o "Defensor" clique no botão confirmar</p>
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
  <div class="modal fade" id="desactivateModalDefender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form action="{{route('defender.desactivate')}}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="id" class="defenderStatusId" value="">
              <div class="text-center text-danger">
                <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
              </div>
              <p class="text-center mt-3 mb-0">Se você realmente deseja desativar o supervisor <strong class="defenderStatusName"></strong>?</p>
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
    <div class="modal fade" id="activateModalDefender" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <form action="{{route('defender.activate')}}" method="post">
              {{ csrf_field() }}
              <input type="hidden" name="id" class="defenderStatusId" value="">
              <div class="text-center text-success">
                <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
              </div>
              <p class="text-center mt-3 mb-0">Se você realmente deseja ativar o supervisor <strong class="defenderStatusName"></strong>?</p>
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
