<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ApiSgvp;

class VereadorController extends Controller 
{

    public function index()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');
        $nome = session('nome');
        $partido = session('partido');
        $perfil = session('perfil');
        $nrSequence = session('nrSequence');
        $fotoPerfil = session('fotoPerfil');

        // if ($token) {
        //     try {
        //         // Utilizando funções privadas
        //         $sessoesAutorizadas = $this->getSessoesAutorizadas($token);
        //         $documentos = $this->getDocumentosExpediente($token, $sessoesAutorizadas);

        //         $roteiros = $this->getRoteiros($token, $sessoesAutorizadas);

        //         return view('vereador.index', [
        //             'token' => $token,
        //             'nome' => $nome,
        //             'nrSequence' => $nrSequence,
        //             'fotoPerfil' => $fotoPerfil,
        //             'partido' => $partido,
        //             'sessoes' => $sessoesAutorizadas,
        //             'documentos' => $documentos,
        //             'roteiros' => $roteiros,
        //         ]);
        //     } catch (Exception $e) {
        //         return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
        //     }
        // } else {
        //     return redirect()->route('login');
        // }

        if ($token) {
            try {
                // Utilizando funções privadas
                $sessoesAutorizadas = $this->getSessoesAutorizadas($token);
                $documentos = $this->getDocumentosExpediente($token, $sessoesAutorizadas);
        
                // Ordenar os documentos pelo campo 'momento'
                usort($documentos, function ($a, $b) {
                    return strcmp($a['momento'], $b['momento']);
                });
        
                $roteiros = $this->getRoteiros($token, $sessoesAutorizadas);
        
                return view('vereador.index', [
                    'token' => $token,
                    'nome' => $nome,
                    'nrSequence' => $nrSequence,
                    'fotoPerfil' => $fotoPerfil,
                    'partido' => $partido,
                    'sessoes' => $sessoesAutorizadas,
                    'documentos' => $documentos,
                    'roteiros' => $roteiros,
                ]);
            } catch (Exception $e) {
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            return redirect()->route('login');
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

    public function verificarDocumentoVotacao()
{
    try {
        // Obter o token da sessão
        $token = session('token');

        // Faz a requisição para a API para obter os documentos
        $response = ApiSgvp::withToken($token)->get('https://sgvp-backend-api.herokuapp.com/api/documento');

        // Verifica se a requisição foi bem sucedida
        if ($response->successful()) {
            $documentos = $response->json();

            // Filtra os documentos em votação
            $documentosVotacao = array_filter($documentos, function ($documento) {
                return $documento['status'] === 'VOTACAO';
            });

            // Verifica se há algum documento em votação
            if (count($documentosVotacao) > 0) {
                // Retorna o primeiro documento em votação encontrado
                return response()->json(['documento' => $documentosVotacao[0]], 200);
            } else {
                // Nenhum documento em votação encontrado
                return response()->json(['message' => 'Nenhum documento em votação encontrado.'], 200);
            }
        } else {
            // Retorna a mensagem de erro da API, se disponível, ou uma mensagem de erro padrão
            $errorMsg = $response->json('message') ?? 'Erro ao obter os documentos. Por favor, tente novamente.';
            return response()->json(['message' => $errorMsg], $response->status());
        }
    } catch (Exception $e) {
        // Trata qualquer exceção que ocorrer na requisição
        return response()->json(['message' => 'Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.'], 500);
    }
}





    public function inscreverTribuna(Request $request)
    {
        // Obtenha os dados do usuário
        $nrSeqSessao = $request->input('nrSeqSessao');
        $nrSeqUsuarioTribuna = $request->input('nrSeqUsuarioTribuna');

        // Formate os dados para a requisição
        $dados = [
            'tribuna' => 'SIM',
            'nrSeqSessao' => [
                'nrSequence' => $nrSeqSessao
            ],
            'nrSeqUsuarioTribuna' => [
                'nrSequence' => $nrSeqUsuarioTribuna
            ]
        ];

        try {
            $response = ApiSgvp::withToken($token)->post('https://sgvp-backend-api.herokuapp.com/api/tempoTribuna', $dados);

            if ($response->successful()) {
                return response()->json(['message' => 'Inscrição realizada com sucesso!'], 200);
            } else {
                return response()->json(['message' => 'Houve um problema ao realizar a inscrição.'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['message' => 'Houve um erro ao realizar a inscrição.'], 500);
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

    private function getSessoesAutorizadas($token)
    {
        $response = ApiSgvp::withToken($token)->get('/sessao');
        if ($response->successful()) {
            $sessoes = $response->json();
            return array_filter($sessoes, function ($sessao) {
                return $sessao['status'] == 'AUTORIZADA';
            });
        }
        throw new Exception('Erro ao obter as sessões autorizadas.');
    }

    private function getDocumentos($token, $sessoesAutorizadas)
    {
        $response = ApiSgvp::withToken($token)->get('/documento', [
            'momento' => 'Ordem do dia',
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);
        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception('Erro ao obter documentos.');
    }

    private function getStatusVotos($token, $documentos)
    {
        $statusVotos = [];
        foreach ($documentos as $documento) {
            $response = ApiSgvp::withToken($token)->get('/voto/statusVotacao', ['nrDocumento' => $documento['nrSequence']]);
            if ($response->successful()) {
                $statusVotos[$documento['nrSequence']] = $response->json();
            }
        }
        return $statusVotos;
    }

    private function getRoteiros($token, $sessoesAutorizadas)
    {
        $response = ApiSgvp::withToken($token)->get('/roteiro', [
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);
        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception('Erro ao obter roteiros.');
    }

    private function getTotalVereadores($token)
    {
        $response = ApiSgvp::withToken($token)->get('/usuarios', [
            'perfil' => 'VEREADOR',
            'status' => 'ATIVO'
        ]);
        if ($response->successful()) {
            return count($response->json());
        }
        throw new Exception('Erro ao obter o total de vereadores.');
    }

    private function getTotalVereadoresOnline($token)
    {
        $response = ApiSgvp::withToken($token)->get('/usuarios', [
            'perfil' => 'VEREADOR',
            'statusOnline' => 'true',
            'status' => 'ATIVO'
        ]);
        if ($response->successful()) {
            return count($response->json());
        }
        throw new Exception('Erro ao obter o total de vereadores online.');
    }

    private function getDocumentosExpediente($token, $sessoesAutorizadas)
    {
        $response = ApiSgvp::withToken($token)->get('/documento', [
            // 'momento' => 'Expediente',
            'statusSessao' => 'AUTORIZADA',
            'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    
}
