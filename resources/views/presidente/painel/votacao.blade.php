<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0">  --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Sitema - Votação</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
<link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/custom-counter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/painel.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/cards/card.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/components/custom-counter.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/painel.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ url('assets/css/clock.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/presidente.css') }}" rel="stylesheet" type="text/css" />
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>



<body style="background-color: #060818; width: 100%; height: 100%;">
    <div class="">
        <div class="row d-flex flex-column ">
            <div class="col-xl-12 col-lg-1 col-md-12 col-12 layout-spacing">

                <div class="col d-flex justify-content-between  mt-3">
                    @if (empty($sessaoAutorizada))
                        <div class=" px-5">
                            <h1 class="text-uppercase" style="color: white;">Não há nenhuma sessao.</h1>
                        </div>
                    @else
                        @foreach ($sessaoAutorizada as $sessao)
                            <div class=" px-5">
                                <h1 class="text-uppercase" style="color: white;">{{ $sessao['nomeSessao'] }}</h1>
                            </div>
                        @endforeach
                    @endif

                    <div class="d-flex px-3">
                        <h1 id="dataAtual" style="color: white;"></h1>
                    </div>

                </div>

            </div>


        </div>
        <div class="row d-flex justify-content-center">


            <h1 class="d-flex justify-content-center text-uppercase" style="color: white;">
                {{ $statusVoto['estatistica']['documentoName'] }}
            </h1>

        </div>
        <div class="row">
            <div class="col d-flex justify-content-center">
                @if ($statusVoto['estatistica']['resultado'] === null)
                    <h1 class="d-flex justify-content-center" style="color: white;">Em Votação</h1>
                @elseif ($statusVoto['estatistica']['resultado'] === 'APROVADO')
                    <div class="d-flex justify-content-center">
                        <button type=" button" class="btn btn-success  mb-4 mr-2 btn-lg" data-toggle="modal"
                            data-target="#fadeleftModal">
                            {{ $statusVoto['estatistica']['resultado'] }}
                        </button>
                    </div>
                @elseif ($statusVoto['estatistica']['resultado'] === 'REPROVADO')
                    <div class="d-flex justify-content-center ">
                        <button type=" button" class="btn btn-block btn-danger  mb-4 mr-2 btn-lg" data-toggle="modal"
                            data-target="#fadeleftModal">
                            {{ $statusVoto['estatistica']['resultado'] }}
                        </button>
                    </div>
                @endif
            </div>

            <div class="d-flex mr-5">
                <button type=" button" class="btn btn-block btn-danger warning finalizarvotacao mb-4 mr-2 btn-lg">
                    ENCERRAR VOTAÇÃO
                </button>
            </div>

        </div>




    </div>
    <div class="row  px-1">

        <div class="d-flex justify-content-between col-10 row layout-top-spacing">
            @foreach ($usuariosOrdenados as $vereador)
                <div id="card_4" class="col-lg-4 layout-spacing px-3">
                    <div id="" class="px-5">
                        @if ($vereador['voto'] === 'NAO')
                            <div id="card-vereadores-voto-nao">
                                <div class="">
                                    <img alt="avatar" src="{{ asset('uploads/' . $vereador['foto']) }}"
                                        id="vereador-voto-nao" width="130" height="130" />
                                </div>
                                <div class="px-3 mt-4">
                                    <h5 class="text-uppercase" style="color: white;">
                                        {{ $vereador['nomeCompleto'] }}</h5>
                                    <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}</p>
                                </div>
                            </div>
                        @elseif($vereador['voto'] === 'SIM')
                            <div id="card-vereadores">
                                <div class="">
                                    <img alt="avatar" src="{{ asset('uploads/' . $vereador['foto']) }}"
                                        id="vereador-online" width="130" height="130" />
                                </div>
                                <div class="px-3 mt-4">
                                    <h5 class="text-uppercase" style="color: white;">
                                        {{ $vereador['nomeCompleto'] }}</h5>
                                    <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}</p>
                                </div>
                            </div>
                        @elseif($vereador['voto'] === 'ABSTER')
                            <div id="card-vereadores-voto-absteve">
                                <div class="">
                                    <img alt="avatar" src="{{ asset('uploads/' . $vereador['foto']) }}"
                                        id="vereador-voto-absteve" width="130" height="130" />
                                </div>
                                <div class="px-3 mt-4">
                                    <h5 class="text-uppercase" style="color: white;">
                                        {{ $vereador['nomeCompleto'] }}</h5>
                                    <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div id="card-vereadores-offline">
                                <div class="">
                                    <img alt="avatar" src="{{ asset('uploads/' . $vereador['foto']) }}"
                                        id="vereador-offline" width="130" height="130" />
                                </div>
                                <div class="px-3 mt-4">
                                    <h5 class="text-uppercase" style="color: white;">
                                        {{ $vereador['nomeCompleto'] }}</h5>
                                    <p class="text-uppercase" style="color: white;">{{ $vereador['partido'] }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>

        <div class="col-lg-2 mt-4">
            <div class="clock-container-painel">
                <h5 id="title">Relógio</h5>
                <div id="clock"></div>
                <h5 id="countdown-title">Sessão</h5>
                <div id="countdown"></div>
            </div>
            <div class="mt-5 align-text-center">
                <div class="mt-3 mb-5">
                    <button id="btn-custom" type=" button"
                        class="btn  btn-block  mb-4 mr-2 d-flex justify-content-between" data-toggle="modal"
                        data-target="#fadeleftModal">
                        <span>PRESENTES</span>
                        <span> {{ $vereadoresOn }}</span>
                    </button>

                    <button id="btn-custom" type=" button"
                        class="btn  btn-block  mb-4 mr-2 d-flex justify-content-between" data-toggle="modal"
                        data-target="#fadeleftModal">
                        <span>AUSENTES</span>
                        <span>{{ $total_vereadores - $vereadoresOn }}</span>

                    </button>
                </div>



                <button type=" button" class="btn btn-success btn-block mb-4 mr-2 d-flex justify-content-between"
                    data-toggle="modal" data-target="#fadeleftModal"><span> SIM</span>
                    <span>{{ $statusVoto['estatistica']['sim'] }}</span>
                </button>
                <button type="button" class="btn btn-danger btn-block mb-4 mr-2  d-flex justify-content-between"
                    data-toggle="modal" data-target="#fadeleftModal"><Span> NÃO</Span>
                    <span>{{ $statusVoto['estatistica']['nao'] }}</span>
                </button>
                <button type="button" class="btn btn-warning btn-block mb-4 mr-2  d-flex justify-content-between"
                    data-toggle="modal" data-target="#fadeleftModal">
                    <span>ABSTEVE</span>
                    <span>{{ $statusVoto['estatistica']['absteve'] }}</span>
                </button>
                <button type="button" class="btn btn-primary btn-block mb-4 mr-2  d-flex justify-content-between"
                    data-toggle="modal" data-target="#fadeleftModal">
                    <span>TOTAL DE VOTOS</span>
                    <span>{{ $statusVoto['estatistica']['totalVotos'] }}</span>
                </button>
            </div>

            <div class="row mt-5">
                <div class=" col-10 ">

                </div>
            </div>
        </div>

        <script>
            // Cria uma nova instância de WebSocket
            const socket = new WebSocket('ws://sgvp-backend-api.herokuapp.com/ws/usuarioVotou');

            // Manipulador de evento para quando a conexão é estabelecida
            socket.onopen = function() {
                console.log('Conexão estabelecida com sucesso!');
            };

            // Manipulador de evento para receber mensagens do servidor
            socket.onmessage = function(event) {
                if (event.data === "VOTACAO") {

                    function getUrl() {
                        var url = 'http://sgvp-laravel.test/painel/votacao';
                        return url
                    }

                    const redirection = getUrl();

                    window.location.href = redirection;

                }

            }
            // console.log('Mensagem recebida:', event.data);

            // Atualizar a página aq  localStorage.clear();
            location.reload();
            };

            // Manipulador de evento para lidar com erros
            socket.onerror = function(error) {
                console.error('Erro WebSocket:', error);
            };

            // Manipulador de evento para lidar com o fechamento da conexão
            socket.onclose = function() {
                console.log('Conexão fechada.');


            };
        </script>
        <script>
            function updateTime() {
                const now = new Date();
                const hours = now.getHours();
                const minutes = now.getMinutes();
                const seconds = now.getSeconds();
                document.getElementById('clock').textContent =
                    `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;
            }

            function padNumber(number) {
                return number.toString().padStart(2, '0');
            }

            setInterval(updateTime, 1000);
        </script>
        <!-- ============================================================== -->
        <!-- Start CRONÔMETRO here -->
        <!-- ============================================================== -->
        <script>
            // Get the end time
            const endTime = new Date();
            endTime.setHours(endTime.getHours() + 4);

            function updateCountdown() {
                const now = new Date();
                let diff = endTime - now;

                // Calculate hours, minutes, and seconds
                let hours = Math.floor(diff / 1000 / 60 / 60);
                diff -= hours * 1000 * 60 * 60;
                let minutes = Math.floor(diff / 1000 / 60);
                diff -= minutes * 1000 * 60;
                let seconds = Math.floor(diff / 1000);

                // Update the countdown
                document.getElementById('countdown').textContent =
                    `${padNumber(hours)}:${padNumber(minutes)}:${padNumber(seconds)}`;
            }

            // Call updateCountdown() once at first to avoid delay
            updateCountdown();
            setInterval(updateCountdown, 1000);
        </script>
        <script src="{{ url('assets/js/calendario.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- <script>
            // Imediatamente invocado função de expressão para evitar poluir o escopo global
            (function() {
                const refreshInterval = 5000; // 5 segundos

                setInterval(function() {
                    $.get('/tribuna/vereadorAtual', function(data) {
                        // Atualize o elemento #nomeVereador com o novo nome
                        $('#nomeVereador').text(data.nomeVereador);
                    });
                }, refreshInterval);
            })();
        </script> --}}
        <script src="{{ url('assets/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
        <script src="{{ url('assets/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
        {{-- <script>
            $('.warning.finalizarvotacao').on('click', function() {
                console.log('Botão clicado'); // Verificar se isso aparece no console
                swal({
                    title: 'ENCERRAR VOTAÇÃO?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'CANCELAR',
                    confirmButtonText: 'SIM',
                    padding: '2em',
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.value) {
                        var documentos = @json($documentos);
                        console.log('Documentos: ', documentos); // Log documentos no console

                        // Obter o primeiro documento a partir dos valores do objeto
                        var firstDocumento = null;
                        for (var key in documentos) {
                            if (documentos.hasOwnProperty(key)) {
                                firstDocumento = documentos[key];
                                break; // Encerra o loop, já que encontramos o primeiro documento
                            }
                        }

                        // Se encontramos um documento, e ele tem a propriedade nrSequence
                        if (firstDocumento && firstDocumento.hasOwnProperty('nrSequence')) {
                            var nrSequence = firstDocumento.nrSequence;
                            console.log('NrSequence do primeiro documento: ',
                                nrSequence); // Log nrSequence no console
                            window.location.href = '/presidente/encerrarvotacao/' + nrSequence;
                        } else {
                            console.log('Documento não possui nrSequence ou não há documentos disponíveis.');
                        }
                    }
                });
            });
        </script> --}}

        <script>
            $('.warning.finalizarvotacao').on('click', function() {
                console.log('Botão clicado');

                var socket = new WebSocket('ws://sgvp-backend-api.herokuapp.com/ws/votacao');

                socket.onopen = function(event) {
                    console.log('Conexão WebSocket aberta');
                };

                socket.onclose = function(event) {
                    console.log('Conexão WebSocket fechada');
                };

                swal({
                    title: 'ENCERRAR VOTAÇÃO?',
                    text: "",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'CANCELAR',
                    confirmButtonText: 'SIM',
                    padding: '2em',
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.value) {
                        socket.send('ENCERRAR_VOTACAO');
                        console.log('Mensagem ENCERRAR_VOTACAO enviada'); // Mensagem de confirmação

                        var documentos = @json($documentos);
                        console.log('Documentos: ', documentos);

                        var firstDocumento = null;
                        for (var key in documentos) {
                            if (documentos.hasOwnProperty(key)) {
                                firstDocumento = documentos[key];
                                break;
                            }
                        }

                        if (firstDocumento && firstDocumento.hasOwnProperty('nrSequence')) {
                            var nrSequence = firstDocumento.nrSequence;
                            console.log('NrSequence do primeiro documento: ', nrSequence);
                            window.location.href = '/presidente/encerrarvotacao/' + nrSequence;
                        } else {
                            console.log('Documento não possui nrSequence ou não há documentos disponíveis.');
                        }

                        socket.close();
                    }
                });
            });
        </script>




</body>

</html>
