@extends('layouts.teacher')
@section('subtitle', 'Preferências')
@section('component')
<div class="container">
    <div class="row justify-content-center my-5">
      <div class="col-lg-10">
        <div class="card">
  
          <div class="card-header">
            <h4 class="card-title mb-0">Preferências</h4>
          </div>
  
          <div class="card-body">

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

            <form action="{{URL::to('Professor/Preferencias/Editar')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" name="idUser" value="{{$user->id}}">
              <input type="hidden" name="idHuman" value="{{$human->id}}">
              <div class="row">
                <div class="col-md-4">
                  <small class="pull-right text-danger">*Campos obrigatórios</small>
                </div>
              </div>
              <div class="form-group">
                <label for="">Nome *</label>
                <input type="text" name="name" class="form-control" maxlength="80" value="{{$human->name}}" required>
              </div>
              <div class="form-group">
                <label for="">E-mail *</label>
                <input type="text" name="email" class="form-control" maxlength="80" value="{{$user->email}}" disabled>
              </div>
              <div class="row">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label for="">Sexo *</label>
                    <select class="form-control" name="gender" required>
                      <option value="Masculino" @if($human->gender == 'Masculino') selected @endif>Masculino</option>
                      <option value="Feminino" @if($human->gender == 'Feminino') selected @endif>Feminino</option>
                      <option value="Não informado" @if($human->gender == 'Não informado') selected @endif>Não informar</option>
                    </select>
                  </div>
                </div>
  
                <div class="col-lg-9">
                  <div class="form-group">
                    <label for="">Telefone</label>
                    <input type="tel" name="phone" class="form-control input-phone" value="{{$human->phone}}">
                  </div>
                </div>
              </div>
  
              <div class="row">
                <div class="col-md-4">
                  <small class="pull-right text-danger">Caso deseje alterar sua senha, preencha os campos abaixo</small>
                </div>
              </div>
  
              <div class="form-group">
                <label for="">Senha</label>
                <input type="password" name="password" class="form-control">
              </div>
  
              <div class="form-group">
                <label for="">Confirmação de senha</label>
                <input type="password" name="password_confirmation" class="form-control">
              </div>
          </div>
          <div class="card-footer text-center">
            <button type="submit" name="botao" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    
@endsection