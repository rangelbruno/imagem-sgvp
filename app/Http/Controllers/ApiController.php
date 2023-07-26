<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Facades\ApiSgvp;
use Illuminate\Support\Facades\Auth;
use App\Events\ModalVota;


class ApiController extends Controller
{
    public function index()
    {
       return ApiSgvp::get('/usuarios/autenticar')->json();
    }

    // public function autenticar(Request $request)
    // {
    //     $cpf = $request->input('cpf');
    //     $senha = $request->input('senha');

    //     if (empty($cpf) || empty($senha)) {
    //         return redirect()->route('login')->withErrors('CPF e senha são obrigatórios.');
    //     }

    //     try {
    //         $response = ApiSgvp::post('/usuarios/autenticar', [
    //             'cpf' => $cpf,
    //             'senha' => $senha,
    //         ]);

    //         if ($response->successful()) {
    //             $token = $response->json()['token'];
    //             $nome = $response->json()['nome'];
    //             $perfil = $response->json()['perfil'];
    //             $nrSequence = $response->json()['nrSequence']; // Adicione esta linha

    //             if ($token) {
    //                 session([
    //                     'token' => $token,
    //                     'nome' => $nome,
    //                     'perfil' => $perfil,
    //                     'nrSequence' => $nrSequence, // Adicione esta linha
    //                 ]);

    //                 // Adicione a verificação de perfil aqui
    //                 switch ($perfil) {
    //                     case 'PRESIDENTE':
    //                         return redirect()->route('presidente.index');
    //                     case 'VEREADOR':
    //                         return redirect()->route('vereador.index');
    //                     case 'ADMINISTRADOR':
    //                         return redirect()->route('admin.home');
    //                     default:
    //                         return redirect()->route('admin.home');
    //                 }

    //             } else {
    //                 return redirect()->route('login')->withErrors('Não foi possível autenticar o usuário.');
    //             }
    //         } else {
    //             if ($response->serverError()) {
    //                 return redirect()->route('login')->withErrors('Houve um erro de conexão com a API.');
    //             }

    //             if ($response->status() === 401 || $response->status() === 422) {
    //                 $responseJson = $response->json();
    //                 $errorMessage = is_array($responseJson) && isset($responseJson['message']) ? $responseJson['message'] : 'Erro ao autenticar o usuário.';
    //                 return redirect()->route('login')->withErrors($errorMessage);
    //             }

    //             return redirect()->route('login')->withErrors('Usuario não cadastrado.');
    //         }
    //     } catch (Exception $e) {
    //         return redirect()->route('login')->withErrors('Token expirado: seu token de autenticação expirou e você precisa fazer login novamente para continuar usando o sistema.');
    //     }
    // }


    public function autenticar(Request $request)
    {
        $cpf = $request->input('cpf');
        $senha = $request->input('senha');

        if (empty($cpf) || empty($senha)) {
            return redirect()->route('login')->withErrors('CPF e senha são obrigatórios.');
        }

        try {
            $response = ApiSgvp::post('/usuarios/autenticar', [
                'cpf' => $cpf,
                'senha' => $senha,
            ]);

            if ($response->successful()) {
                $token = $response->json()['token'];
                $nome = $response->json()['nome'];
                $perfil = $response->json()['perfil'];
                $nrSequence = $response->json()['nrSequence'];
                $partido = $response->json()['partido'];
                $fotoPerfil = $response->json()['fotoPerfil'];

                if ($token) {
                    // Regenerate session ID after successful login
                    $request->session()->regenerate();

                    session([
                        'token' => $token,
                        'nome' => $nome,
                        'perfil' => $perfil,
                        'nrSequence' => $nrSequence,
                        'partido' => $partido,
                        'fotoPerfil' => $fotoPerfil,
                    ]);

                    // Redireciona com base no perfil
                    switch ($perfil) {
                        case 'PRESIDENTE':
                            return redirect()->route('presidente.index');
                        case 'VEREADOR':
                            return redirect()->route('vereador.index');
                        case 'ADMINISTRADOR':
                            return redirect()->route('admin.home');
                        default:
                            return redirect()->route('admin.home');
                    }

                } else {
                    return redirect()->route('login')->withErrors('Não foi possível autenticar o usuário.');
                }
            } else {
                // Se o servidor retornar um erro (por exemplo, erro 500)
                if ($response->serverError()) {
                    $errorMessage = 'Houve um erro de conexão com a API.';
                    // Se a API retorna uma mensagem de erro específica, usá-la.
                    if (isset($response->json()['message'])) {
                        $errorMessage = $response->json()['message'];
                    }
                    return redirect()->route('login')->withErrors($errorMessage);
                }

                // Se o servidor retornar um erro de autenticação (por exemplo, erro 401 ou 422)
                if ($response->status() === 401 || $response->status() === 422) {
                    $errorMessage = 'Erro ao autenticar o usuário.';
                    // Se a API retorna uma mensagem de erro específica, usá-la.
                    if (isset($response->json()['message'])) {
                        $errorMessage = $response->json()['message'];
                    }
                    return redirect()->route('login')->withErrors($errorMessage);
                }

                return redirect()->route('login')->withErrors('Usuario não cadastrado.');
            }
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors('Token expirado: seu token de autenticação expirou e você precisa fazer login novamente para continuar usando o sistema.');
        }
    }
    
    





