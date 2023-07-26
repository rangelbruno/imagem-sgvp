<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ApiSgvp;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;



use Illuminate\Http\Client\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Client\HttpClientException;

class SessaoController extends Controller
{

    public function index()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/sessao');

                if ($response->successful()) {
                    $sessoes = $response->json();
                    return view('sessao.index', [
                        'token' => $token,
                        'sessoes' => $sessoes
                    ]);
                } else {
                    return redirect()->route('login')->withErrors('Houve um erro ao obter as informações da sessão.');
                }
            } catch (Exception $e) {
                return redirect()->route('login')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function show()
    {
       // Obtenha o token de acesso armazenado na sessão
       $token = session('token');

       if ($token) {
           try {
               $response = ApiSgvp::withToken($token)->get('/sessao');

               if ($response->successful()) {
                   $usuario = $response->json();
                   return view('sessao.cadastrar', [
                       'token' => $token
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dto.nomeSessao' => 'required',
            'dto.tipoSessao' => 'required'
        ]);

        if ($validator->fails()) {
            
            return redirect()->route('sessao.cadastrar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');
        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = Http::withToken($token) 
                ->withHeaders(['Accept' => 'application/json'])
                ->post('https://sgvp-backend-api.herokuapp.com/api/sessao', $dados_formulario);
            // dd($dados_formulario);
            if ($response->successful()) {
                // Redirecione para a lista de sessão com uma mensagem de sucesso
                return redirect()->route('sessao.index')->with('mensagem', 'Sessão cadastrada com sucesso!');
            } else {
                // Redirecione para o formulário de cadastro com uma mensagem de erro
                return redirect()->route('sessao.cadastrar')->withErrors(['erro' => 'Houve um erro ao cadastrar a sessão.']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de cadastro com uma mensagem de erro
            return redirect()->route('sessao.cadastrar')->withErrors(['erro' => 'Houve um erro ao cadastrar a sessão.']);
        }
    }

    public function edit($nrSequence) 
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');
 
        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                if ($response->successful()) {
                    $sessao = $response->json();
                    return view('sessao.editar', compact('sessao', 'token'));
                } else {
                    return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações da sessão.');
                }
            } catch (Exception $e) {
                return redirect()->route('sessao.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function update(Request $request, $nrSequence)
    {
        $validator = Validator::make($request->all(), [
            'dto.nomeSessao' => 'required',
            'dto.tipoSessao' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/sessao/'. $nrSequence.'/editar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = ApiSgvp::withToken($token)->put('/sessao/'. $nrSequence, $dados_formulario);

            if ($response->successful()) {
                return redirect('/sessao/'. $nrSequence .'/editar')->with('mensagem', 'Sessão atualizada com sucesso!');
            } else {
                // Redirecione para o formulário de edição com uma mensagem de erro
                $api_error_message = $response->json('message', 'Não foi possível atualizar a sessão!');
                return redirect('/sessao/'. $nrSequence .'/editar')->withErrors(['erro' => $api_error_message]);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de edição com uma mensagem de erro
            return redirect('/sessao/'. $nrSequence .'/editar')->withErrors(['erro' => 'Houve um erro ao atualizar a sessão.']);
        }
    }
 

    public function desativarSessao(Request $request, $nrSequence)
    {
        $validator = Validator::make($request->all(), [
            'dto.statusSessao' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/sessao/'. $nrSequence.'/atualiza-status')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = ApiSgvp::withToken($token)->put('/sessao/'. $nrSequence, $dados_formulario);

            if ($response->successful()) {
                return redirect('/sessao/'. $nrSequence .'/atualiza-status')->with('mensagem', 'Status da Sessão atualizada com sucesso!');
            } else {
                // Redirecione para o formulário de edição com uma mensagem de erro
                return redirect('/sessao/'. $nrSequence .'/atualiza-status')->withErrors(['erro' => 'Não foi possível atualizar o status da sessão!']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de edição com uma mensagem de erro
            return redirect('/sessao/'. $nrSequence .'/atualiza-status')->withErrors(['erro' => 'Houve um erro ao atualizar status da sessão.']);
        }
    }

    public function gerenciar($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                if ($response->successful()) {
                    $sessao = $response->json();
                    
                    $response = ApiSgvp::withToken($token)->get('/documento?nrSeqSessao='.$nrSequence);
                    
                    if ($response->successful()) {
                        $documentos = $response->json();

                        $response = ApiSgvp::withToken($token)->get('/roteiro?nrSeqSessao='.$nrSequence);
                        
                        if ($response->successful()) { 
                            $roteiro = $response->json();

                        return view('sessao.gerenciar.index', compact('sessao', 'token', 'documentos', 'roteiro'));
                        }
                    } else {
                        return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações dos documentos.');
                    }
                } else {
                    return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações da sessão.');
                }
            } catch (Exception $e) {
                return redirect()->route('sessao.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function editdocumentos($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token && is_string($token)) {
            try {
                // Busque as informações do documento a ser editado
                $response = ApiSgvp::withToken($token)->get('/documento?nrSequence='.$nrSequence);
                if ($response->successful()) {
                    $documentos = $response->json();
                    // Busque as informações da sessão
                    $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                    
                    if ($response->successful()) {
                        $sessao = $response->json();
                        // Busque os perfis de usuários para o dropdown
                        $response = ApiSgvp::withToken($token)->get('/usuarios/buscaNomesPerfil?perfil=PRESIDENTE&perfil=VEREADOR&perfil=PREFEITO');
                        
                        if ($response->successful()) {
                            
                            $perfil = $response->json();
                           
                            $nomesUsuarios = $perfil;
                            
                            return view('sessao.gerenciar.editar', compact('sessao', 'token', 'documentos', 'nomesUsuarios'));
                        } else {
                            return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações dos perfis de usuários.');
                        }
                    } else {
                        return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações da sessão.');
                    }
                } else {
                    return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações do documento.');
                }
            } catch (Exception $e) {
                return redirect()->route('sessao.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    


    public function atualizarDocumento(Request $request, $nrSequence)
    {
        $validator = Validator::make($request->all(), [
            'dto.titulo' => 'required',
            'dto.autor' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/documentos/' . $nrSequence . '/editar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');
        
        $dados_formulario['autor'] = $request->input('dto.autor');

        $token = $request->session()->get('token');
        if (isset($dados_formulario['docLeitura'])) {
            $dados_formulario['docLeitura'] = filter_var($dados_formulario['docLeitura'], FILTER_VALIDATE_BOOLEAN);
        }
        if (isset($dados_formulario['docVota'])) {
            $dados_formulario['docVota'] = filter_var($dados_formulario['docVota'], FILTER_VALIDATE_BOOLEAN);
        }
        if (isset($dados_formulario['presidenteVota'])) {
            $dados_formulario['presidenteVota'] = filter_var($dados_formulario['presidenteVota'], FILTER_VALIDATE_BOOLEAN);
        }
        if ($request->hasFile('dto.pdf')) {
            $pdf = $request->file('dto.pdf');
            $caminho_pdf = $pdf->store('uploads', 'uploads');
            $dados_formulario['pdf'] = $caminho_pdf;
        }

        try {
            $response = ApiSgvp::withToken($token)->put('/documento/' . $nrSequence, $dados_formulario);

            if ($response->successful()) {
                return redirect('/documentos/' . $nrSequence . '/editar')->with('mensagem', 'Documento atualizado com sucesso!');
            } else {
                try {
                    $error = json_decode($response->body(), true);
                    $errorMessage = $error['message'] ?? 'Não foi possível atualizar o documento!';
                } catch (\Throwable $th) {
                    // Tratando erro na decodificação do JSON
                    $errorMessage = 'Erro ao decodificar a resposta da API: ' . $th->getMessage();
                }
                return redirect('/documentos/' . $nrSequence . '/editar')->withErrors(['erro' => $errorMessage]);
            }
        } catch (Exception $e) {
            // Tratando erro na chamada da API
            return redirect('/documentos/' . $nrSequence . '/editar')->withErrors(['erro' => 'Erro ao chamar a API: ' . $e->getMessage()]);
        }
    }

    


 
    

    




    


    public function caddocumentos($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                
                if ($response->successful()) {
                    $sessao = $response->json();
                    
                    $response = ApiSgvp::withToken($token)->get('/documento?nrSeqSessao='.$nrSequence);
                                
                    if ($response->successful()) {
                        $documentos = $response->json();
                        
                        $response = ApiSgvp::withToken($token)->get('/usuarios/buscaNomesPerfil?perfil=PRESIDENTE&perfil=VEREADOR&perfil=PREFEITO');
                        
                        if ($response->successful()) {
                            $perfil = $response->json();
                            $nomesUsuarios = [];
                            foreach ($perfil as $usuario) {
                                $nomesUsuarios[] = $usuario;
                            }
                            
                            return view('sessao.gerenciar.cadastrar', compact('sessao', 'token', 'nomesUsuarios'));
                        } else {
                            return redirect()->route('sessao.documento.cadastrar')->withErrors('Houve um erro ao obter as informações dos usuários.');
                        }
                    } else {
                        return redirect()->route('sessao.documento.cadastrar')->withErrors('Houve um erro ao obter as informações dos documentos.');
                    }
                } else {
                    return redirect()->route('sessao.documento.cadastrar')->withErrors('Houve um erro ao obter as informações da sessão.');
                }
            } catch (Exception $e) {
                return redirect()->route('sessao.documento.cadastrar')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    // public function cadastrarDocumentos(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'dto.titulo' => 'required',
    //         'dto.autor' => 'required',
    //         'dto.votacao' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('documento.cadastrar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $dados_formulario = $request->input('dto');

    //     // Adicione os dados da sessão ao formulário
    //     $dados_formulario['nrSeqSessao'] = [
    //         'nrSequence' => $request->input('nrSeqSessao.nrSequence'),
    //     ];

    //     if ($request->hasFile('dto.pdf')) {
    //         $pdf = $request->file('dto.pdf');

    //         // salva o PDF na pasta de uploads e obtém o caminho do PDF salvo
    //         $caminho_pdf = $pdf->store('uploads', 'uploads');

    //         // adiciona o caminho do PDF aos dados do formulário
    //         $dados_formulario['pdf'] = $caminho_pdf;
    //     }

    //     // Obtém o valor selecionado do campo votacao
    //     $dados_formulario['votacao'] = $request->input('dto.votacao');

    //     // Obtém o token de autenticação do usuário atual
    //     $token = $request->session()->get('token');

    //     // Envie os dados para a API
    //     try {
    //         $response = ApiSgvp::withToken($token)->post('/documento', $dados_formulario);

    //         if ($response->successful()) {
    //             // Redirecione para a lista de documentos com uma mensagem de sucesso
    //             return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->with('mensagem', 'Documento cadastrado com sucesso!');
    //         } else {
    //             // Redirecione para o formulário de cadastro com uma mensagem de erro
    //             return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Não foi possível cadastrar o documento.']);
    //         }
    //     } catch (Exception $e) {
    //         // Redirecione para o formulário de cadastro com uma mensagem de erro
    //         return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Houve um erro ao cadastrar o documento.']);
    //     }
    // }

    public function cadastrarDocumentos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dto.titulo' => 'required',
            'dto.autor' => 'required',
            'dto.votacao' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('documento.cadastrar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');

        // Adicione os dados da sessão ao formulário
        $dados_formulario['nrSeqSessao'] = [
            'nrSequence' => $request->input('nrSeqSessao.nrSequence'),
        ];

        if ($request->hasFile('dto.pdf')) {
            $pdf = $request->file('dto.pdf');

            // salva o PDF na pasta de uploads e obtém o caminho do PDF salvo
            $caminho_pdf = $pdf->store('uploads', 'uploads');

            // adiciona o caminho do PDF aos dados do formulário
            $dados_formulario['pdf'] = $caminho_pdf;
        }

        // Obtém o valor selecionado do campo votacao
        $dados_formulario['votacao'] = $request->input('dto.votacao');

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = ApiSgvp::withToken($token)->post('/documento', $dados_formulario);

            if ($response->successful()) {
                // Redirecione para a lista de documentos com uma mensagem de sucesso
                return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->with('mensagem', 'Documento cadastrado com sucesso!');
            } else {
                // Redirecione para o formulário de cadastro com uma mensagem de erro
                return redirect()->route('documento.cadastrar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Não foi possível cadastrar o documento.'])->withInput();
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de cadastro com uma mensagem de erro
            return redirect()->route('documento.cadastrar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Houve um erro ao cadastrar o documento.'])->withInput();
        }
    }

    

    private function getDadosFormulario(Request $request)
    {
        $dados_formulario = $request->input('dto');
       
        $dados_formulario['nrSeqSessao'] = [
            'nrSequence' => $request->input('nrSeqSessao.nrSequence'),
        ];
    
        if ($request->hasFile('dto.pdf')) {
            $dados_formulario['pdf'] = $this->handlePDF($request);
        }
    
        return $dados_formulario;
    }
    
    private function handlePDF(Request $request)
    {
        $pdf = $request->file('dto.pdf');
        return $pdf->store('uploads', 'uploads');
    }
    
    private function redirectWithErrors($sequence, $errors)
    {
        return redirect()->route('documento.cadastrar', ['nrSequence' => $sequence])
            ->withErrors($errors)
            ->withInput();
    }
    
    private function postDocumentos($dados_formulario, $sequence)
    {
        $token = request()->session()->get('token');
        $response = ApiSgvp::withToken($token)->post('/documento', $dados_formulario);
    
        if ($response->successful()) {
            return redirect()->route('sessao.gerenciar', ['nrSequence' => $sequence])->with('mensagem', 'Documento cadastrado com sucesso!');
        }
    
        return redirect()->route('sessao.gerenciar', ['nrSequence' => $sequence])->withErrors(['erro' => 'Não foi possível cadastrar o documento.']);
    }

    // public function excluirDocumento(Request $request, $nrSequence)
    // {
    //     // Obtém o token de autenticação do usuário atual
    //     $token = $request->session()->get('token');
        
    //     try {
    //         // Envia uma solicitação DELETE para a API para excluir o documento com o número de sequência especificado
    //         $response = ApiSgvp::withToken($token)->delete('/documento/'. $nrSequence);
            
    //         if ($response->successful()) {
    //             // Redireciona para a lista de documentos com uma mensagem de sucesso
    //             return redirect()->route('sessao.index')->with('mensagem', 'Documento excluído com sucesso!');
    //         } else {
    //             // Redireciona para a lista de documentos com uma mensagem de erro
    //             return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Não foi possível excluir o documento.']);
    //         }
    //     } catch (Exception $e) {
    //         // Redireciona para a lista de documentos com uma mensagem de erro
    //         return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Houve um erro ao excluir o documento.']);
    //     }
    // }

    public function excluirDocumento(Request $request, $nrSequence)
{
    // Obtém o token de autenticação do usuário atual
    $token = $request->session()->get('token');
    
    try {
        // Envia uma solicitação DELETE para a API para excluir o documento com o número de sequência especificado
        $response = ApiSgvp::withToken($token)->delete('/documento/'. $nrSequence);

        // Verifica se o status da resposta está entre 200 e 299, que são considerados códigos de sucesso
        if ($response->status() >= 200 && $response->status() < 300) {
            // Redireciona para a lista de documentos com uma mensagem de sucesso
            return redirect()->route('sessao.gerenciar', ['nrSequence' => $nrSequence])->with('mensagem', 'Documento excluído com sucesso!');
        } else {
            // Tentar extrair uma mensagem de erro da resposta da API
            $error = json_decode($response->body(), true);
            $errorMessage = isset($error['message']) ? $error['message'] : 'Não foi possível excluir o documento.';
            
            // Redireciona para a lista de documentos com uma mensagem de erro
            return redirect()->route('sessao.gerenciar', ['nrSequence' => $nrSequence])->withErrors(['erro' => $errorMessage]);
        }
    } catch (Exception $e) {
        // Redireciona para a lista de documentos com uma mensagem de erro
        return redirect()->route('sessao.gerenciar', ['nrSequence' => $nrSequence])->withErrors(['erro' => 'Houve um erro ao excluir o documento: ' . $e->getMessage()]);
    }
}



    


    



    
    






    public function cadRoteiro($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                
                if ($response->successful()) {
                    $sessao = $response->json();
                    
                    $response = ApiSgvp::withToken($token)->get('/roteiro?nrSeqSessao='.$nrSequence);
                        if ($response->successful()) {
                            $roteiro = $response->json();
                            return view('sessao.gerenciar.roteiro.cadastrar', compact('sessao', 'token', 'roteiro'));
                        } else {
                        return redirect()->route('documento.cadastrar')->withErrors('Houve um erro ao obter as informações dos documentos.');
                    }
                } else {
                    return redirect()->route('documento.cadastrar')->withErrors('Houve um erro ao obter as informações da sessão.');
                }
            } catch (Exception $e) {
                return redirect()->route('documento.cadastrar')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function cadastrarRoteiro(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dto.docRoteiro' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('roteiro.cadastrar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])
                ->withErrors($validator)
                ->withInput();
        }
        
        $dados_formulario = $request->input('dto');
       
        // Adicione os dados da sessão ao formulário
        $dados_formulario['nrSeqSessao'] = [
            'nrSequence' => $request->input('nrSeqSessao.nrSequence'),
        ];
        //  dd($dados_formulario);
        if ($request->hasFile('dto.docRoteiro')) {
            $docRoteiro = $request->file('dto.docRoteiro');

            // salva o PDF na pasta de uploads e obtém o caminho do PDF salvo
            $caminho_pdf = $docRoteiro->store('uploads', 'uploads');

            // adiciona o caminho do PDF aos dados do formulário
            $dados_formulario['docRoteiro'] = $caminho_pdf;
        }

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = ApiSgvp::withToken($token)->post('/roteiro', $dados_formulario);
            // dd($dados_formulario);

            if ($response->successful()) {
                // Redirecione para a lista de documentos com uma mensagem de sucesso
                return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->with('mensagem', 'Documento cadastrado com sucesso!');
            } else {
                // Redirecione para o formulário de cadastro com uma mensagem de erro
                return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Não foi possível cadastrar o documento.']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de cadastro com uma mensagem de erro
            return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Houve um erro ao cadastrar o documento.']);
        }
    }

    public function editRoteiro($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                // Busque as informações do documento a ser editado
                $response = ApiSgvp::withToken($token)->get('/roteiro?nrSequence='.$nrSequence);
                if ($response->successful()) {
                    $roteiro = $response->json();
                    // Busque as informações da sessão
                    $response = ApiSgvp::withToken($token)->get('/sessao?nrSequence='.$nrSequence);
                    
                    if ($response->successful()) {
                        $sessao = $response->json();
                        
                        if ($response->successful()) {
                            $perfil = $response->json();
                            return view('sessao.gerenciar.roteiro.editar', compact('sessao', 'token', 'roteiro'));
                        } else {
                            return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações dos perfis de usuários.');
                        }
                    } else {
                        return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações da sessão.');
                    }
                } else {
                    return redirect()->route('sessao.index')->withErrors('Houve um erro ao obter as informações do documento.');
                }
            } catch (Exception $e) {
                return redirect()->route('sessao.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

    public function atualizarRoteiro(Request $request, $nrSequence)
    {
        $validator = Validator::make($request->all(), [
            'dto.docRoteiro' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/roteiro/'. $nrSequence.'/editar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');
        //  dd($dados_formulario);
        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');
        
        if ($request->hasFile('dto.docRoteiro')) {
            $docRoteiro = $request->file('dto.docRoteiro');

            // salva o PDF na pasta de uploads e obtém o caminho do PDF salvo
            $caminho_pdf = $docRoteiro->store('uploads', 'uploads');

            // adiciona o caminho do PDF aos dados do formulário
            $dados_formulario['docRoteiro'] = $caminho_pdf;
        }
        // Envie os dados para a API
        try {
            // $response = ApiSgvp::withToken($token)->put('/documento/'. $nrSequence);
            $response = ApiSgvp::withToken($token)->put('/roteiro/'. $nrSequence, $dados_formulario);
            //   dd($dados_formulario);
            if ($response->successful()) {
                return redirect('/roteiro/'. $nrSequence .'/editar')->with('mensagem', 'Sessão atualizada com sucesso!');
            } else {
                // Redirecione para o formulário de edição com uma mensagem de erro
                return redirect('/roteiro/'. $nrSequence .'/editar')->withErrors(['erro' => 'Não foi possível atualizar a sessão!']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de edição com uma mensagem de erro
            return redirect('/roteiro/'. $nrSequence .'/editar')->withErrors(['erro' => 'Houve um erro ao atualizar a sessão.']);
        }
    }

    public function excluirRoteiro(Request $request, $nrSequence)
    {
        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');
        
        try {
            // Envia uma solicitação DELETE para a API para excluir o documento com o número de sequência especificado
            $response = ApiSgvp::withToken($token)->delete('/roteiro/'. $nrSequence);
            
            if ($response->successful()) {
                // Redireciona para a lista de documentos com uma mensagem de sucesso
                return redirect()->route('sessao.index')->with('mensagem', 'Documento excluído com sucesso!');
                // return redirect('/sessao/'. $nrSequence .'/gerenciar')->with('mensagem', 'Sessão atualizada com sucesso!');
            } else {
                // Redireciona para a lista de documentos com uma mensagem de erro
                return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Não foi possível excluir o documento.']);
            }
        } catch (Exception $e) {
            // Redireciona para a lista de documentos com uma mensagem de erro
            return redirect()->route('sessao.gerenciar', ['nrSequence' => $request->input('nrSeqSessao.nrSequence')])->withErrors(['erro' => 'Houve um erro ao excluir o documento.']);
        }
    }

    public function updateStatus(Request $request, $nrSequence)
    {
        $token = session('token');
        $newStatus = $request->input('status');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->put("https://sgvp-backend-api.herokuapp.com/api/sessao/{$nrSequence}/atualiza-status", [
                    'statusSessao' => $newStatus
                ]);

                if ($response->successful()) {
                    return redirect()->back()->with('success', 'Status atualizado com sucesso!');
                } else {
                    $errorMessage = $response->json('message') ?? 'Houve um erro ao atualizar o status.';
                    return redirect()->back()->withErrors($errorMessage);
                }
            } catch (Exception $e) {
                return redirect()->back()->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            return redirect()->route('login');
        }
    }

    










   
}
