@extends('layouts.base')

@section('title')
NPJ - SISTEMA
@endsection

@section('content')
    <div class="container bg-home">
        <div style="height: 100vh;" class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-8 col-10">
                
                <div style="border-radius: 2%" class="card">
                    <div class="card-body">
                        <div class="box-parent-login">
                            <div class="well bg-white box-login">
                                <div class="text-center mb-3">
                                    <img src="{{URL::asset('assets/img/logo-NPJ.png')}}" class="img-fluid" style="height:100px;">
                                </div>

                                    <fieldset>

                                        @if(Session::has('erro'))
                                        <div class="alert alert-danger">
                                            <h4>Não foi possível realizar o login:</h4>
                                            <p class="mb-0">
                                                {{ Session::get('erro') }}
                                                <br>
                                                Entre em contato com o administrador.
                                            </p>
                                        </div>                 
                                        @endif
                                        <div class="text-center">
                                            <button type="button" name="button" class="btn btn-lg btn-danger" onClick="location.href='{{URL::to('Sair')}}'">
                                                <span class="fas fa-sign-out-alt"></span>
                                                SAIR
                                            </button>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>

                    
            </div>
        </div>
    </div>
@endsection
