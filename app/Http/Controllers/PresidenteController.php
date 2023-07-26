<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Facades\ApiSgvp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PresidenteController extends Controller
{
    public function index()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $query = 'perfil=PRESIDENTE&perfil=VEREADOR&statusOnline=true&status=ATIVO';
                $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);

                if ($response->successful()) {
                    $usuarios = $response->json();

                    // Limita a lista de usuários a 4
                    $usuarios_limitados = array_slice($usuarios, 0, 4);

                    // Conta o total de usuários
                    $total_usuarios = count($usuarios);

                    // Obtenha as sessões autorizadas
                    $response_sessoes = ApiSgvp::withToken($token)->get('/sessao?statusSessao=AUTORIZADA');
                    $sessoes_autorizadas = $response_sessoes->json();

                    return view('presidente.index', [
                        'token' => $token,
                        'usuarios' => $usuarios_limitados,
                        'total_usuarios' => $total_usuarios,
                        'percentual_usuarios_logados' => ($total_usuarios / 9) * 100,
                        'sessoes' => $sessoes_autorizadas,
                    ]);
                } else {
                    return redirect()->route('login')->withErrors('Houve um erro ao obter as informações do usuário.');
                }
            } catch (Exception $e) {
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function iniciar(Request $request)
    {
        $token = session('token');

        if ($token) {
            try {
                $data = [
                    'nrSeqSessao' => [
                        'nrSequence' => $request->input('nrSequence'),
                    ],
                    'nrSeqUsuarioList' => json_decode($request->input('nrSeqUsuarioList'), true),
                ];

                $response = ApiSgvp::withToken($token)->post('/api/sessaoPresente', $data);

                if ($response->successful()) {
                    return redirect()->route('presidente.home');
                } else {
                    $error = $response->json();
                    if (array_key_exists('message', $error)) {
                        return back()->withErrors($error['message']);
                    } else {
                        // Aqui, você pode adicionar código para logar a resposta completa
                        error_log(print_r($error, true));
                        return back()->withErrors('Ocorreu um erro desconhecido. Por favor, verifique os logs para mais detalhes.');
                    }
                }
            } catch (Exception $e) {
                return back()->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente. Erro: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('login');
        }
    }
    
    public function home()
    {
        // Verifique se os dados da sessão estão no cache
        $token = Cache::get('token');
        $nome = Cache::get('nome');
        $partido = Cache::get('partido');
        $perfil = Cache::get('perfil');
        $nrSequence = Cache::get('nrSequence');
        $fotoPerfil = Cache::get('fotoPerfil');

        if (!$token) {
            $token = session('token');
            $nome = session('nome');
            $partido = session('partido');
            $perfil = session('perfil');
            $nrSequence = session('nrSequence');
            $fotoPerfil = session('fotoPerfil');

            // Armazene os dados da sessão no cache para uso futuro
            $expirationTimeInSeconds = 3600; // Tempo de expiração de 1 hora (ajuste conforme necessário)
            Cache::put('token', $token, $expirationTimeInSeconds);
            Cache::put('nome', $nome, $expirationTimeInSeconds);
            Cache::put('partido', $partido, $expirationTimeInSeconds);
            Cache::put('perfil', $perfil, $expirationTimeInSeconds);
            Cache::put('nrSequence', $nrSequence, $expirationTimeInSeconds);
            Cache::put('fotoPerfil', $fotoPerfil, $expirationTimeInSeconds);
        }

        if ($token) {
            try {
                // Utilizando funções privadas otimizadas
                $sessoesAutorizadas = $this->getSessoesAutorizadas($token);
                
                $documentos = $this->getDocumentosExpediente($token, $sessoesAutorizadas);
                $documentosEmVotacao = $this->getDocumentosEmVotacao($token, $sessoesAutorizadas);
                $presidenteVota = $documentos['presidenteVota'] ?? false;
                $roteiros = $this->getRoteiros($token, $sessoesAutorizadas);

                $totalVereadores = $this->getTotalVereadores();
                $totalVereadoresOnline = $this->getTotalVereadoresOnline();

                return view('presidente.home', [
                    'token' => $token,
                    'nome' => $nome,
                    'nrSequence' => $nrSequence,
                    'fotoPerfil' => $fotoPerfil,
                    'partido' => $partido,
                    'sessoes' => $sessoesAutorizadas,
                    'documentos' => $documentos,
                    'documentosEmVotacao' => $documentosEmVotacao,
                    'roteiros' => $roteiros,
                    'totalVereadores' => $totalVereadores,
                    'totalVereadoresOnline' => $totalVereadoresOnline,
                    'presidenteVota' => $presidenteVota,
                ]);
            } catch (Exception $e) {
                Log::error('Erro ao conectar com a API: ' . $e->getMessage());
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function ordemdodia()
    {
        // Verifique se os dados da sessão estão no cache
        $token = Cache::get('token');
        $nome = Cache::get('nome');
        $partido = Cache::get('partido');
        $perfil = Cache::get('perfil');
        $nrSequence = Cache::get('nrSequence');
        $fotoPerfil = Cache::get('fotoPerfil');

        if (!$token) {
            // Se os dados da sessão não estiverem no cache, recupere-os do armazenamento original (por exemplo, banco de dados ou arquivo de sessão)
            $token = session('token');
            $nome = session('nome');
            $partido = session('partido');
            $perfil = session('perfil');
            $nrSequence = session('nrSequence');
            $fotoPerfil = session('fotoPerfil');

            // Armazene os dados da sessão no cache para uso futuro
            $expirationTimeInSeconds = 3600; // Tempo de expiração de 1 hora (ajuste conforme necessário)
            Cache::put('token', $token, $expirationTimeInSeconds);
            Cache::put('nome', $nome, $expirationTimeInSeconds);
            Cache::put('partido', $partido, $expirationTimeInSeconds);
            Cache::put('perfil', $perfil, $expirationTimeInSeconds);
            Cache::put('nrSequence', $nrSequence, $expirationTimeInSeconds);
            Cache::put('fotoPerfil', $fotoPerfil, $expirationTimeInSeconds);
        }

        if ($token) {
            try {
                // Utilizando funções privadas otimizadas
                $sessoesAutorizadas = $this->getSessoesAutorizadas($token);
                
                $documentos = $this->getDocumentosOrdemdoDia($token, $sessoesAutorizadas);
                $documentosEmVotacao = $this->getDocumentosEmVotacao($token, $sessoesAutorizadas);
                $presidenteVota = $documentos['presidenteVota'] ?? false;
                $roteiros = $this->getRoteiros($token, $sessoesAutorizadas);

                $totalVereadores = $this->getTotalVereadores();
                $totalVereadoresOnline = $this->getTotalVereadoresOnline();

                return view('presidente.ordemdodia', [
                    'token' => $token,
                    'nome' => $nome,
                    'nrSequence' => $nrSequence,
                    'fotoPerfil' => $fotoPerfil,
                    'partido' => $partido,
                    'sessoes' => $sessoesAutorizadas,
                    'documentos' => $documentos,
                    'documentosEmVotacao' => $documentosEmVotacao,
                    'roteiros' => $roteiros,
                    'totalVereadores' => $totalVereadores,
                    'totalVereadoresOnline' => $totalVereadoresOnline,
                    'presidenteVota' => $presidenteVota,
                ]);
            } catch (Exception $e) {
                Log::error('Erro ao conectar com a API: ' . $e->getMessage());
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function tribuna()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');
        $nome = session('nome');
        $partido = session('partido');
        $perfil = session('perfil');
        $nrSequence = session('nrSequence');
        $fotoPerfil = session('fotoPerfil');

        if ($token) {
            try {
                $query = 'perfil=PRESIDENTE&perfil=VEREADOR&status=ATIVO&online=TRUE&token!=null';
                $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);
                    
                if ($response->successful()) {
                    $usuarios = $response->json();

                    // Adicione este bloco de código para reorganizar os usuários
                    $inicioIndex = array_search('Início', array_column($usuarios, 'nomeCompleto'));
                    $aparteIndex = array_search('A parte', array_column($usuarios, 'nomeCompleto'));

                    if ($inicioIndex !== false && $aparteIndex !== false) {
                        $inicio = $usuarios[$inicioIndex];
                        $aparte = $usuarios[$aparteIndex];

                        unset($usuarios[$inicioIndex]);
                        unset($usuarios[$aparteIndex]);

                        $usuarios = array_values($usuarios);

                        array_unshift($usuarios, $inicio);
                        array_splice($usuarios, 1, 0, [$aparte]);
                    }

                    $response = ApiSgvp::withToken($token)->get('/sessao');
                        
                    if ($response->successful()) {
                        $sessoes = $response->json();

                        // Filtrar as sessões com status "AUTORIZADA"
                        $sessoesAutorizadas = array_filter($sessoes, function ($sessao) {
                            return $sessao['status'] == 'AUTORIZADA';
                        });

                        // Obter documentos
                        $response = ApiSgvp::withToken($token)->get('/documento');

                        if ($response->successful()) {
                            $documentos = $response->json();

                            // Filtrar os documentos por momento
                            $documentosExpediente = array_filter($documentos, function ($documento) {
                                return $documento['momento'] == 'Expediente';
                            });

                            $documentosOrdemDoDia = array_filter($documentos, function ($documento) {
                                return $documento['momento'] == 'Ordem do dia';
                            });

                            // Adicionar chamada à API para obter o roteiro
                            $response = ApiSgvp::withToken($token)->get('/roteiro', [
                                'statusSessao' => 'AUTORIZADA',
                                'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
                            ]);

                          

                            if ($response->successful()) {
                                $roteiros = $response->json();

                                return view('presidente.tribuna', [
                                    'token' => $token,
                                    'usuarios' => $usuarios,
                                    'nome' => $nome,
                                    'sessoes' => $sessoesAutorizadas,
                                    'nrSequence' => $nrSequence,
                                    'fotoPerfil' => $fotoPerfil,
                                    'partido' => $partido,
                                    'documentosExpediente' => $documentosExpediente,
                                    'documentosOrdemDoDia' => $documentosOrdemDoDia,
                                    'roteiros' => $roteiros
                                ]);
                            }
                        }
                    }
                } else {
                    return redirect()->route('login')->withErrors('Houve um erro ao obter as informações do usuário.');
                }
            } catch (Exception $e) {
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }
    
    // public function PainelVotacao()
    // {
    //     $token = session('token');

    //     if ($token) {
    //         try {
    //             $query = 'perfil=PRESIDENTE&perfil=VEREADOR&status=ATIVO';
    //             $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);
    //             $total_vereadoresOnline = $this->getTotalVereadoresOnline($token);
    //             $sessaoAutorizada = $this->getSessoesAutorizadas($token);
    //             $documentos = $this->getDocumentos($token, $sessaoAutorizada);
    //             $documentosParaVotacao = array_filter($documentos, function ($documento) {
    //                 return $documento['status'] == 'VOTACAO';
    //             });

    //             $statusVoto = $this->getStatusVoto($token, $sessaoAutorizada);

    //             if ($response->successful()) {
    //                 $vereadores = $response->json();
    //                 $total_vereadores = count($vereadores);

    //                 // Ordenar os usuários em ordem alfabética pelo nomeCompleto
    //                 $usuariosOrdenados = collect($statusVoto['usuariosVotos'])->sortBy('nomeCompleto');

    //                 return view('presidente.painel.votacao', [
    //                     'token' => $token,//Passa o token para que seja consumido na view
    //                     'vereadores' => $vereadores, // Passa a lista de todos os vereadores para a view
    //                     'sessaoAutorizada' => $sessaoAutorizada,// Manda para a view a sessãoq que está com status de "AUTORIZADA"
    //                     'documentos' => $documentosParaVotacao,// Pega somente os documentos que estão com o status "EM VOTACAO"
    //                     'statusVoto' => $statusVoto, // Passa todo o status do votos para que seja acompanhado no telão
    //                     'total_vereadores' => $total_vereadores,
    //                     'vereadoresOn' => $total_vereadoresOnline, // Passar os vereadores online para a view
    //                     'usuariosOrdenados' => $usuariosOrdenados, // Passar a variável com os usuários ordenados para a view
    //                 ]);
    //             }
    //         } catch (Exception $e) {
    //             // return redirect()->route('/');
    //         }
    //     } else {
    //         // return redirect()->route('/');
    //     }
    // }

    public function PainelVotacao()
    { 
        $token = session('token'); 

        if ($token) {
            try {
                $query = 'perfil=PRESIDENTE&perfil=VEREADOR&status=ATIVO';
                $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);
                $total_vereadoresOnline = $this->getTotalVereadoresOnline($token);

                $sessaoAutorizada = $this->getSessoesAutorizadas($token);
                $documentos = $this->getDocumentos($token, $sessaoAutorizada);
                $documentosParaVotacao = array_filter($documentos, function ($documento) {
                    return $documento['status'] == 'VOTACAO';
                });

                $statusVoto = $this->getStatusVoto($token, $sessaoAutorizada);

                if ($response->successful()) {
                    $vereadores = $response->json();
                    $total_vereadores = count($vereadores);
                   
                    // Ordenar os usuários em ordem alfabética pelo nomeCompleto
                    $usuariosOrdenados = collect($statusVoto['usuariosVotos'])->sortBy('nomeCompleto');

                    return view('presidente.painel.votacao', [
                        'token' => $token,//Passa o token para que seja consumido na view
                        'vereadores' => $vereadores, // Passa a lista de todos os vereadores para a view
                        'sessaoAutorizada' => $sessaoAutorizada,// Manda para a view a sessãoq que está com status de "AUTORIZADA"
                        'documentos' => $documentosParaVotacao,// Pega somente os documentos que estão com o status "EM VOTACAO"
                        'statusVoto' => $statusVoto, // Passa todo o status do votos para que seja acompanhado no telão
                        'total_vereadores' => $total_vereadores,
                        'vereadoresOn' => $total_vereadoresOnline, // Passar os vereadores online para a view
                        'usuariosOrdenados' => $usuariosOrdenados, // Passar a variável com os usuários ordenados para a view
                    ]);
                }
            } catch (Exception $e) {
                // return redirect()->route('/');
            }
        } else {
            // return redirect()->route('/');
        }
    }

   

    public function encerrarvotacao($nrSequence)
    {
        try {
            // Obter o token da sessão
            $token = session('token');

            // Faz a requisição para a API para obter o documento
            $response = Http::withToken($token)
                ->get('http://154.56.43.108:8080/api/documento?nrSequence=' . $nrSequence);
            
            // Verifica se a requisição foi bem sucedida
            if ($response->successful()) {
                $documento = $response->json();

                // Verifica o status do documento
                if ($documento[0]['status'] === 'ENCERRADO') {
                    // Documento já está encerrado
                    return redirect()->route('presidente.votacao')->with('message', 'O documento já está encerrado.');
                }

                // Faça a chamada da API usando o método PUT e passe o token
                $response = Http::withToken($token)
                    ->put('http://154.56.43.108:8080/api/documento/' . $nrSequence . '/atualiza-status', [
                        'statusDocumento' => 'ENCERRADO'
                    ]);

                // Verifica se a requisição foi bem sucedida
                if ($response->successful()) {
                    return redirect()->route('presidente.votacao')->with('message', 'Votação encerrada com sucesso!');
                } else {
                    // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
                    $errorMsg = $response->json('message') ?? 'Erro ao encerrar a votação. Por favor, tente novamente.';
                    return redirect()->route('presidente.votacao')->with('error', $errorMsg);
                }
            } else {
                // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
                $errorMsg = $response->json('message') ?? 'Erro ao obter o documento. Por favor, tente novamente.';
                return redirect()->route('presidente.votacao')->with('error', $errorMsg);
            }
        } catch (Exception $e) {
            // Trata qualquer exceção que ocorrer na requisição
            return redirect()->route('presidente.votacao')->with('error', 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
        }
    }


    // private function getTotalVereadoresOnline($token)
    // {
    //     $response = ApiSgvp::withToken($token)->get('/usuarios', [
    //         'perfil' => 'VEREADOR, PRESIDENTE',
    //         'statusOnline' => 'true'
    //     ]);
        
    //     if ($response->successful()) {
    //         $vereadoresOnline = $response->json();
    //         // dd($vereadoresOnline);
    //         $contagem = count($vereadoresOnline);
    //         return $contagem;
    //     }
        
    //     throw new Exception('Erro ao obter o total de vereadores online.');
    // }



    private function getTotalVereadoresOnline()
    {
        $response = ApiSgvp::withToken(session('token'))->get('/usuarios', [
            'perfil' => 'VEREADOR, PRESIDENTE',
            'statusOnline' => 'true'
        ]);
        
        if ($response->successful()) {
            return count($response->json());
        }
        throw new Exception('Erro ao obter o total de vereadores online.');
    }

    
    private function getSessoesAutorizadas($token)
    {
        $response = ApiSgvp::withToken($token)->get('/sessao');

        if ($response->successful()) {
            $sessoesAutorizadas = collect($response->json())->filter(function ($sessao) {
                return $sessao['status'] === 'AUTORIZADA';
            })->values()->toArray();

            return $sessoesAutorizadas;
        }

        throw new Exception('Erro ao obter sessões autorizadas.');
    }

    private function getDocumentos($token, $sessoesAutorizadas)
    {
        $response = ApiSgvp::withToken($token)->get('/documento', [
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Erro ao obter documentos.');
    }

    // private function getStatusVoto($token, $documentos)
    // {
    //     $response = ApiSgvp::withToken($token)->get('/voto/statusVotacao', [
    //         'nrDocumento' => implode(',', array_column($documentos, 'nrSequence'))
    //     ]);

    //     if ($response->successful()) {
    //         return $response->json();
    //     }

    //     throw new Exception('Erro ao obter status atual do Voto.');
    // }

    private function getStatusVoto($token, $sessoesAutorizadas)
    {

        // Aqui vai ser um if 
        
        $response = ApiSgvp::withToken($token)->get('/voto/statusVotacao',[
            'sessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence')),
            'statusDocumento' => "VOTACAO",
          
        ]);

      
        if($response->successful()){
            return $response->json();
            dd($response);
          
        }
        else{
            $response = ApiSgvp::withToken($token)->get('/voto/resultadoVotacao',[
                'sessao' =>implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
            ]);
             return $response->json();
            dd($response);
            // dd($response);
        }
        throw new Exception('Erro ao obter status atual do Voto.');
    }

    public function encerrarSessao(Request $request)
    {
        // Obter o token da sessão
        $token = session('token');

        $nrSequence = $request->input('nrSequence');

        $dados_sessao = [
            'dto' => [
                'statusSessao' => 'ENCERRADA'
            ]
        ];

        // Envie a requisição para encerrar a sessão para a API usando o método POST do Laravel HTTP Client
        try {
            $url = "http://154.56.43.108:8080/api/sessao/{$nrSequence}/atualiza-status";
            $response = Http::withToken($token)->post($url, $dados_sessao);

            if ($response->successful()) {
                // Sessão encerrada com sucesso
                return response()->json(['message' => 'Sessão encerrada com sucesso']);
            } else {
                // Erro ao encerrar a sessão. Retorne a resposta da API
                $body = $response->json();
                return response()->json([
                    'httpStatus' => $body['httpStatus'] ?? null,
                    'message' => $body['message'] ?? null
                ], $response->status());
            }
        } catch (Exception $e) {
            // Erro ao se conectar à API
            return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
        }
    }

    // public function preparar($nrSequence)
    // {
    //     try {
    //         // Obter o token da sessão
    //         $token = session('token');
    //         // Faz a requisição para a API para obter o documento
    //         $response = ApiSgvp::withToken($token)->get('http://154.56.43.108:8080/api/documento?nrSequence=' . $nrSequence);

    //         // Verifica se a requisição foi bem sucedida
    //         if ($response->successful()) {
    //             $documento = $response->json();

    //             // Verifica o status do documento
    //             if ($documento[0]['status'] === 'VOTACAO') {
    //                 // Documento já está em votação
    //                 return response()->json(['message' => 'O documento já está em votação.'], 200);
    //             }

    //             // Faça a chamada da API usando o método PUT e passe o token
    //             $response = ApiSgvp::withToken($token)->put('http://154.56.43.108:8080/api/documento/' . $nrSequence . '/atualiza-status', [
    //                 'statusDocumento' => 'VOTACAO'
    //             ]);

    //             // Verifica se a requisição foi bem sucedida
    //             if ($response->successful()) {
    //                 return response()->json(['message' => 'Status do documento atualizado com sucesso!'], 200);
    //             } else {
    //                 // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
    //                 $errorMsg = $response->json('message') ?? 'Erro ao atualizar o status do documento. Por favor, tente novamente.';
    //                 return response()->json(['message' => $errorMsg], 500);
    //             }
    //         } else {
    //             // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
    //             $errorMsg = $response->json('message') ?? 'Erro ao obter o documento. Por favor, tente novamente.';
    //             return response()->json(['message' => $errorMsg], 500);
    //         }
    //     } catch (Exception $e) {
    //         // Trata qualquer exceção que ocorrer na requisição
    //         return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
    //     }
    // }

    public function preparar($nrSequence)
    {
        try {
            // Obter o token da sessão
            $token = session('token');

            // Faz a requisição para a API para obter o documento
            $response = Http::withToken($token)
                ->get('http://154.56.43.108:8080/api/documento?nrSequence=' . $nrSequence);

            // Verifica se a requisição foi bem sucedida
            if ($response->successful()) {
                $documento = $response->json();

                // Verifica o status do documento
                if ($documento[0]['status'] === 'VOTACAO') {
                    // Documento já está em votação
                    return response()->json(['message' => 'O documento já está em votação.'], 200);
                }

                // Faça a chamada da API usando o método PUT e passe o token
                $response = Http::withToken($token)
                    ->put('http://154.56.43.108:8080/api/documento/' . $nrSequence . '/atualiza-status', [
                        'statusDocumento' => 'VOTACAO'
                    ]);

                // Verifica se a requisição foi bem sucedida
                if ($response->successful()) {
                    return response()->json(['message' => 'Status do documento atualizado com sucesso!'], 200);
                } else {
                    // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
                    $errorMsg = $response->json('message') ?? 'Erro ao atualizar o status do documento. Por favor, tente novamente.';
                    return response()->json(['message' => $errorMsg], 500);
                }
            } else {
                // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
                $errorMsg = $response->json('message') ?? 'Erro ao obter o documento. Por favor, tente novamente.';
                return response()->json(['message' => $errorMsg], 500);
            }
        } catch (Exception $e) {
            // Trata qualquer exceção que ocorrer na requisição
            return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
        }
    }

    


    


    public function prepararVotacaoEmBloco(Request $request)
    {
        try {
            $token = session('token');
            $documentos = $request->input('documentos');

            $response = ApiSgvp::withToken($token)->get('http://154.56.43.108:8080/api/documento?nrSequence=' . implode(',', $documentos));
            dd($response);
            if ($response->successful()) {
                $documentosApi = $response->json();

                $documentosEmVotacao = collect($documentosApi)->filter(function ($documento) {
                    return $documento['status'] === 'VOTACAO';
                });

                if ($documentosEmVotacao->count() > 0) {
                    return response()->json(['message' => 'Pelo menos um dos documentos já está em votação.'], 200);
                }

                $response = ApiSgvp::withToken($token)->put('http://154.56.43.108:8080/api/documento/atualiza-status-documentos', [
                    'statusDocumento' => 'VOTACAO',
                    'documentos' => $documentos
                ]);

                if ($response->successful()) {
                    return response()->json(['message' => 'Status dos documentos atualizado com sucesso!'], 200);
                } else {
                    $errorMsg = $response->json('message') ?? 'Erro ao atualizar o status dos documentos. Por favor, tente novamente.';
                    return response()->json(['message' => $errorMsg], 500);
                }
            } else {
                $errorMsg = $response->json('message') ?? 'Erro ao obter os documentos. Por favor, tente novamente.';
                return response()->json(['message' => $errorMsg], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
        }
    }

    public function votacao($nrSequence)
    {
        $token = session('token');
        $nome = session('nome');
        $partido = session('partido');
        $perfil = session('perfil');
        $nrSequenceUsuario = session('nrSequence');
        $fotoPerfil = session('fotoPerfil');

        if (!$token) {
            return redirect()->route('login');
        }

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "http://154.56.43.108:8080/api/voto/statusVotacao?nrDocumento=$nrSequence", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
            $statusVotacao = json_decode($response->getBody(), true);

            $usuarios = $this->getUsuarios($token);
            $sessoesAutorizadas = $this->getSessoesAutorizadas($token);
            $roteiros = $this->getRoteiros($token, $sessoesAutorizadas);
            $totalVereadores = $this->getTotalVereadores($token);
            $totalVereadoresOnline = $this->getTotalVereadoresOnline($token);

            return view('presidente.votacao', [
                'token' => $token,
                'usuarios' => $usuarios,
                'nome' => $nome,
                'nrSequence' => $nrSequenceUsuario,
                'fotoPerfil' => $fotoPerfil,
                'partido' => $partido,
                'sessoes' => $sessoesAutorizadas,
                'roteiros' => $roteiros,
                'totalVereadores' => $totalVereadores,
                'totalVereadoresOnline' => $totalVereadoresOnline,
                'statusVotacao' => $statusVotacao,
            ]);
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
        }
    }

    public function sendVote(Request $request)
    {
        // Obter o token da sessão
        $token = session('token');

        $dados_voto = [
            'usuarioVoto' => [
                'nrSequence' => $request->input('usuarioVoto.nrSequence'),
            ],
            'documento' => [
                'nrSequence' => $request->input('documento.nrSequence'),
            ],
            'voto' => $request->input('voto'),
        ];

        // Envie a votação para a API usando o método POST do Laravel HTTP Client
        try {
            $response = ApiSgvp::withToken($token)->post('/voto', $dados_voto);

            if ($response->successful()) {
                // Votação enviada com sucesso
                return response()->json(['message' => 'Votação enviada com sucesso']);
            } else {
                // Erro ao enviar a votação. Retorne a resposta da API
                $body = $response->json();
                return response()->json([
                    'httpStatus' => $body['httpStatus'] ?? null,
                    'message' => $body['message'] ?? null
                ], $response->status());
            }
        } catch (Exception $e) {
            // Erro ao se conectar à API
            return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
        }
    }

    public function sendBulkVote(Request $request)
    {
        // Obtenha os dados da solicitação
        $dadosVoto = $request->all();
        
        // Faça a validação dos dados, se necessário

        // Envie a votação em bloco para o endpoint da API
        try {
            $response = ApiSgvp::withToken($token)->post('/voto/votoBloco', $dadosVoto);

            if ($response->successful()) {
                // Votação em bloco enviada com sucesso
                return response()->json(['message' => 'Votação em bloco enviada com sucesso']);
            } else {
                // Erro ao enviar a votação em bloco
                $error = $response->json(); // Obtém os detalhes do erro da resposta da API
                return response()->json(['message' => $error['message']], $response->status());
            }
        } catch (Exception $e) {
            // Erro ao se conectar à API
            return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
        }
    }

    private function getUsuarios($token)
    {
        $response = ApiSgvp::withToken($token)->get('/usuarios');
        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception('Houve um erro ao obter as informações do usuário.');
    }

    // private function getSessoesAutorizadas($token)
    // {
    //     $response = ApiSgvp::withToken($token)->get('/sessao');
    //     if ($response->successful()) {
    //         $sessoesAutorizadas = collect($response->json())->filter(function ($sessao) {
    //             return $sessao['status'] === 'AUTORIZADA';
    //         })->values()->toArray();

    //         return $sessoesAutorizadas;
    //     }
    //     throw new Exception('Erro ao obter sessões autorizadas.');
    // }

    // private function getDocumentos($token, $sessoesAutorizadas)
    // {
    //     $response = ApiSgvp::withToken($token)->get('/documento', [
    //         'momento' => 'Ordem do dia',
    //         'statusSessao' => 'AUTORIZADA',
    //         'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
    //     ]);
    //     if ($response->successful()) {
    //         return $response->json();
    //     }
    //     throw new Exception('Erro ao obter documentos.');
    // }
    
    private function getDocumentosEmVotacao($token, $sessoesAutorizadas)
    {
        // Certifique-se de que $sessoesAutorizadas seja um array
        if (!is_array($sessoesAutorizadas)) {
            $sessoesAutorizadas = json_decode($sessoesAutorizadas, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Argumento $sessoesAutorizadas deve ser um array válido ou uma string JSON válida.');
            }
        }

        // Faça a solicitação
        $response = ApiSgvp::withToken($token)->get('/documento', [
            'status' => 'VOTACAO',
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);

        if ($response->successful()) {
            $documentos = $response->json();
            return array_column($documentos, 'nrSequence');
        }

        throw new Exception('Erro ao obter documentos em votação.');
    }

    // private function getStatusVotos($token, $nrDocumento)
    // {
    //     $response = ApiSgvp::withToken($token)->get('/voto/statusVotacao', ['nrDocumento' => $nrDocumento]);
    //     if ($response->successful()) {
    //         return $response->json();
    //     }
    //     return null;
    // }

    


    private function getRoteiros($token, $sessoesAutorizadas)
    {
        $sessoesAutorizadas = is_string($sessoesAutorizadas) ? json_decode($sessoesAutorizadas, true) : $sessoesAutorizadas;

        if (!is_array($sessoesAutorizadas)) {
            throw new Exception('Argumento $sessoesAutorizadas deve ser um array válido ou uma string JSON válida.');
        }

        $response = ApiSgvp::withToken($token)->get('/roteiro', [
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);
        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception('Erro ao obter roteiros.');
    }

    private function getTotalVereadores()
    {
        $response = ApiSgvp::withToken(session('token'))->get('/usuarios', [
            'perfil' => 'VEREADOR',
            'status' => 'ATIVO'
        ]);
        if ($response->successful()) {
            return count($response->json());
        }
        throw new Exception('Erro ao obter o total de vereadores.');
    }

    

    private function getDocumentosExpediente($token, $sessoesAutorizadas)
    {
        if (!is_array($sessoesAutorizadas)) {
            $decodedSessoesAutorizadas = json_decode($sessoesAutorizadas, true);
            if (is_array($decodedSessoesAutorizadas)) {
                $sessoesAutorizadas = $decodedSessoesAutorizadas;
            } else {
                throw new \InvalidArgumentException('Argumento $sessoesAutorizadas deve ser um array válido ou uma string JSON válida.');
            }
        }

        $nrSequences = array_column($sessoesAutorizadas, 'nrSequence');

        $response = ApiSgvp::withToken($token)->get('/documento', [
            'momento' => 'Expediente',
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', $nrSequences)
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao obter documentos do expediente.');
    }

    private function getDocumentosOrdemdoDia($token, $sessoesAutorizadas)
    {
        if (!is_array($sessoesAutorizadas)) {
            $decodedSessoesAutorizadas = json_decode($sessoesAutorizadas, true);
            if (is_array($decodedSessoesAutorizadas)) {
                $sessoesAutorizadas = $decodedSessoesAutorizadas;
            } else {
                throw new \InvalidArgumentException('Argumento $sessoesAutorizadas deve ser um array válido ou uma string JSON válida.');
            }
        }

        $nrSequences = array_column($sessoesAutorizadas, 'nrSequence');

        $response = ApiSgvp::withToken($token)->get('/documento', [
            'momento' => 'Ordem do dia',
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', $nrSequences)
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao obter documentos do Ordem do Dia.');
    }

}