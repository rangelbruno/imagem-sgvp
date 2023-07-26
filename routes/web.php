<?php

use App\Http\Controllers\{
    HomeController,
    UserController,
    ApiController,
    SessaoController,
    PresidenteController,
    VereadorController,
    ModalController,
    VoteController,
    PainelController,
};

use Illuminate\Support\Facades\Route;


/**
 * Login
*/
Route::view('/', 'login.index')->name('login');
Route::post('/usuarios/autenticar', [ApiController::class, 'autenticar'])->name('autenticar');
Route::view('/recuperar', 'login.senha')->name('senha'); 
Route::view('/caduser', 'caduser')->name('caduser'); 
/**
 * Chamada para a API
*/
Route::get('api-sgvp', [ApiController::class, 'index'])->name('api-sgvp');
/**
 * Home
*/
Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
/**
 * Usuario
*/
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::put('/usuarios/{nrSequence}', [UserController::class, 'update'])->name('usuarios.update');
Route::get('/usuarios/{nrSequence}/editar', [UserController::class, 'edit'])->name('usuarios.editar');
Route::get('/usuarios/cadastrar', [UserController::class, 'show'])->name('usuarios.cadastrar');
Route::get('/getusers', [UserController::class, 'getusers'])->name('getusers');
Route::post('/usuarios/cadastrar', [UserController::class, 'store'])->name('usuarios');
/**
 * Sessão
*/
Route::put('/documentos/{nrSequence}/atualiza-status', [SessaoController::class, 'desativarSessao'])->name('sessao.status');
Route::put('/sessao/{nrSequence}', [SessaoController::class, 'update'])->name('sessao.update');
Route::get('/sessao/{nrSequence}/editar', [SessaoController::class, 'edit'])->name('sessao.editar');
Route::get('/sessao/cadastrar', [SessaoController::class, 'show'])->name('sessao.cadastrar');
Route::get('/sessao', [SessaoController::class, 'index'])->name('sessao.index');
Route::post('/sessao', [SessaoController::class, 'store'])->name('sessao.store');

Route::post('/sessao/{nrSequence}/atualiza-status', [SessaoController::class, 'updateStatus'])->name('sessao.updateStatus'); 

/**
 * Gereciar Sessão Documentos
*/
Route::put('/documentos/{nrSequence}', [SessaoController::class, 'atualizarDocumento'])->name('documento.atualizar');
Route::get('/documentos/{nrSequence}/editar', [SessaoController::class, 'editdocumentos'])->name('documento.editar');
Route::get('/sessao/{nrSequence}/gerenciar', [SessaoController::class, 'gerenciar'])->name('sessao.gerenciar');
Route::get('/documentos/cadastrar/{nrSequence}', [SessaoController::class, 'caddocumentos'])->name('documento.cadastrar');
Route::delete('/documentos/{nrSequence}', [SessaoController::class, 'excluirDocumento'])->name('documento.excluir'); 
Route::post('/sessao/documentos', [SessaoController::class, 'cadastrarDocumentos'])->name('documentos.store');
/** 
 * Gereciar Sessão Roteiro
*/
Route::put('/roteiro/{nrSequence}', [SessaoController::class, 'atualizarRoteiro'])->name('roteiro.atualizar');
Route::get('/roteiro/{nrSequence}/editar', [SessaoController::class, 'editRoteiro'])->name('roteiro.editar');
Route::get('/roteiro/cadastrar/{nrSequence}', [SessaoController::class, 'cadRoteiro'])->name('roteiro.cadastrar');
Route::delete('/roteiro/{nrSequence}', [SessaoController::class, 'excluirRoteiro'])->name('roteiro.excluir');
Route::post('/sessao/roteiro', [SessaoController::class, 'cadastrarRoteiro'])->name('roteiro.store');
/**
 * Tela Presidente
*/
Route::get('/presidente', [PresidenteController::class, 'index'])->name('presidente.index');
Route::get('/presidente/home', [PresidenteController::class, 'home'])->name('presidente.home');
Route::get('/presidente/ordemdodia', [PresidenteController::class, 'ordemdodia'])->name('presidente.ordemdodia');
Route::get('/presidente/tribuna', [PresidenteController::class, 'tribuna'])->name('presidente.tribuna');
Route::get('/presidente/documento', [PresidenteController::class, 'documento'])->name('presidente.documento');
Route::get('/votacao/{nrSequence}', [PresidenteController::class, 'votacao'])->name('tela.votacao');

Route::post('/presidente/iniciar', [PresidenteController::class, 'iniciar'])->name('presidente.iniciar');

Route::get('/presidente/documentos', [PresidenteController::class, 'documentos'])->name('presidente.documentos');

Route::post('/encerrar-sessao', [PresidenteController::class, 'encerrarSessao'])->name('presidente.encerrarSessao');

// Route::get('/presidente/discussao', [PresidenteController::class, 'PainelVotação'])->name('presidente.votacao');

Route::get('/presidente/votacao', [PresidenteController::class, 'PainelVotacao'])->name('presidente.votacao');

Route::get('/presidente/encerrarvotacao/{nrSequence}', [PresidenteController::class, 'encerrarvotacao'])->name('presidente.encerrarvotacao');





// Route::get('/documentos', 'DocumentoController@index')->name('documentos.index');


/**
 * Tela Vereador
*/
Route::get('/vereador', [VereadorController::class, 'index'])->name('vereador.index');
Route::get('/vereador/home', [VereadorController::class, 'home'])->name('vereador.home');
Route::post('/inscrever-tribuna', [VereadorController::class, 'inscreverTribuna'])->name('inscrever-tribuna');


/**
 * Tela Painel
*/
Route::get('/painel', [PainelController::class, 'index'])->name('painel.index');
Route::get('/painel/votacao',[PainelController::class, 'PainelVotação'])->name('painel.votacao');
Route::get('/painel/discussao', [PainelController::class, 'PainelDiscussao'])->name('painel.discussao');


 

Route::get('/tribuna/vereadorAtual', [PainelController::class, 'vereadorAtual'])->name('tribuna.vereadorAtual');
Route::post('/tribuna/selecionarVereador', [PainelController::class, 'selecionarVereador'])->name('tribuna.selecionarVereador');


/**
 * Documentação
*/
Route::view('/documentacao', 'documentacao.index')->name('documentacao');
/**
 * Modal
*/
Route::post('/modal-open', [ModalController::class, 'openModal']);

/**
 * Votação Única
*/
Route::post('/votacao', [PresidenteController::class, 'sendVote'])->name('votacao.send');
Route::post('/vereador/votacao', [VereadorController::class, 'sendVote'])->name('votacao.enviar');

// Route::post('/votacao/preparar/{nrSequence}', [PresidenteController::class, 'preparar'])->name('votacao.preparar'); 

Route::post('/votacao/preparar/{nrSequence}', [PresidenteController::class, 'preparar'])->name('votacao.preparar');




Route::post('/documento/preparar-votacao-bloco', [PresidenteController::class, 'prepararVotacaoEmBloco'])->name('documento.prepararVotacaoEmBloco');





Route::get('/vereador/verificar-documento-votacao', [VereadorController::class, 'verificarDocumentoVotacao']);



/**
 * Votação em bloco
*/
// Route::post('/votacao-bloco', [PresidenteController::class, 'sendVotebloco'])->name('votacao-bloco.send');
Route::post('/votacao-bloco', [PresidenteController::class, 'sendBulkVote'])->name('votacao-bloco.send');

 
/**
 * Logout
*/
Route::get('/logout', [ApiController::class, 'logout'])->name('logout');
