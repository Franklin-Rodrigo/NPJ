@extends('layouts.admin')
@section('component')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-12 my-5">
      <div class="card my-5">
        <div class="card-header">
          <h4>
            Gerenciar Duplas
            <button type="button" class="btn btn-primary float-right" role="button" data-toggle="modal" data-target="#newModaldoubleStudent" data-toggle="tooltip" data-placement="left" title="Clique para abrir o formulário de novo aluno">
              <i class="fa fa-plus"></i>
              Nova Dupla
            </button>
          </h4>
        </div>
        <div class="card-body">
          <div class="col-lg-12">
            <div class="row">
              @if ($errors->any())
              <div class="alert alert-danger">
                <u0 class="mb-0">
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
                    <th class="text-center">Dupla</th> 
                    <th class="text-center">Grupo</th>
                    <th class="text-center">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($doubleStudents as $doubleStudent)
                    @if($humans->find($doubleStudent->student_id) && $humans->find($doubleStudent->student2_id))
                      <tr class="object align-middle" name="{{$humans->find($doubleStudent->student_id)->name}}">
                        <td class="text-center align-middle">
                          {{$humans->find($doubleStudent->student_id)->name}} | 
                          {{$humans->find($doubleStudent->student2_id)->name}}
                        </td>                            
                        <td class="text-center align-middle">{{$doubleStudent->group->name}}</td>
                        <td class="text-center align-middle">
                          <button type="button" class="btn btn-outline-warning" role="button" data-toggle="modal" data-target="#editModaldoubleStudent" onclick="editModaldoubleStudent('{{$doubleStudent->id}}','{{$humans->find($doubleStudent->student_id)->name}}','{{$humans->find($doubleStudent->student2_id)->name}}','{{$doubleStudent->group->name}}')" title="Editar Dupla"><i class="fa fa-edit"></i></button>
                          <button type="button" class="btn btn-outline-danger" role="button" data-toggle="modal" data-target="#deleteModaldoubleStudent" onclick="deletedoubleStudent('{{$doubleStudent->id}}')" title="Excluir Dupla"><i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                    @endif
                  @empty
                  <tr class="my-auto align-middle">
                    <td class="text-center" colspan="3">Nenhuma dupla registrada!</td>
                  </tr>                      
                  @endforelse
                </tbody>
              </table>
            </div>            
          </div>
        </div>
      </div>
    </div>
  

  <!-- Modal -->
  <div class="modal fade" id="newModaldoubleStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Nova Dupla</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
          <form action="{{URL::to('Admin/Dupla/Cadastrar')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">            
              <div class="col-md-4">
                <small class="text-danger">* Campos Obrigatórios</small>
              </div>
            </div>
            <br>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="firstStudent">Primeiro Estudante</label>
              <select class="form-control" id="firstStudent" name="student_id" id="student_id" onchange="verify(this.value, 1)" required>
                <option value="">Selecione o Estudante</option>
                @foreach($humans as $human)
                  @if($human->user->type == 'student' && $human->status == 'active' && $human->doubleS == 'NAO')
                    <option value="{{$human->id}}" class="primeiros">{{$human->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
        
          <div class="col-md-6">
              <div class="form-group">
                <label for="secondStudent">Segundo Estudante</label>
                <select class="form-control" id="secondStudent" name="student2_id" id="student2_id" onchange="verify(this.value, 2)" required>
                  <option value="">Selecione o Estudante</option>
                  @foreach($humans as $human)
                    <div>
                      @if($human->user->type == 'student' && $human->status == 'active' && $human->doubleS == 'NAO')
                        <option value="{{$human->id}}" class="segundos" style="display:block">{{$human->name}}</option>
                      @endif
                    </div>
                  @endforeach
              </select>
            </div>
          </div>
            
          <div class="col-md-12">
            <div class="form-group">
              <label for="group">Grupo</label>
              <select class="form-control" id="group" name="group_id" required>
                <option value="">Selecione o Grupo</option>
                @foreach($groups as $group)
                  @if($group->status == 'active')
                    <option value="{{$group->id}}">{{$group->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>
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



  <div class="modal fade" id="editModaldoubleStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Editar Dupla</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form action="{{URL::to('Admin/Dupla/Editar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="doubleStudentId">
          <div class="row" style="margin-left:2px">
            <div class="form-group">
            <label for="doubleStudent1">Primeiro Estudante</label>
            <select class="form-control" name="student_id" id="doubleStudent1" onchange="verifyEdit(this.value)"/>
              <option value="">Selecione o Estudante</option>
              @foreach($humans as $human)
                @if($human->user->type == 'student' && $human->status == 'active' && $human->doubleS == 'NAO')
                  <option value="{{$human->id}}">{{$human->name}}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="row" style="margin-left:2px">
            <div class="form-group">
            <label for="doubleStudent2">Selecione o Estudante</label>
            <select class="form-control" name="student2_id" id="doubleStudent2"/>
              <option value="">Selecione o estudante</option>
              @foreach($humans as $human)
                @if($human->user->type == 'student' && $human->status == 'active' && $human->doubleS == 'NAO')
                  <option value="{{$human->id}}" id="rr">{{$human->name}}</option>
                @endif
              @endforeach
            </select>
            </div>
          </div>
          <div class="row" style="margin-left:18px">
            <div class="form-group">
            <label for="group-edit">Grupo</label>
            <select class="form-control" id="group-edit" name="group_id" id="doubleStudentGroup">
              <option value="">Selecione o Grupo</option>
              @foreach($groups as $group)
                @if($group->status == 'active')
                  <option value="{{$group->id}}">{{$group->name}}</option>
                @endif
              @endforeach
            </select>
            </div>
          </div>
      </div>
          <br>
          <div class="row">
            <div class="modal-footer" style="text-align:left">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
          </div>
        </div>
    </form>

  </div>
  </div>
  </div>


  <div class="modal fade" id="deleteModaldoubleStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form action="{{URL::to('Admin/Dupla/Excluir')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="deleteIdDoubleStudent" value="">
          <div class="text-center">
            <i class="fa fa-exclamation-circle fa-x6" aria-hidden="true"></i>
          </div>
          <h3 class="text-center"><strong style="color:red;">Atenção!</strong></h3>
          <p class="text-center">Caso deseje excluir a "DUPLA" clique no botão confirmar</p>
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

  </div>
@endsection
