<?php

namespace App\Http\Controllers;

use App\Events\ModalVota;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function openModal(Request $request)
    {
        $titulo = $request->input('titulo'); // Obtém o título do request
        $nrSequenceDocumento = $request->input('nrSequenceDocumento'); // Adicione esta linha para obter nrSequenceDocumento do request

        // Emitir o evento do Pusher para retransmitir aos demais clientes
        event(new ModalVota(['message' => 'O modal foi aberto!', 'titulo' => $titulo, 'nrSequenceDocumento' => $nrSequenceDocumento])); // Adicione nrSequenceDocumento aqui

        return response()->json(['message' => 'Evento acionado']);
    }
}
