@extends('layouts.student')
@section('component')
  <div class="container">
    <div class="row justify-content-center mt-3">
      <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{ route('aluno.peticao.cadastrar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="template_id" value="{{$template->id}}"/>
        <label for="">Título da petição</label>
        <input class="form-control" type="text" value="{{$template->title}}" disabled/>
        <br>
        <label for="">Descrição</label>
        <input class="form-control" type="text" name="description" value="" required/>
        <br>
        <label for="">Conteúdo</label>
        <textarea class="ckeditor" maxlength="99999" name="content" required>{{$template->content}}</textarea>
        <br>
        <div class="row">
          <div class="col-md-6">
            <label>Documentação</label>
            <input type="file" accept="image/*" name="images[]" multiple>
          </div>
        </div>
        <br>
        <div class="row justify-content-center">
          <div class="text-center">
            <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Aluno/Peticoes')}}'">
              Cancelar
              <span class="fas fa-times ml-2"></span>
            </button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR">
              Salvar
              <span class="fas fa-save ml-2"></span>
            </button>
            <button type="submit" name="botao" class="btn btn-success" value="ENVIAR">
              Enviar
              <span class="fas fa-share ml-2"></span>
            </button>
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
@endsection
