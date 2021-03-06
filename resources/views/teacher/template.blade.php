@extends('layouts.teacher')
@section('subtitle', 'Templates')
@section('component')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-lg-12 my-5">
      <div class="card">
        <div class="card-header">
            <h4>
                Gerenciar templates
                <button type="button" class="btn btn-md btn-primary float-right" onClick="location.href='{{URL::to('Professor/Template/Add')}}'" title="Clique para abrir o formulário de novo Template" ><i class="fas fa-plus mr-2"></i>Novo template</button>
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
                  <table class="table table-condensed table-striped table-bordered">
                    <thead class="thead-dark">
                      <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Título</th>
                        <th class="text-center">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($templates as $template)
                          <tr class="object align-middle" name="{{$template->title}}">
                            <td class="text-center align-middle">
                              @if($template->status == 'inactive')
                                <button class="btn btn-danger" onclick="mudarStatusTemplate({{$template->id}})" title="Postar template"><i class="fas fa-toggle-off mr-1"></i> Postar template</button>
                              @else
                                <button type="button" class="btn btn-md btn-success" role="button" onclick="mudarStatusTemplate({{$template->id}})" title="Tornar rascunho"><i class="fas fa-toggle-on mr-1"></i> Tornar rascunho</button>
                              @endif
                            </td>
                            <td class="text-center align-middle">{{$template->title}}</td>
                            <td class="text-center align-middle">
                              <button type="button" class="btn btn-success" role="button" onClick="location.href='Template/Show/{{$template->id}}'" title="Visualizar Template"><i class="fa fa-eye"></i></button>
                              <button type="button" class="btn btn-warning" role="button" onClick="location.href='Template/Edit/{{$template->id}}'" title="Editar Template"><i class="fa fa-edit"></i></button>
                            </td>
                          </tr>
                      @empty
                      <td class="text-center" colspan="3">Nenhum template registrado!</td>
                      @endforelse
                    </tbody>
                  </table>
                    </div>
      

      </div>  
    </div>
  </div>
</div>


@endsection