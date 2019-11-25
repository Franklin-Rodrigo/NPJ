@extends('layouts.teacher')
@section('subtitle', 'Template')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10">
        <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
        <form action="{{URL::to('Professor/Template/Editar')}}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="idTemplate" value="{{$template->id}}">
          <label for="">Título:</label>
          <input class="form-control" type="text" name="title" value="{{$template->title}}" required/>
          <br>
          <label for="">Conteúdo:</label>
          <textarea  class="ckeditor" maxlength="99999" name="content" required>{{$template->content}}</textarea>
          <div class="row">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onClick="location.href='{{URL::to('Professor/Templates')}}'">
                <span class="fas fa-arrow-left mr-1"></span>
                Voltar
              </button>
              <button type="submit" class="btn btn-primary">
                <span class="fas fa-save mr-1"></span>
                Salvar
              </button>
            </div>
          </div>
    </div>
  </div>
</div>
@endsection
