<?php

use App\Entities\Group;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Rotas para usuário do tipo Admin */
Route::group(['middleware' => 'auth', 'prefix' => 'Admin'], function () {
    /*************Administrador*************/
    Route::get('', 'AdminController@index')->name('index');
    Route::get('Preferencias', 'AdminController@preferences')->name('preferencias');
    Route::post('Preferencias/Editar', 'AdminController@editar')->name('preferencias.editar');

    /*************Alunos*************/
    Route::get('Alunos', 'StudentController@index')->name('alunos');
    Route::post('Aluno/Cadastrar', 'StudentController@store')->name('aluno.cadastrar');
    Route::post('Aluno/Editar', 'StudentController@update')->name('aluno.editar');
    Route::post('Aluno/Excluir', 'StudentController@destroy')->name('aluno.excluir');
    Route::post('Aluno/Desativar', 'StudentController@desactivate')->name('aluno.desactivate');
    Route::post('Aluno/Ativar', 'StudentController@activate')->name('aluno.activate');
    
    /*************Duplas*************/
    Route::get('Duplas', 'DoubleStudentController@index')->name('duplas');
    Route::post('Dupla/Cadastrar', 'DoubleStudentController@store')->name('dupla..cadastrar');
    Route::post('Dupla/Editar', 'DoubleStudentController@update')->name('dupla.editar');
    Route::post('Dupla/Excluir', 'DoubleStudentController@destroy')->name('dupla.excluir');
    
    /*************Professores*************/
    Route::get('Professores', 'TeacherController@index')->name('professores');
    Route::post('Professor/Cadastrar', 'TeacherController@store')->name('professor.cadastrar');
    Route::post('Professor/Editar', 'TeacherController@update')->name('professor.editar');
    Route::post('Professor/Excluir', 'TeacherController@destroy')->name('professor.excluir');
    Route::post('Professor/Desativar', 'TeacherController@desactivate')->name('professor.desactivate');
    Route::post('Professor/Ativar', 'TeacherController@activate')->name('professor.activate');
    
    /*************Supervisores*************/
    Route::get('Supervisores', 'SupervisorController@index')->name('supervisores');
    Route::post('Supervisor/Cadastrar', 'SupervisorController@store')->name('supervisor.cadastrar');
    Route::post('Supervisor/Editar', 'SupervisorController@update')->name('supervisor.editar');
    Route::post('Supervisor/Excluir', 'SupervisorController@destroy')->name('supervisor.excluir');
    Route::post('Supervisor/Desativar', 'SupervisorController@desactivate')->name('supervisor.desactivate');
    Route::post('Supervisor/Ativar', 'SupervisorController@activate')->name('supervisor.activate');
    
    /*************Grupos*************/
    Route::get('Grupos', 'GroupController@index')->name('grupos');
    Route::post('Grupo/Cadastrar', 'GroupController@store')->name('grupo.cadastrar');
    Route::post('Grupo/Editar', 'GroupController@update')->name('grupo.editar');
    Route::post('Grupo/Excluir', 'GroupController@destroy')->name('grupo.excluir');
    Route::post('Grupo/Desativar', 'GroupController@desactivate')->name('grupo.desactivate');
    Route::post('Grupo/Ativar', 'GroupController@activate')->name('grupo.activate');
    
    /*************Defensores*************/
    Route::get('Defensores', 'DefenderController@index')->name('defensores');
    Route::post('Defensor/Cadastrar', 'DefenderController@store')->name('defender.cadastrar');
    Route::post('Defensor/Editar', 'DefenderController@update')->name('defender.editar');
    Route::post('Defensor/Excluir', 'DefenderController@destroy')->name('defender.excluir');
    Route::post('Defensor/Desativar', 'DefenderController@desactivate')->name('defender.desactivate');
    Route::post('Defensor/Ativar', 'DefenderController@activate')->name('defender.activate');
    
    /*************Records*************/
    Route::get('Records', 'RecordController@index')->name('records');
    Route::get('Records/Aluno/{id}', 'RecordController@show')->name('record.show');
    Route::get('Records/Aluno/{user_id}/Peticao/Show/{petition_id}', 'RecordController@petition')->name('record.petition');

    /*************Logs*************/
    Route::get('Logs', 'LogController@index')->name('logs');
});

