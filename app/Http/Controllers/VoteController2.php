<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VoteController extends Controller
{
    public function sendVote(Request $request)
    {
        $nrSequenceUsuario = $request->input('nrSequenceUsuario');
        $nrSequenceDocumento = $request->input('nrSequenceDocumento');
        $voto = $request->input('voto');

        // Envie a votação para a API usando o método POST do Laravel HTTP Client
        $response = Http::post('http://154.56.43.108:8080/api/voto', [
            'nrSequenceUsuario' => $nrSequenceUsuario,
            'nrSequenceDocumento' => $nrSequenceDocumento,
            'voto' => $voto,
        ]);

        // Verifique a resposta da API e retorne uma mensagem apropriada
        if ($response->successful()) {
            return response()->json(['message' => 'Votação enviada com sucesso']);
        } else {
            return response()->json(['message' => 'Erro ao enviar a votação'], 500);
        }
    }
}
