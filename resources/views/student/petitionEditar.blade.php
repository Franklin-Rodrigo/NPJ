@extends('layouts.student')
@section('subtitle', 'Petição')
@section('component')
  <div class="container">
    <div class="row justify-content-center my-3 mt-5">
      <div class="text-center">
      <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#comments" aria-expanded="false" aria-controls="collapseExample">
        <span class="fas fa-comments mr-1"></span>
          Ver comentários
        </button>
      </div>
    </div>

    <!-- pra mostrar quando a petição é salva -->
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

    <div class="row justify-content-center">
      <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Aluno/Peticao/Editar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{$petition->id}}">
        <div class="row">
          <label for="">Template</label>
          <select class="form-control" name="template_id" disabled>
            <option value="{{$templates->find($petition->template_id)->id}}">{{$templates->find($petition->template_id)->title}}</option>
          </select>
        </div>
        <br>
        <div class="row">
          <label for="">Descrição</label>
          <input class="form-control" name="description" value="{{$petition->description}}" />
        </div><br>
        <div class="row">
          <label>Conteúdo:</label><br>
          <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$petition->content}}</textarea>
        </div>
        <br>

        <label class="row">Documentação:</label>
        <div class="row align-items-center">
            <br>
            @foreach($photos as $photo)
              @if($photo->photo != "" || $photo->photo != null)
              <div class="col-3 mb-3">
                <div class="text-center">
                  @if(explode('/', File::mimeType('storage/'.$photo->photo))[0] == 'image')
                  <img id="myImg" src="{{URL::asset('storage/'.$photo->photo)}}" class="img-fluid img-thumbnail" style="width:200px; height:200px;" onclick="showImage(this)">
                  @else
                  <a target="_blank" href="{{URL::asset('storage/'.$photo->photo)}}">Abrir {{explode('/', $photo->photo)[2]}} em nova guia</a>
                  @endif
                  <br>
                  <button type="button" class="btn btn-sm btn-danger mt-1" onClick="location.href='{{URL::to('Aluno/Peticao/Edit/' . $petition->id . '/DeletePhoto/' . $photo->id )}}'">
                    <span class="fas fa-trash"></span>
                  </button>
                </div>
              </div>
              @endif
            @endforeach
        </div>
        <br>

        <div class="row">
          <input type="file" accept="image/*" name="images[]" multiple>
        </div>

        <br>
        <div class="row justify-content-center">
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
              <span class="fas fa-times mr-1"></span>
              Cancelar
            </button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
              <span class="fas fa-save mr-1"></span>
              Salvar
            </button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
              <span class="fas fa-share mr-1"></span>
              Enviar
            </button>
          </div>
        </div>
      </form>
    </div>


  
<div class="modal fade" id="comments" tabindex="-1" role="dialog" aria-labelledby="comments" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comentários</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div class="text-left ">
              <strong><h4>Professor</h4></strong>
            </div>
            <ul>
              @foreach($profComments as $comment)
              <li>
                {{$comment->human->name}}
                <br>
                <p class="text-justify"><strong>Comentário:</strong> {{$comment->content}}</p>
              </li>
              @endforeach
            </ul>
            @if(count($profComments) < 1)
            <p class="text-center">Nenhum comentário!</p>
            @endif
          </div>

          <div class="col-12">
            <div class="text-left">
              <strong><h4>Supervisor</h4></strong>
            </div>
            <ul>
              @foreach($supComments as $comment)
              <li>
                {{$comment->human->name}}
                <br>
                <p class="text-justify"><strong>Comentário:</strong> {{$comment->content}}</p>
              </li>
              @endforeach
            </ul>
            @if(count($supComments) < 1)
            <p class="text-center">Nenhum comentário!</p>
            @endif
          </div>

          <div class="col-12">
            <div class="text-left ">
              <strong><h4>Defensor</h4></strong>
            </div>
            <ul>
                @foreach($defComments as $comment)
                <li>
                  {{$comment->human->name}}
                  <br>
                  <p class="text-justify"><strong>Comentário:</strong> {{$comment->content}}</p>
                  
                </li>
                @endforeach
            </ul>
            @if(count($defComments) < 1)
            <p class="text-center">Nenhum comentário!</p>
            @endif
          </div>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-undo mr-1"></i> Voltar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="myModal" class="img-modal">
      <span id="close" class="img-close">&times;</span>
      <img class="img-modal-content" id="img-view">
  </div>
</div>

@endsection