/* Rotas para usuário do tipo Aluno */
Route::group(['middleware' => 'auth', 'prefix' => 'Aluno'], function () {
    
    /*************Painel de Controle*************/
    Route::get('', 'StudentController@index')->name('aluno.index');
    Route::get('Preferencias', 'StudentController@preferences')->name('aluno.preferencias');
    Route::post('Preferencias/Editar', 'StudentController@preferencesEditar')->name('aluno.preferencias.editar');
    //Escolher Template
    Route::post('Template/Escolher', 'PetitionController@escolherTemplate')->name('aluno.template.escolher');
    
    /*************Peticoes*************/
    Route::get('Peticoes', 'PetitionController@index')->name('aluno.peticoes'); //ver suas peticoes
    Route::get('Peticao/Add', 'PetitionController@add')->name('aluno.peticao.add');
    Route::post('Peticao/MudarPeticao', 'PetitionController@changePetition')->name('aluno.peticao.mudarPeticao');
    Route::post('Peticao/CopiarPeticao', 'PetitionController@copyPetition')->name('aluno.peticao.copiarPeticao');
    Route::post('Peticao/save', 'PetitionController@save')->name('aluno.peticao.save');
    Route::post('Peticao/Cadastrar', 'PetitionController@store')->name('aluno.peticao.cadastrar');
    Route::get('Peticao/Edit/{id}', 'PetitionController@edit')->name('aluno.peticao.edit');
    Route::post('Peticao/Editar', 'PetitionController@update')->name('aluno.peticao.editar');
    Route::get('Peticao/Show/{id}', 'PetitionController@show')->name('aluno.peticao.show');
    Route::post('Peticao/Delete', 'PetitionController@delete')->name('aluno.peticao.delete');
    Route::get('Peticao/Edit/{petition_id}/DeletePhoto/{photo_id}', 'PetitionController@deletePhoto')->name('aluno.peticao.deletePhoto');
});

//-----------------------------------------------------------------------------

/* Rotas para usuário do tipo Professor */
Route::group(['middleware' => 'auth', 'prefix' => 'Professor'], function () {
    /*************Painel de Controle*************/
    Route::get('', 'TeacherController@index')->name('professor.index');
    Route::get('Preferencias', 'TeacherController@preferences')->name('professor.preferencias');
    Route::post('Preferencias/Editar', 'TeacherController@preferencesEditar')->name('professor.preferencias.editar'); 
    
    /*************Duplas*************/
    Route::get('Duplas', 'DoubleStudentController@index')->name('professor.duplas'); //Ver as duplas do seu grupo
    
    /*************Templates*************/
    Route::get('Templates', 'TemplateController@index')->name('professor.templates');
    Route::get('Template/Add', 'TemplateController@add')->name('professor.template.add');
    Route::post('Template/Cadastrar', 'TemplateController@store')->name('professor.template.cadastrar');
    Route::get('Template/Edit/{id}', 'TemplateController@edit')->name('professor.template.edit');
    Route::post('Template/Editar', 'TemplateController@update')->name('professor.template.editar');
    Route::post('Template/Excluir', 'TemplateController@destroy')->name('professor.template.excluir');
    Route::get('Template/Show/{id}', 'TemplateController@show')->name('professor.template.show');
    Route::post('Template/Status', 'TemplateController@editStatus')->name('professor.template.status');
    
    /*************Peticoes*************/
    Route::get('Peticoes', 'PetitionController@index')->name('professor.peticoes'); //ver as peticoes do grupo
    Route::get('Peticao/Avaliar/{id}', 'PetitionController@avaliar')->name('professor.peticao.avaliar');
    Route::post('Peticao/Template', 'PetitionController@template')->name('professor.peticao.template'); //ver as peticoes do grupo
    Route::get('Peticao/Show/{id}', 'PetitionController@show')->name('professor.peticao.show');// falta metodos de editar petição que o professor deve poder    
    Route::get('Peticao/Edit/{id}', 'PetitionController@edit')->name('professor.peticao.edit');
    Route::post('Peticao/Editar', 'PetitionController@update')->name('professor.peticao.editar');
    Route::get('Peticao/Edit/{petition_id}/DeletePhoto/{photo_id}', 'PetitionController@deletePhoto')->name('professor.peticao.deletePhoto');
    
    /*************Comentarios*************/
    Route::post('Comentario/Cadastrar', 'CommentController@store')->name('professor.comentario.cadastrar'); //O professor pode cadastrar comentario
});

