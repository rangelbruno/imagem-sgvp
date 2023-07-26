<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\ApiSgvp;

class DocumentoController extends Controller
{
    public function index()
    {
        // Obtenha o token de acesso armazenado na sessão
        $token = session('token');

        if ($token) {
            try {
                $response = ApiSgvp::withToken($token)->get('/usuarios');
                if ($response->successful()) {
                    $usuario = $response->json();
                    return view('documento.index', [
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
}
