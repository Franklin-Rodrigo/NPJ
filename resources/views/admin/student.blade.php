@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>
            Gerenciar Alunos
            <button type="button" class="btn btn-primary float-right" role="button" data-toggle="modal" data-target="#newModalStudent" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo aluno">
              <i class="fa fa-plus"></i>
              Novo Aluno
            </button>
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
                        <th class="text-center">Dupla</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>

                    <tbody>
                      @forelse($students as $student)
                        @if($student->user->type == "student")
                          <tr class="object align-middle" name="{{$student->name}}">
                            <td class="text-center align-middle">
                                @if ($student->status == 'active')
                                <button type="button" class="btn btn-success" role="button" data-toggle="modal" data-target="#desactivateModalStudent" onclick="studentStatus('{{$student->id}}','{{$student->name}}')" title="Desativar aluno">
                                  <i class="fas fa-toggle-on"></i>
                                </button>
                              @else
                                <button type="button" class="btn btn-danger" role="button" data-toggle="modal" data-target="#activateModalStudent" onclick="studentStatus('{{$student->id}}','{{$student->name}}')" title="Ativar aluno">
                                  <i class="fas fa-toggle-off"></i>
                                </button> 
                              @endif
                            </td>
                            <td class="text-center align-middle">{{$student->name}}</td>
                            <td class="text-center align-middle">{{$student->user->email}}</td>
                            <td class="text-center align-middle">{{$student->gender}}</td>
                            <td class="text-center align-middle">{{$student->phone}}</td>
                            <td class="text-center align-middle">
                              @if($student->doubleS == "SIM")
                                <span class="fas fa-check-circle fa-lg text-success" title="Possui dupla"></span>
                              @else
                                <span class="fas fa-times-circle fa-lg text-danger" title="Não possui dupla"></span>
                              @endif
                            </td>
                            
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#editModalStudent" onclick="editStudent('{{$student->id}}','{{$student->name}}','{{$student->user->email}}','{{$student->gender}}','{{$student->phone}}')" title="Editar Aluno">
                                <i class="fas fa-edit"></i> Editar
                              </button>
                            </td>
                          </tr>
                        @endif
                      @empty
                      <tr class="my-auto align-middle">
                            <td class="text-center " colspan="7">Nenhum aluno registrado!</td>
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
  <div class="modal fade" id="newModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Novo Aluno</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{URL::to('Admin/Aluno/Cadastrar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-4">
                <small class="pull-right" style="color:red">* Campos Obrigatórios</small>
              </div>
            </div>
            <br>
            <div class="form-group">
              <label for="name">Nome *</label>
              <input type="text" id="name" name="name" class="form-control" maxlength="80" value="" required>
            </div>
            <div class="form-group">
              <label for="email">E-mail *</label>
              <input type="email" id="email" name="email" class="form-control" maxlength="80" value="" required>
            </div>
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                  <label for="gender">Sexo</label>
                  <select class="form-control" id="gender" name="gender">
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
              <input type="password" id="password" name="password" class="form-control" required>
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
  </div>

  <!-- Modal -->
  <div class="modal fade" id="editModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Editar Aluno</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">

          <form action="{{URL::to('Admin/Aluno/Editar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-8">
              </div>
            </div>
            <input type="hidden" name="id" id="studentId">
            <div class="form-group">
              <label for="studentName">Nome</label>
              <input type="text" name="name" class="form-control" maxlength="80" value="" id="studentName" required>
            </div>

            <div class="form-group">
              <label for="studentEmail">E-mail</label>
              <input type="email" name="email" class="form-control" maxlength="80" value="" id="studentEmail" required>
            </div>
            <div class="row">
                <div class="col-lg-5">
                  <div class="form-group">
                    <label for="studentGender">Gênero</label>
                    <select class="form-control" id="studentGender" name="gender" required>
                      <option value="">Selecione o gênero</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Feminino">Feminino</option>
                    </select>
                  </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group">
                  <label for="studentPhone">Telefone</label>
                  <input type="tel" id="studentPhone" name="phone" class="form-control input-phone" value="">
                </div>
              </div>
              </div>
            <div class="form-group">
              <label for="studentPassword">Senha</label>
              <input type="password" id="studentPassword" name="password" class="form-control">
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
  <div class="modal fade" id="desactivateModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('aluno.desactivate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="studentStatusId" value="">
            <div class="text-center text-danger">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center mt-3 mb-0">Se você realmente deseja desativar o aluno <strong class="studentStatusName"></strong>?</p>
            <p class="text-center">Ele será removido de sua dupla!</p>
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
  <div class="modal fade" id="activateModalStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{route('aluno.activate')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="studentStatusId" value="">
            <div class="text-center text-success">
              <i class="fa fa-exclamation-circle fa-x9" aria-hidden="true"></i> <h4 class="text-center"><strong>Atenção!</strong></h4>
            </div>
            <p class="text-center">Se você realmente ativar o aluno <strong class="studentStatusName"></strong>?</p>
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