/* Rotas para usuário do tipo Supervisor */
Route::group(['middleware' => 'auth', 'prefix' => 'Supervisor'], function () {
    
    /*************Painel de Controle*************/
    Route::get('', 'SupervisorController@index')->name('supervisor.index');
    Route::get('Preferencias', 'SupervisorController@preferences')->name('supervisor.preferencias');
    Route::post('Preferencias/Editar', 'SupervisorController@preferencesEditar')->name('supervisor.preferencias.editar');
    
    /*************Peticoes*************/
    Route::get('Peticoes', 'PetitionController@index')->name('supervisor.peticoes'); //ver as peticoes do grupo
    Route::get('Peticao/Avaliar/{id}', 'PetitionController@avaliar')->name('supervisor.peticao.avaliar');
    Route::get('Peticao/Show/{id}', 'PetitionController@show')->name('supervisor.peticao.show');// falta metodos de editar petição que o professor deve poder    
    Route::get('Peticao/Edit/{id}', 'PetitionController@edit')->name('supervisor.peticao.edit');
    Route::post('Peticao/Editar', 'PetitionController@update')->name('supervisor.peticao.editar');
    Route::get('Peticao/Edit/{petition_id}/DeletePhoto/{photo_id}', 'PetitionController@deletePhoto')->name('supervisor.peticao.deletePhoto');
    
    /*************Comentarios*************/
    Route::post('Comentario/Cadastrar', 'CommentController@store')->name('supervisor.comentario.cadastrar'); //O professor pode cadastrar comentario
});

/* Rotas para usuário do tipo Defensor */
Route::group(['middleware' => 'auth', 'prefix' => 'Defensor'], function () {
    
    /*************Painel de Controle*************/
    Route::get('', 'DefenderController@index')->name('defensor.index');
    Route::get('Preferencias', 'DefenderController@preferences')->name('defensor.preferencias');
    Route::post('Preferencias/Editar', 'DefenderController@preferencesEditar')->name('defensor.preferencias.editar');
    
    /*************Peticoes*************/
    Route::get('Peticoes', 'PetitionController@index')->name('defensor.peticoes'); //ver as peticoes das quais ele pertence
    Route::get('Peticao/Show/{id}', 'PetitionController@show')->name('defensor.peticao.show');
    Route::get('Peticao/Emitir/{id}', 'PetitionController@emitir')->name('defensor.peticao.emitir');
    //Ao ver as peticoes, ele irá ver também todos os comentarios que ele fez referentes aquela peticao
    Route::get('Peticao/Avaliar/{id}', 'PetitionController@avaliar')->name('defensor.peticao.avaliar');
    Route::post('Peticao/Emitir', 'PetitionController@emitir')->name('defensor.peticao.emitir');
    Route::post('Comentario/Cadastrar', 'CommentController@store')->name('defensor.comentario.cadastrar'); //O defensor pode cadastrar comentario
});

//Route::post('Login', 'LoginController@index')->name('home');

Route::get('Sair', function () {
    if (!Auth::guest()) {
        Auth::logout();
    }
    return redirect('/');
})->name('sair');

Auth::routes();

Route::get('/', 'HomeController@index');
