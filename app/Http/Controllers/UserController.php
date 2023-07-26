<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ApiSgvp;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use GuzzleHttp\Exception\RequestException;

use DataTables;

class UserController extends Controller
{
    public function getUsers()
    {
        $response = ApiSgvp::get('/usuarios');
        $data = json_decode($response->getBody());
    
        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                return view('usuarios._partials.action', ['usuario' => $row]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/usuarios');

                if ($response->successful()) {
                    $usuario = $response->json();
                    return view('usuarios.index', [
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

    public function show()
    {
       // Obtenha o token de acesso armazenado na sessão
       $token = session('token');

       if ($token) {
           try {
               $response = ApiSgvp::withToken($token)->get('/usuarios');

               if ($response->successful()) {
                   $usuario = $response->json();
                   return view('usuarios.cadastrar', [
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

    public function cadastrar(Request $request)
    {        
        $response = Http::post('http://154.56.43.108:8080/api/usuarios', $request->json());

        return response()->json([
            'success' => true,
            'message' => 'Usuário cadastrado com sucesso!',
            'data' => $response->json()
        ]);
    }

    // CPF e E-mail Único

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dto.nome' => 'required',
            'dto.email' => 'required',
            'dto.cargo' => 'required',
            'dto.perfil' => 'required',
            'dto.cpf' => 'required',
            'dto.senha' => 'required'
        ]);

        if ($validator->fails()) {
            
            return redirect()->route('usuarios.cadastrar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');

        if ($request->hasFile('dto.fotoPerfil')) {
            $imagem = $request->file('dto.fotoPerfil');

            // salva a imagem na pasta de uploads e obtém o caminho da imagem salva
            $caminho_imagem = $imagem->store('uploads', 'uploads');

            // adiciona o caminho da imagem aos dados do formulário
            $dados_formulario['fotoPerfil'] = $caminho_imagem;
        }

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = Http::withToken($token)
                ->withHeaders(['Accept' => 'application/json'])
                ->post('http://154.56.43.108:8080/api/usuarios', $dados_formulario);
             
            if ($response->successful()) {
                // Redirecione para a lista de usuários com uma mensagem de sucesso
                return redirect()->route('usuarios.index')->with('mensagem', 'Usuário cadastrado com sucesso!');
            } else {
                // Redirecione para o formulário de cadastro com uma mensagem de erro
                return redirect()->route('usuarios.cadastrar')->withErrors(['erro' => 'Usuário já cadastrado!']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de cadastro com uma mensagem de erro
            return redirect()->route('usuarios.cadastrar')->withErrors(['erro' => 'Houve um erro ao cadastrar o usuário.']);
        }
    }

    // public function edit($nrSequence)
    // {
    //     // Obtenha o token de acesso armazenado na sessão
    //     $token = session('token');

    //     if ($token) {
    //         try {
    //             $response = ApiSgvp::withToken($token)->get('/usuarios?nrSequence='.$nrSequence);
    //             if ($response->successful()) {
    //                 $usuario = $response->json();

    //                 return view('usuarios.editar', compact('usuario', 'token'));
    //             } else {
    //                 return redirect()->route('usuarios.index')->withErrors('Houve um erro ao obter as informações do usuário.');
    //             }
    //         } catch (Exception $e) {
    //             return redirect()->route('usuarios.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
    //         }
    //     } else {
    //         // Retorne a página de login se o usuário não estiver autenticado
    //         return redirect()->route('login');
    //     }
    // }

    public function edit($nrSequence)
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/usuarios?nrSequence='.$nrSequence);
                if ($response->successful()) {
                    $usuario = $response->json();

                    // Verifica se a chave 'fotoPerfil' está presente no array $usuario
                    if (isset($usuario['fotoPerfil'])) {
                        $usuario['fotoPerfil'] = 'uploads/' . $usuario['fotoPerfil'];
                    }
                    

                    return view('usuarios.editar', compact('usuario', 'token'));
                } else {
                    return redirect()->route('usuarios.index')->withErrors('Houve um erro ao obter as informações do usuário.');
                }
            } catch (Exception $e) {
                return redirect()->route('usuarios.index')->withErrors('Erro ao se conectar à API. Por favor, verifique sua conexão e tente novamente.');
            }
        } else {
            // Retorne a página de login se o usuário não estiver autenticado
            return redirect()->route('login');
        }
    }

  

    public function update(Request $request, $nrSequence)
    {
        $validator = Validator::make($request->all(), [
            'dto.nome' => 'required',
            'dto.email' => 'required',
            'dto.cargo' => 'required',
            'dto.perfil' => 'required',
            'dto.cpf' => 'required',
            'dto.senha' => 'nullable',
            'dto.fotoPerfil' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect('/usuarios/'. $nrSequence.'/editar')
                ->withErrors($validator)
                ->withInput();
        }

        $dados_formulario = $request->input('dto');
// dd($dados_formulario);
        if ($request->hasFile('dto.fotoPerfil')) {
            $imagem = $request->file('dto.fotoPerfil');

            // salva a imagem na pasta de uploads e obtém o caminho da imagem salva
            $caminho_imagem = $imagem->store('uploads', 'uploads');

            // adiciona o caminho da imagem aos dados do formulário
            $dados_formulario['fotoPerfil'] = $caminho_imagem;
        }

        // Obtém o token de autenticação do usuário atual
        $token = $request->session()->get('token');

        // Envie os dados para a API
        try {
            $response = Http::withToken($token)
                ->withHeaders(['Accept' => 'application/json'])
                ->put('http://154.56.43.108:8080/api/usuarios/' . $nrSequence, $dados_formulario);

            if ($response->successful()) {
                return redirect('/usuarios/'. $nrSequence .'/editar')->with('mensagem', 'Usuário atualizado com sucesso!');
            } else {
                // Redirecione para o formulário de edição com uma mensagem de erro
                return redirect('/usuarios/'. $nrSequence .'/editar')->withErrors(['erro' => 'Não foi possível atualizar o usuário!']);
            }
        } catch (Exception $e) {
            // Redirecione para o formulário de edição com uma mensagem de erro
            return redirect('/usuarios/'. $nrSequence .'/editar')->withErrors(['erro' => 'Houve um erro ao atualizar o usuário.']);
        }
    }

    






    


}