    public function logout(Request $request)
    {
        // Obter o número de sequência do usuário logado.
        $nrSequence = session('nrSequence');
        $token = session('token'); // Obter o token da sessão

        if ($nrSequence) {
            try {
                // Incluir o token e fazer uma chamada para a API de logout com o método POST e nrSequence na URL
                $response = ApiSgvp::withToken($token)->post('/usuarios/logout?nrSequence=' . $nrSequence);
                // dd($response);
                // Verificar se a resposta foi bem-sucedida
                if ($response->successful()) {
                    // Limpar os dados da sessão do usuário
                    $request->session()->flush();

                    // Redirecionar o usuário para a página de login
                    return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
                } else {
                    // Redirecionar o usuário para a página inicial com um erro
                    return redirect()->route('admin.home')->withErrors('Não foi possível realizar o logout, tente novamente.');
                }
            } catch (Exception $e) {
                return redirect()->route('admin.home')->withErrors('Ocorreu um erro ao tentar realizar o logout, tente novamente.');
            }
        } else {
            // Redirecionar o usuário para a página de login caso o nrSequence não seja encontrado
            return redirect()->route('login')->withErrors('Ocorreu um erro ao tentar realizar o logout, tente novamente.');
        }
    }

    // public function registrarVoto(Request $request)
    // {
    //     $documentoId = $request->input('documentoId');
    //     $voto = $request->input('voto');
    //     $token = session('token'); // Obter o token da sessão
    //     $nrSequence = session('nrSequence'); // Obter o número de sequência do usuário logado

    //     // Validar os inputs
    //     if (empty($documentoId) || empty($voto)) {
    //         return response()->json(['message' => 'DocumentoId e voto são necessários.'], 400);
    //     }

    //     // Enviar a requisição para a API
    //     try {
    //         $response = ApiSgvp::withToken($token)->post('/api/voto', [
    //             'dto' => [
    //                 'usuarioVoto' => [
    //                     'nrSequence' => $nrSequence,
    //                 ],
    //                 'documento' => [
    //                     'nrSequence' => $documentoId,
    //                 ],
    //                 'voto' => $voto,
    //             ]
    //         ]);

    //         // Verificar se a resposta foi bem-sucedida
    //         if ($response->successful()) {
    //             event(new ModalVota(['message' => 'Voto registrado com sucesso!', 'titulo' => 'Votação']));
    //             return response()->json(['message' => 'Voto registrado com sucesso!']);
    //         } else {
    //             return response()->json(['message' => 'Houve um erro ao registrar o voto.'], 500);
    //         }
    //     } catch (Exception $e) {
    //         return response()->json(['message' => 'Houve um erro ao registrar o voto.'], 500);
    //     }
    // }

}
