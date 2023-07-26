<?php

namespace APP\Http\Controllers;

use App\Facades\ApiSgvp;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Ratchet\WebSocket\WsServer;
use React\Socket\Connector;

class PainelController extends Controller
{
    // public function index()
    // {
    //     $token = session('token');
    //     if($token){
    //         try{
    //         $query = 'perfil=PRESIDENTE&perfil=VEREADOR&status=ATIVO';
    //         $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);
    //         $total_vereadoresOnline = $this->getTotalVereadoresOnline($token);
    //         if($response->successful()){
    //            $res= ApiSgvp::withToken($token)->get('/sessao');
    //            if($res->successful()){
    //             $sessoes = $res->json();
               
    //             $sessaoAutorizada = array_filter($sessoes, function($sessao){
    //                 return $sessao['status'] == 'AUTORIZADA';
    //             });
    //            }
    //             $vereadores = $response->json();
    //             $total_vereadores = count($vereadores);
    //             return view('painel.index',[
    //                 'token'=> $token,
    //                 'total_vereadores' => $total_vereadores,
    //                 'vereadores' => $vereadores,
    //                 'sessoes' => $sessaoAutorizada,
    //                 'total_vereadoresOnline' => $total_vereadoresOnline,
    //             ]);
    //         }
    //         }
    //         catch(Exception $e){
    //         //   return redirect()->route('/');
    //         }
    //     }else{
    //         //  return redirect()->route('/');
    //     }
    // }

    public function index()
    {
        $token = session('token');
        if ($token) {
            try {
                $query = 'perfil=PRESIDENTE&perfil=VEREADOR&status=ATIVO';
                $response = ApiSgvp::withToken($token)->get('/usuarios?' . $query);
                $total_vereadoresOnline = $this->getTotalVereadoresOnline($token);
                
                if ($response->successful()) {
                    $res = ApiSgvp::withToken($token)->get('/sessao');
                    
                    if ($res->successful()) {
                        $sessoes = $res->json();
                        $sessaoAutorizada = array_filter($sessoes, function ($sessao) {
                            return $sessao['status'] == 'AUTORIZADA';
                        });
                    }
                    
                    $vereadores = collect($response->json())->sortBy('nomeCompleto')->values()->all();
                    $total_vereadores = count($vereadores);
                    
                    return view('painel.index', [
                        'token' => $token,
                        'total_vereadores' => $total_vereadores,
                        'vereadores' => $vereadores,
                        'sessoes' => $sessaoAutorizada,
                        'total_vereadoresOnline' => $total_vereadoresOnline,
                    ]);
                }
            } catch (Exception $e) {
                // return redirect()->route('/');
            }
        } else {
            // return redirect()->route('/');
        }
    }

    public function PainelVotação()
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

                    return view('painel.votacao', [
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

    public function PainelDiscussao()
    {
        $token = session('token');
        
        if($token) {
            //Dados que irei precisar ter no front 
            //Nome Sessão
            //Vereador com status de "Em fala"
            //Vereadores ausentes e presentes
            try{
                $sessaoAutorizada = $this->getSessoesAutorizadas($token);


                return view('painel.discussao',[
                    'token' => $token,
                    'sessaoAutorizada'=>$sessaoAutorizada
                ]);

            }catch(Expection $e){
                //Tr // return redirect()->route('/');
            }
        } else{
            //re
        }
    }


     private function getDocumentos($token, $sessoesAutorizadas)
    {


        try
        {
             $response = ApiSgvp::withToken($token)->get('/documento', [
                'nrSeqSessao' => implode(',', array_column($sessoesAutorizadas, 'nrSequence'))
        ]);
         if ($response->successful()) {
            return $response->json();
        }
           throw new Exception('Erro ao obter documentos.');
        }
          catch(Expection $e){}
       
     
    }

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

    
    private function getTotalVereadoresOnline($token)
    {
        $response = ApiSgvp::withToken($token)->get('/usuarios', [
            'perfil' => 'VEREADOR, PRESIDENTE',
            'statusOnline' => 'true',
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

}


   
