@extends('layouts.teacher')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-10">
      <script src="{{ asset('tools/ckeditor/ckeditor.js')}}"></script>
      <form action="{{URL::to('Professor/Template/Cadastrar')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="">Título</label>
        <input class="form-control" type="text" name="title" value="" required/>
        <br>
        <label for="">Conteúdo</label>
        <textarea class="ckeditor" maxlength="99999" name="content" required></textarea>
        <br>
        <div class="row">
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" onClick="location.href='{{URL::to('Professor/Templates')}}'"><i class="fas fa-undo mr-1"></i> Cancelar</button>
            <button type="submit" name="botao" class="btn btn-primary" value="SALVAR"><span class="fas fa-save mr-1"></span> Salvar</button>
            <button type="submit" name="botao" class="btn btn-success" value="POSTAR"><i class="fas fa-share mr-1"></i> Postar</button>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
